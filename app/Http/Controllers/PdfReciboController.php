<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servico;
use PDF;
use WGenial\NumeroPorExtenso\NumeroPorExtenso;


class PdfReciboController extends Controller
{
    public function geraRecibo(Request $request){

    	

    	  $servicos = Servico::all();
    	  $servico = $servicos->find($request->id);  

    	  $valorTotal = $servico->valorServico + $servico->ValorGuia + $servico->valorOutros + $servico->valorIpva + $servico->valorProvisorio + $servico->valorPlacaEsp + $servico->valorPlaca;

    	  $valorExtenso = new NumeroPorExtenso;
    	  $valorExtenso = $valorExtenso->converter($valorTotal);

    	  $servico->valorServico = number_format($servico->valorServico,2,",","."); 
          $servico->valorGuia = number_format($servico->valorGuia,2,",","."); 
    	  $servico->valorOutros = number_format($servico->valorOutros,2,",","."); 
          $servico->valorIpva = number_format($servico->valorIpva,2,",","."); 
          $servico->valorProvisorio = number_format($servico->valorProvisorio,2,",","."); 
          $servico->valorPlacaEsp = number_format($servico->valorPlacaEsp,2,",","."); 
          $servico->valorPlaca = number_format($servico->valorPlaca,2,",","."); 
    	  $valorTotal = number_format($valorTotal,2,",","."); 


  
    	
    	$pdf = PDF::loadView('recibo.index' , compact('servico', 'valorExtenso', 'valorTotal'));

    	return $pdf->setPaper('a4')->stream('recibo.pdf');

    }
}
