<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Loja;
use App\Tiposervico;
use App\Cliente;

class Usado extends Model
{
	
	public $timestamps = false;

	public $dates = ['data'];

	protected $fillable = ['cliente_id', 'modelo', 'placa', 'renavam', 'data',
	'loja_id', 'tiposervico_id', 'trocaPlaca', 'valorServico', 'valorIpva', 'valorOutros', 'valorNfe', 
	'servicoPago', 'ipvaPago', 'outrosPago', 'numeroPedido'];


	public function loja()
	{
		return $this->belongsTo(Loja::class);
	}



		public function tiposervico()
	{
		return $this->belongsTo(Tiposervico::class);
	}

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}




}

?>