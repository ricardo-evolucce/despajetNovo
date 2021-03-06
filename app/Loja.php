<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{

	public $timestamps = false;

	protected $fillable = ['id', 'nome', 'razaoSocial', 'cnpj', 'cep', 'logradouro', 'numero','complemento', 'bairro', 'municipio', 'estado','codigo_ibge'];

}

?>
