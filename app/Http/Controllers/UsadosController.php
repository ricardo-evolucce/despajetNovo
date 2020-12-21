<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Usado;
use App\Loja;
use App\Tiposervico;

use Carbon\Carbon;

class UsadosController extends Controller
{
    public function index(Request $request){

    	$usados = Usado::where('data', Carbon::today())
    	->orderBy('renavam')
    	->get();

        $dataHoje = Carbon::today();

    	$mensagem = $request->session()->get('mensagem');

    	return view('usados.index', compact('usados', 'mensagem', 'dataHoje'));
    }



    public function filter(Request $request){

    	//$usados = Usado::where('loja_id', $request->get('loja'))
    	//->get();

        $data = $request->all();

        $usados = DB::table('usados')
        ->when(!empty($data['servicoPago']) , function ($query) use($data){
            return $query->where('loja_id', $request->get('loja_id'))
            ->where('servicoPago', $request->get('servicoPago'))
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')]);
        }, function ($query) {
        return $query->where('loja_id', $data['servicoPago'])
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')]);
        })
        ->get();



        /* $usados = DB::table('usados')
            ->where('loja_id', $request->get('loja_id'))
            ->where('servicoPago', $request->get('servicoPago'))
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')])
            ->get(); */


    	$mensagem = "loja 1";

    	return view('usados.index', compact('usados', 'mensagem'));

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



    public function create(){

        $lojas = Loja::all();

        $tiposervicos = Tiposervico::all();

    	return view('usados.create', compact('lojas', 'tiposervicos'));
    }


	public function edit(Request $request)
	    {

	    	$usados = Usado::all();
	    	$usado = $usados->find($request->id);

            $tiposervicos = Tiposervico::all();	
            $lojas = Loja::all();




    		return view('usados.edit', compact('usado', 'tiposervicos', 'lojas'));

	    }





    public function store(Request $request)
    {

    	$usado = Usado::create($request->all());

    	$request->session()
    	->flash(
    		'mensagem',
    			"Usado {$usado->renavam} cadastrado com sucesso"
    		);

    	return redirect('/usados');   	

    }



    public function update(Request $request)
    {
        $usado = Usado::find($request->id);

        $usado->cliente_id = $request->cliente_id;
        $usado->modelo = $request->modelo;
        $usado->placa = $request->placa;
        $usado->renavam = $request->renavam;
        $usado->data = $request->data;
        $usado->loja_id = $request->loja_id;
        $usado->tiposervico_id = $request->tiposervico_id;
        $usado->trocaPlaca = $request->trocaPlaca;
        $usado->valorServico = $request->valorServico;
        $usado->servicoPago = $request->servicoPago;
        $usado->valorIpva = $request->valorIpva;
        $usado->ipvaPago = $request->ipvaPago;
        $usado->valorOutros = $request->valorOutros;
        $usado->outrosPago = $request->outrosPago;
        $usado->valorNfe = $request->valorNfe;

        $usado->save();


        $request->session()
        ->flash(
            'mensagem',
                "Usado {$usado->renavam} atualizado com sucesso"
            );


        return redirect('/usados'); 


    }

    public function destroy(Request $request)
    {

        $usado = Usado::find($request->id);


        Usado::destroy($request->id);
        $request->session()
            ->flash
            ('mensagem',
                "Usado '{$usado->id}' apagada com sucesso."
            );

            return redirect()->route('listarUsados');
    }



}
