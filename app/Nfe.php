<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use App\Loja;
use App\Tiposervico;

class Nfe extends Model
{

	public $table = 'nfe';
	public $timestamps = false;

	protected $fillable = ['id', 'numero', 'protocolo', 'data_recebimento', 'xml'];

    // public function servicos()
	// {
	// 	return $this->belongsTo(Cliente::class);
	// }

}

?>
