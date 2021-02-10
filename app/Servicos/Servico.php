<?php

namespace App\Servicos;

class Servico
{
	public function xml2array($xml)
	{
		return json_decode(json_encode(simplexml_load_string($xml)), true);
	}

	public function imprimirXMLNaTela($xml)
	{
		header('Content-type: text/xml');
		echo $xml;
		die();
	}
}
