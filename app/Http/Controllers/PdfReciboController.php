<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servico;
use PDF;
use WGenial\NumeroPorExtenso\NumeroPorExtenso;


class PdfReciboController extends Controller
{
    public function geraRecibo(){

    	

    	  $servicos = Servico::all();
    	  $servico = $servicos->find(2);  

    	  $valorTotal = $servico->valorServico + $servico->ValorGuia + $servico->valorOutros;

    	  $valorExtenso = new NumeroPorExtenso;
    	  $valorExtenso = $valorExtenso->converter($valorTotal);

    	  $servico->valorServico = number_format($servico->valorServico,2,",","."); 
    	  $servico->valorOutros = number_format($servico->valorOutros,2,",","."); 
    	  $valorTotal = number_format($valorTotal,2,",","."); 


  
    	
    	$pdf = PDF::loadView('recibo.index' , compact('servico', 'valorExtenso', 'valorTotal'));

    	return $pdf->setPaper('a4')->stream('recibo.pdf');

    }
}
