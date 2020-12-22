<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Emplacamento;
use App\Usado;
use Carbon\Carbon;

class GeralController extends Controller
{
    public function index(){


    	$emplacamentos = Emplacamento::where('data', Carbon::today())
    	->orderBy('renavam')
    	->get();


    	$usados = Usado::where('data', Carbon::today())
    	->orderBy('renavam')
    	->get();


        $dataHoje = Carbon::today();

        return view('geral.index', compact('emplacamentos', 'usados', 'dataHoje'));

    }
}
