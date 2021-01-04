<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use App\Loja;
use App\Tiposervico;

class Servico extends Model
{
	
	public $timestamps = false;

	protected $dates = ['data'];

	protected $fillable = ['servico', 'tiposervico_id', 'cliente_id', 'chassi', 'modelo', 'trocaPlaca', 'placa', 'renavam', 'data',
	'loja_id', 'valorServico', 'servicoPago', 'valorGuia', 'guiaPago', 'valorIpva', 'ipvaPago', 
	'valorPlacaEsp', 'placaEspPago', 'valorOutros', 'outrosPago',
	'valorProvisorio', 'provisorioPago', 'numeroPedido', 'valorNfe', 'nfe_id', 'chassi', 'valorGuia',
	'guiaPago', 'valorPlacaEsp', 'placaEspPago', 'valorProvisorio', 'provisorioPago', 'carhouseOuCliente'
	];


	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function loja()
	{
		return $this->belongsTo(Loja::class);
	}

	public function tiposervico()
	{
		return $this->belongsTo(Tiposervico::class);
	}




}

?>