<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Emplacamento;
use App\Loja;
use App\Tiposervico;


use Carbon\Carbon;

class EmplacamentosController extends Controller
{
    public function index(Request $request){

    	$emplacamentos = Emplacamento::where('data', Carbon::today())
    	->orderBy('renavam')
    	->get();

        $dataHoje = Carbon::today();

    	$mensagem = $request->session()->get('mensagem');

    	return view('emplacamentos.index', compact('emplacamentos', 'mensagem', 'dataHoje'));
    }



    public function filter(Request $request){

    	//$emplacamentos = emplacamento::where('loja_id', $request->get('loja'))
    	//->get();

        $data = $request->all();

        $emplacamentos = DB::table('emplacamentos')
        ->when(!empty($data['servicoPago']) , function ($query) use($data){
            return $query->where('loja_id', $request->get('loja_id'))
            ->where('servicoPago', $request->get('servicoPago'))
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')]);
        }, function ($query) {
        return $query->where('loja_id', $data['servicoPago'])
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')]);
        })
        ->get();



        /*$emplacamentos = DB::table('emplacamentos')
            ->where('loja_id', $request->get('loja_id'))
            ->where('servicoPago', $request->get('servicoPago'))
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')])
            ->get();*/


    	$mensagem = "loja 1";

    	return view('emplacamentos.index', compact('emplacamentos', 'mensagem'));

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

    	return view('emplacamentos.create', compact('lojas', 'tiposervicos'));
    }


	public function edit(Request $request)
	    {

	    	$emplacamentos = Emplacamento::all();
	    	$emplacamento = $emplacamentos->find($request->id);    	

            $lojas = Loja::all();




    		return view('emplacamentos.edit', compact('emplacamento', 'lojas'));

	    }





    public function store(Request $request)
    {

    	$emplacamento = Emplacamento::create($request->all());

    	$request->session()
    	->put(
    		'mensagem',
    			"Emplacamento {$emplacamento->renavam} cadastrado com sucesso"
    		);

    	return redirect('/emplacamentos');   	

    }



    public function update(Request $request)
    {
        $emplacamento = Emplacamento::find($request->id);

        $emplacamento->cliente_id = $request->cliente_id;
        $emplacamento->modelo = $request->modelo;
        $emplacamento->placa = $request->placa;
        $emplacamento->renavam = $request->renavam;
        $emplacamento->data = $request->data;
        $emplacamento->chassi = $request->chassi;
        $emplacamento->nfe = $request->nfe;
        $emplacamento->loja_id = $request->loja_id;
        $emplacamento->numeroPedido = $request->numeroPedido;


        $emplacamento->valorGuia = $request->valorGuia;
        $emplacamento->guiaPago = $request->guiaPago;
        
        $emplacamento->valorIpva = $request->valorIpva;
        $emplacamento->ipvaPago = $request->ipvaPago;

        $emplacamento->valorProvisorio = $request->valorProvisorio;
        $emplacamento->provisorioPago = $request->provisorioPago;

        $emplacamento->valorPlacaEsp = $request->valorPlacaEsp;
        $emplacamento->placaEspPago = $request->placaEspPago;

        $emplacamento->valorOutros = $request->valorOutros;
        $emplacamento->outrosPago = $request->outrosPago;

        $emplacamento->valorNfe = $request->valorNfe;        

        $emplacamento->save();


        $request->session()
        ->flash(
            'mensagem',
                "emplacamento {$emplacamento->renavam} atualizado com sucesso"
            );


        return redirect('/emplacamentos'); 


    }




    public function destroy(Request $request)
    {

        $emplacamento = Emplacamento::find($request->id);


        Emplacamento::destroy($request->id);
        $request->session()
            ->flash
            ('mensagem',
                "Emplacamento '{$emplacamento->id}' apagado com sucesso."
            );

            return redirect()->route('listarEmplacamentos');
    }
    



}
