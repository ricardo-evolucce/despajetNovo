<?php

namespace App\Servicos\Nfe;

use Adbar\Dot;
use App\Servicos\Servico;
use DateInterval;
use DateTime;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;
use SoapClient;

class AbacoServico extends Servico
{
     private const URL = 'https://www.e-nfs.com.br/e-nfs_canoas/servlet'; // producao
	//private const URL = 'https://enfs-hom.abaco.com.br/canoas/servlet'; // teste


	public function gerarNumeroSerie($intevalo_meses = 1, $numero_adicao=1, $serie_adicao=1)
	{
		$continuar_loop = true;
		$limite = 12;
		do {
			$nfs_ano = $this->buscarNfsMeses($intevalo_meses);
			$xml_array = $this->xml2array($nfs_ano);

			$intevalo_meses += 1;
			$continuar_loop = isset($xml_array['ListaMensagemRetorno']['MensagemRetorno']['Correcao']) && $intevalo_meses<$limite;

		} while ($continuar_loop);

		$todas = $xml_array['ListaNfse']['CompNfse'];
		$numeros_existentes = [];
		$series_existentes = [];

		foreach ($todas as $i => $cada) {
            $base = $cada['Nfse']['InfNfse'];
            // $base = $cada['InfNfse'];
			$numeros_existentes[] = (int) $base['IdentificacaoRps']['Numero'];
			$series_existentes[] = (int) $base['IdentificacaoRps']['Serie'];
		}

		sort($numeros_existentes);
		sort($series_existentes);

		$maior_num = array_pop($numeros_existentes);
		$maior_serie = array_pop($series_existentes);

		if($maior_num<1 || $maior_serie<1){
			return $this->gerarNumeroSerie($intevalo_meses);
		}

		return [
			'numero' => $maior_num+$numero_adicao,
			'serie' => $maior_serie+$serie_adicao
		];
	}

	public function transmitir($nfs_assinado)
	{
		$servico = '/arecepcionarloterps';

		$endpoint = self::URL . $servico;
		$wsdl = $endpoint . '?wsdl';
		$options = $this->getOptions($endpoint);
		$client = new SoapClient($wsdl, $options);
		$arguments = $this->getArguments($nfs_assinado);
		$result = $this->executarWS($client, $arguments);
		return $result;
	}

	public function consultarSituacaoLoteRps($protocolo)
	{
		$servico = '/aconsultarsituacaoloterps';

		$endpoint = self::URL . $servico;
		$wsdl = $endpoint . '?wsdl';
		$options = $this->getOptions($endpoint);
		$client = new SoapClient($wsdl, $options);

		$xml = '
			<ConsultarSituacaoLoteRpsEnvio>
				<Protocolo>'.$protocolo.'</Protocolo>
			</ConsultarSituacaoLoteRpsEnvio>
		';
		$arguments = $this->getArguments($xml);
		$result = $this->executarWS($client, $arguments);
		return $result;
	}

	public function buscarNfsMeses($data_inicio_intervalo = 1)
	{
		$servico = '/aconsultarnfse';
		$endpoint = self::URL . $servico;
		$wsdl = $endpoint . '?wsdl';
		$options = $this->getOptions($endpoint);
		$client = new SoapClient($wsdl, $options);

		//essa logica pra buscar sempre os ulimos 3 meses a partir de hoje ou do intervalo passado
		$data_fim_intervalo = $data_inicio_intervalo<1 ? 1 : $data_inicio_intervalo-1;
		$data_fim = (new Datetime())->sub(new DateInterval("P{$data_fim_intervalo}M"))->format('c');
		$data_inicio = (new Datetime())->sub(new DateInterval("P{$data_inicio_intervalo}M"))->format('c');

		$xml = "
			<ConsultarNfsEnvio>
				<Prestador>
					<Cnpj>19868274000125</Cnpj>
					<InscricaoMunicipal>6869039</InscricaoMunicipal>
				</Prestador>
				<PeriodoEmissao>
					<DataInicial>$data_inicio</DataInicial>
					<DataFinal>$data_fim</DataFinal>
				</PeriodoEmissao>
			</ConsultarNfsEnvio>
		";
		$arguments = $this->getArguments($xml);
		$result = $this->executarWS($client, $arguments);
		return $result;
	}

