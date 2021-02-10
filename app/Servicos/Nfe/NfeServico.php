<?php

namespace App\Servicos\Nfe;

use Adbar\Dot;
use App\Nfe;
use DateInterval;
use DateTime;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

class NfeServico extends AbacoServico
{

    public $model;

    public function __construct(Nfe $model)
    {
        $this->model = $model;
    }

    public function agruparNotas(array $notas)
    {
        $agrupamentos = [];
        foreach ($notas as $key => $nota) {
            $tomador_id = $nota['tomador_id'];
            $nota_id = $nota['id'];
            $agrupamentos[$tomador_id][$nota_id] = $nota;
        }

        return $agrupamentos;
    }

	public function prepararDados(array $tomadores_notas)
	{
		foreach ($tomadores_notas as $tomador_id => $notas) {
            foreach ($notas as $nota_id => $nota) {
                $nota['valor'] = str_replace(',','.',$nota['valor']);
                $nota['descricao_servico_completa'] = "{$nota['nfe_descricao_padrao']} = R$ {$nota['valor']}";
                $nota['tomador_codigo_municipio'] = $this->buscarMunicipioPorCep($nota['tomador_cep'])->ibge;

                $notas[$nota_id] = $nota;
            }
            $tomadores_notas[$tomador_id] = $notas;
        }

		return $tomadores_notas;
	}

	public function gerar(array $tomador_notas)
	{
        $parte_rps = '';
        $num_serie = $this->gerarNumeroSerie();
        $rps_num_incremento = 0;
        $parte_rps .= $this->gerarParteRps($tomador_notas, $num_serie, $rps_num_incremento);
        $rps_num_incremento++;

        $nfs_base_file_path = implode(DIRECTORY_SEPARATOR, ['nfe','rps_partes_xml', 'parte_base.xml']);
        $nfs_base_xml = Storage::get($nfs_base_file_path);
        preg_match_all("/\^|array->[^ ,.<\"]+/", $nfs_base_xml, $matches_base);
        $flags_base = $matches_base[0];

        $base_dot = new Dot([
            'lote_num' => (new Datetime())->format('YmdHis'),
            'rps_quantidade' => 1,
            'parte_rps' => $parte_rps
        ]);

        $infs = array_map(function ($flags_base) use ($base_dot) {
            $flags_base = trim(str_replace('->', '.', str_replace('array->', '', $flags_base)));
            return $base_dot->get($flags_base);
        },$flags_base);

        $rps_xml = str_replace($flags_base, $infs, $nfs_base_xml);

		return $rps_xml;
	}

	public function gerarParteRps(array $notas, array $rps_num_serie, $rps_num_incremento)
	{
        $servicos_descricao = [];
        $total_nota = [];
        foreach ($notas as $nota_id => $nota) {
            $servicos_descricao[] = $nota['descricao_servico_completa'];
            $total_nota[]= $nota['valor'];
        }
        $nota['descricao_servico_completa'] = implode(' / ',$servicos_descricao);
        $nota['valor'] = array_sum($total_nota);

        $nota['data_emissao'] = (new DateTime())->sub(new DateInterval("PT15M"))->format('c');
        $nota['rps_num'] = $rps_num_serie['numero'] + $rps_num_incremento;
        $nota['rps_serie'] = $rps_num_serie['serie'];

        $nfs_rps_file_path = implode(DIRECTORY_SEPARATOR, ['nfe','rps_partes_xml','parte_rps.xml']);
        $nfs_rps_xml = Storage::get($nfs_rps_file_path);
        preg_match_all("/\^|array->[^ ,.<\"]+/", $nfs_rps_xml, $matches_rps);
        $flags_rps = $matches_rps[0];

        $nota_dot = new Dot($nota);
        $infs = array_map(function ($flag) use ($nota_dot) {
            $flag = trim(str_replace('->', '.', str_replace('array->', '', $flag)));
            return $nota_dot->get($flag);
        },$flags_rps);

        $parte_rps = str_replace($flags_rps, $infs, $nfs_rps_xml);
        return $parte_rps;
	}

	public function assinar($xml)
	{
		$certificado = $this->getCertificado();

		$doc = new DOMDocument();
		$doc->loadXML($xml);

		$objDSig = new XMLSecurityDSig('');
		$objDSig->setCanonicalMethod(XMLSecurityDSig::C14N);
		$objDSig->addReference($doc,  XMLSecurityDSig::SHA1,  ['http://www.w3.org/2000/09/xmldsig#enveloped-signature', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315'], ['force_uri'=>true, 'overwrite'=>false]);

		$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type'=>'private'));
		$objKey->passphrase = $certificado['senha'];
		$objKey->loadKey($certificado['full_path'], TRUE);

		$objDSig->sign($objKey);
		$objDSig->add509Cert($certificado['file']);
		$objDSig->appendSignature($doc->documentElement);
		// $objDSig->appendSignature($doc->documentElement->getElementsByTagName('Rps')->item(0));

		$xmlAssinado = $doc->saveXML();
		return $xmlAssinado;
	}

	public function gravarNoBD(array $resposta_ws, $num_nota_fiscal, $xml)
	{
        $dados = [
            'numero' => $num_nota_fiscal,
            'protocolo' => $resposta_ws['Protocolo'],
            'data_recebimento' => $resposta_ws['DataRecebimento'],
            'xml' => $xml
        ];

        $nfe = $this->model->create($dados);
		return $nfe;
	}

	private function buscarMunicipioPorCep($cep)
	{

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://viacep.com.br/ws/$cep/json/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		return json_decode($response);
	}


}
