<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	
	public $timestamps = false;

	protected $fillable = ['id', 'cpf', 'rg', 'endereco', 'cidade', 'uf', 'nome',
	'telefone', 'celular', 'email', 'bairro', 'cep', 
	'numero', 'complemento'];

}

?>