	public function consultarNotaPorRps($numero, $serie)
	{
		$servico = '/aconsultarnfseporrps';

		$endpoint = self::URL . $servico;
		$wsdl = $endpoint . '?wsdl';
		$options = $this->getOptions($endpoint);
		$client = new SoapClient($wsdl, $options);

		$xml = "
				<ConsultarNfseRpsEnvio>
					<IdentificacaoRps>
						<Numero>$numero</Numero>
						<Serie>$serie</Serie>
						<Tipo>1</Tipo>
					</IdentificacaoRps>
					<Prestador>
						<Cnpj>19868274000125</Cnpj>
						<InscricaoMunicipal>6869039</InscricaoMunicipal>
					</Prestador>
				</ConsultarNfseRpsEnvio>
			";
		$arguments = $this->getArguments($xml);
		$result = $this->executarWS($client, $arguments);
		return $result;
	}

	public function consultarNotasPorLote($lote)
	{
		$servico = '/aconsultarloterps';


		$endpoint = self::URL . $servico;
		$wsdl = $endpoint . '?wsdl';
		$options = $this->getOptions($endpoint);
		$client = new SoapClient($wsdl, $options);

        $xml = "
            <ConsultarLoteRpsEnvio>
                <Prestador>
                    <Cnpj>19868274000125</Cnpj>
                    <InscricaoMunicipal>6869039</InscricaoMunicipal>
                </Prestador>
                <Protocolo>$lote</Protocolo>
            </ConsultarLoteRpsEnvio>
        ";

		$arguments = $this->getArguments($xml);
		$result = $this->executarWS($client, $arguments);
		return $result;
	}

	private function executarWS($client, $arguments)
	{
		try {
			$result = $client->Execute($arguments);
		} catch (\Throwable $th) {
			return false;
		}
		return $result->Outputxml;
	}

	private function getArguments($nfsedadosmsg)
	{
		$arguments = [
			'Nfsecabecmsg' => $this->getNfsecabecmsg(),
			'Nfsedadosmsg' => $nfsedadosmsg
		];
		return $arguments;
	}

	private function getOptions($endpoint)
	{
		$certificado = $this->getCertificado();
		$certificado_path = $certificado['full_path'];
		$senha = $certificado['senha'];

		$options = [
			'location' => $endpoint,
			'local_cert' => $certificado_path,
			'passphrase' => $senha,
			'cache_wsdl' => WSDL_CACHE_NONE,
			'stream_context' => stream_context_create([
				'ssl' => [
					'verify_peer' => false,
				]
			])
		];
		return $options;
	}

	private function getNfsecabecmsg()
	{
		$cab = '<cabecalho xmlns="http://www.e-nfs.com.br" versao="201001">
							<versaoDados>V2010</versaoDados>
						</cabecalho>
		';

		return  $cab;
	}

	public function pegarErroRetornoWs(array $retorno)
	{
		// $erro_consulta = isset($retorno['ListaMensagemRetorno']['MensagemRetorno']['Codigo']) && substr($retorno['ListaMensagemRetorno']['MensagemRetorno']['Codigo'],0,1) != 'E' ? $retorno['ListaMensagemRetorno']['MensagemRetorno'] : null  ;
		$erro_consulta = $retorno['ListaMensagemRetorno']['MensagemRetorno'] ?? null  ;
		return $erro_consulta;
	}

	protected function getCertificado()
	{
        $storage_path = implode(DIRECTORY_SEPARATOR, ['nfe','certificado', 'certificado-despajet-a1.pem']);
        $full_path = storage_path('app'.DIRECTORY_SEPARATOR.$storage_path);
        $certificado = Storage::get($storage_path);

		$certificado = [
			'full_path' => $full_path,
			'storage_path' => $storage_path,
            'file' => $certificado,
			'senha' => '991287270',
		];

		return $certificado;

	}


}
