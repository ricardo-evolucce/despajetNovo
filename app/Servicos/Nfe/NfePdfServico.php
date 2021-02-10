<?php

namespace App\Servicos\Nfe;

use App\Servicos\Servico;

use Adbar\Dot;
use Illuminate\Support\Facades\Storage;

class NfePdfServico extends Servico
{
    public function gerar(array $notas)
	{
        $nfe_pdfs = [];
        foreach ($notas as $key => $nota) {
            $xml = $nota['xml'];
            $nfe_array = json_decode(json_encode(simplexml_load_string($xml)),true)['LoteRps']['ListaRps']['Rps']['InfRps'] ?? null;
            $nfe_array = $this->prepararDados($nfe_array, $nota);

            $nfe_array_dot = new Dot($nfe_array);

            $storage_path = implode(DIRECTORY_SEPARATOR, ['nfe', 'nfe_pdf_model.html']);
            $nfe_pdf = Storage::get($storage_path);

            preg_match_all("/\^|array->[^ ,.<]+/",$nfe_pdf,$matches);
            $flags = $matches[0];

            $infs = array_map(function ($flag) use ($nfe_array_dot) {
                $flag = trim(str_replace('->', '.', str_replace('array->', '', $flag)));
                return $nfe_array_dot->get($flag);
            },$flags);

            $nfe_pdfs[] = str_replace($flags, $infs, $nfe_pdf);
        }
        return $nfe_pdfs;
	}

	private function prepararDados(array $xml_array, $nota=null)
	{
		if($nota){
			$xml_array['numero'] = $nota['numero'];
			$xml_array['protocolo'] = $nota['protocolo'];
			$xml_array['Tomador']['Endereco']['Municipio'] = self::buscarMunicipioPorCep($xml_array['Tomador']['Endereco']['Cep'])->localidade ?? '';

            $servicos_discrimicacoes = explode(' / ',$xml_array['Servico']['Discriminacao']);

            foreach ($servicos_discrimicacoes as $i => $discriminacao) {
                $discriminacao = "<div>$discriminacao</div>";
                $servicos_discrimicacoes[$i] = $discriminacao;
            }

            $xml_array['servicos'] = implode('',$servicos_discrimicacoes);
		}
		$xml_array['NaturezaOperacao'] = 'Isento';
		$xml_array['DataEmissao'] = (new \Datetime($xml_array['DataEmissao']))->format('d/m/Y - H:i:s');
		return $xml_array;
	}

	private static function buscarMunicipioPorCep($cep)
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
