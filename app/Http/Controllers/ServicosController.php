<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Servico;
use App\Loja;
use App\Tiposervico;


use Carbon\Carbon;

class ServicosController extends Controller
{


      public function index(){

        $servicos = Servico::where('data', Carbon::today())
        ->orderBy('renavam')
        ->get();

        $data = Carbon::today();
        $lojas = Loja::all();        

        return view('geral.index', compact('servicos', 'data', 'lojas'));
    }


    

    public function indexUsados(Request $request){

        $usados = Servico::where('data', Carbon::today())
        ->where('servico', 'U')
        ->orderBy('renavam')
        ->get();

        $data = Carbon::today();

        $lojas = Loja::all();

        

        return view('usados.index', compact('usados','data', 'lojas'));
    }



    public function indexEmplacamentos(Request $request){

        $emplacamentos = Servico::where('data', Carbon::today())
        ->where('servico', 'E')
        ->orderBy('renavam')
        ->get();

        $data = Carbon::today();

        $lojas = Loja::all();

        

        return view('emplacamentos.index', compact('emplacamentos','data', 'lojas'));
    }



     public function createUsado(){

        $lojas = Loja::all();
        $tiposervicos = Tiposervico::all();

        return view('usados.create', compact('lojas', 'tiposervicos'));
    }



    public function createEmplacamento(){

        $lojas = Loja::all();
        $tiposervicos = Tiposervico::all();

        return view('emplacamentos.create', compact('lojas', 'tiposervicos'));
    }



        public function editUsado(Request $request)
        {


            $servicos = Servico::all();
            $usado = $servicos->find($request->id);  


            $tiposervicos = Tiposervico::all();                

            $lojas = Loja::all();

            return view('usados.edit', compact('tiposervicos', 'lojas', 'usado'));

        }


         public function editEmplacamento(Request $request)
        {


            $servicos = Servico::all();
            $emplacamento = $servicos->find($request->id);  


            $tiposervicos = Tiposervico::all();                

            $lojas = Loja::all();

            return view('emplacamentos.edit', compact('tiposervicos', 'lojas', 'emplacamento'));

        }





    public function filter(Request $request){


         $servicos = Servico::where('loja_id', $request->get('loja_id'))
         
        ->get();

        $lojas = Loja::all();


        $data = '';

    	

    	return view('servicos.index', compact('servicos', 'data', 'lojas'));

    }









    public function action(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');

            if($query != '')
            {
                $data = DB::table('clientes')
                        ->where('cpf', $query)
                        ->get();
            }
          
            echo json_encode($data);    

        }
    }



   






    public function store(Request $request)
    {

    	$servico = Servico::create($request->all());

    	$request->session()
    	->put(
    		'mensagem',
    			"Servico {$servico->renavam} cadastrado com sucesso"
    		);

        if($request->servico == 'U'){

    	return redirect('/usados');   	

        }

        if($request->servico == 'E'){

        return redirect('/emplacamentos');       

        }

    }



    public function update(Request $request)
    {
        $servico = Servico::find($request->id);

        $servico->cliente_id = $request->cliente_id;
        $servico->tiposervico_id = $request->tiposervico_id;
        $servico->modelo = $request->modelo;
        $servico->placa = $request->placa;
        $servico->renavam = $request->renavam;
        $servico->data = $request->data;
        $servico->chassi = $request->chassi;       
        $servico->loja_id = $request->loja_id;
        $servico->numeroPedido = $request->numeroPedido;
        $servico->valorGuia = $request->valorGuia;
        $servico->guiaPago = $request->guiaPago;        
        $servico->valorIpva = $request->valorIpva;
        $servico->ipvaPago = $request->ipvaPago;
        $servico->valorProvisorio = $request->valorProvisorio;
        $servico->provisorioPago = $request->provisorioPago;
        $servico->valorPlacaEsp = $request->valorPlacaEsp;
        $servico->placaEspPago = $request->placaEspPago;
        $servico->valorOutros = $request->valorOutros;
        $servico->outrosPago = $request->outrosPago;

           

        $servico->save();


        $request->session()
        ->flash(
            'mensagem',
                "servico {$servico->renavam} atualizado com sucesso"
            );


        if($request->servico =='U'){
        return redirect('/usados'); 
        }

        if($request->servico =='E'){
        return redirect('/emplacamentos'); 
        }


    }




    public function destroy(Request $request)
    {

        $servico = Servico::find($request->id);


        Servico::destroy($request->id);
        $request->session()
            ->flash
            ('mensagem',
                "Servico '{$request->id}' apagado com sucesso."
            );

        if($request->servico =='E'){
        return redirect('/emplacamentos'); 
        }

        if($request->servico =='U'){
        return redirect('/usados'); 
        }
    }
    



}
