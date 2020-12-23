<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cliente;

use Carbon\Carbon;

class ClientesController extends Controller
{
    public function index(Request $request){

    	$clientes = Cliente::orderBy('nome')
        ->get();

    	$mensagem = $request->session()->get('mensagem');

    	return view('clientes.index', compact('clientes', 'mensagem'));
    }



    public function filter(Request $request){

    	//$clientes = cliente::where('loja_id', $request->get('loja'))
    	//->get();

        $data = $request->all();

        $clientes = DB::table('clientes')
        ->when(!empty($data['servicoPago']) , function ($query) use($data){
            return $query->where('loja_id', $request->get('loja_id'))
            ->where('servicoPago', $request->get('servicoPago'))
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')]);
        }, function ($query) {
        return $query->where('loja_id', $data['servicoPago'])
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')]);
        })
        ->get();



        /*$clientes = DB::table('clientes')
            ->where('loja_id', $request->get('loja_id'))
            ->where('servicoPago', $request->get('servicoPago'))
            ->whereBetween('data', [$request->get('periodo1'), $request->get('periodo2')])
            ->get();*/


    	$mensagem = "loja 1";

    	return view('clientes.index', compact('clientes', 'mensagem'));

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
    	return view('clientes.create');
    }


	public function edit(Request $request)
	    {

	    	$clientes = Cliente::all();
	    	$cliente = $clientes->find($request->id);    	




    		return view('clientes.edit', compact('cliente'));

	    }





    public function store(Request $request)
    {

    	$cliente = Cliente::create($request->all());

    	$request->session()
    	->flash(
    		'mensagem',
    			"Cliente {$cliente->renavam} cadastrado com sucesso"
    		);

    	return redirect('/clientes');   	

    }



    public function update(Request $request)
    {
        $cliente = Cliente::find($request->id);

        $cliente->nome = $request->nome;
        $cliente->cpf = $request->cpf;
        $cliente->rg = $request->rg;
        $cliente->cnpj = $request->cnpj;
        $cliente->endereco = $request->endereco;
        $cliente->numero = $request->numero;
        $cliente->cidade = $request->cidade;
        $cliente->uf = $request->uf;
        $cliente->cep = $request->cep;


        $cliente->bairro = $request->bairro;
        $cliente->telefone = $request->telefone;
        $cliente->celular = $request->celular;
 
        $cliente->save();


        $request->session()
        ->flash(
            'mensagem',
                "cliente {$cliente->nome} atualizado com sucesso"
            );


        return redirect('/clientes'); 


    }

    



}
