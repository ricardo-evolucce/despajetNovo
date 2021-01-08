<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

	
    public function setEnderecoAttribute($value)
    {
        $this->attributes['endereco'] = strtoupper($value);
    }

    public function setCidadeAttribute($value)
    {
        $this->attributes['cidade'] = strtoupper($value);
    }

    public function setUfAttribute($value)
    {
        $this->attributes['uf'] = strtoupper($value);
    }

    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = strtoupper($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtoupper($value);
    }

    public function setBairroAttribute($value)
    {
        $this->attributes['bairro'] = strtoupper($value);
    }
	
	public $timestamps = false;



	protected $fillable = ['id', 'cpf', 'rg', 'endereco', 'cidade', 'uf', 'nome',
	'telefone', 'celular', 'email', 'bairro', 'cep', 
	'numero', 'complemento'];

	

}

?>