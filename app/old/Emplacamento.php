<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use App\Loja;

class Emplacamento extends Model
{
	
	public $timestamps = false;

	protected $dates = ['data'];

	protected $fillable = ['cliente_id', 'chassi', 'nfe', 'modelo', 'placa', 'renavam', 'data',
	'loja_id', 'valorGuia', 'guiaPago', 'valorIpva', 'ipvaPago', 
	'valorPlacaEsp', 'placaEspPago', 'valorOutros', 'outrosPago',
	'valorProvisorio', 'provisorioPago', 'numeroPedido', 'valorNfe', 'nfe_id'];


	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function loja()
	{
		return $this->belongsTo(Loja::class);
	}




}

?>