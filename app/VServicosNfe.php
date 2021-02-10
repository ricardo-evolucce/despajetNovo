<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use App\Loja;
use App\Tiposervico;

class VServicosNfe extends Model
{

	public $table = 'v_servicos_nfe';
	public $timestamps = false;

    protected $dates = ['data'];

    public function setChassiAttribute($value)
    {
        $this->attributes['chassi'] = strtoupper($value);
    }

    public function setModeloAttribute($value)
    {
        $this->attributes['modelo'] = strtoupper($value);
    }

    public function setPlacaAttribute($value)
    {
        $this->attributes['placa'] = strtoupper($value);
    }

    public function setRenavamAttribute($value)
    {
        $this->attributes['renavam'] = strtoupper($value);
    }

	public function cliente()
	{
		return $this->belongsTo(Cliente::class);
	}

	public function loja()
	{
		return $this->belongsTo(Loja::class);
	}

	public function lojaame()
	{
		return $this->belongsTo(Loja::class);
	}

	public function tiposervico()
	{
		return $this->belongsTo(Tiposervico::class);
	}




}

?>
