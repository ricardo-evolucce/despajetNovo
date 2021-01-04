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



public function indexUsados(){

    $usados = Servico::where('data', Carbon::today())
    ->where('servico', 'U')
    ->orderBy('data', 'ASC')
    ->get();

   
    $loja_id = '';
    $lojas = Loja::all();
    $tipoServicos = Tiposervico::all();          

    return view('usados.index', compact('usados', 'loja_id', 'lojas', 'tipoServicos'));
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





public function filterGeral(Request $request){

    

    switch ($request->servico) {

        //caso USADOS
        case 'U':
        $servicos = Servico::where('servico', 'U')
        ->where('loja_id', $request->loja_id)
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->orderBy('data', 'DESC')
        ->get();
        break;   

        //caso EMPLACAMENTOS
        case 'E':
        $servicos = Servico::where('servico', 'E')
        ->where('loja_id', $request->loja_id)
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->orderBy('data', 'DESC')
        ->get();
        break;

        //caso pagamento PAGOS
        case '%':
        $servicos = Servico::where('loja_id', $request->loja_id)
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->orderBy('data', 'DESC')
        ->get();
        break;

        default:
                
        break;
    }

    $dataInicio = $request->dataInicio;

    $dataFim = $request->dataFim;   

    $loja = Loja::find($request->loja_id);

    $lojas = Loja::all();

    return view('geral.index', compact('servicos','dataInicio', 'dataFim', 'loja', 'lojas'));


}




public function filterUsados(Request $request){

    switch ($request->pagamentos) {

        //caso pagamento AMBOS
        case '%':
        $usados = Servico::where('servico', 'U')
        ->where('loja_id', $request->loja_id)
        ->where('tiposervico_id', $request->tiposervico_id)      
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->orderBy('data', 'DESC')
        ->get();
        break;   

        //caso pagamento PAGOS
        case '1':
        $usados = Servico::where('servico', 'U')
        ->where('loja_id', $request->loja_id)
        ->where('tiposervico_id', $request->tiposervico_id)      
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->where('servicoPago', '1')
        ->where('ipvaPago', '1')
        ->where('outrosPago', '1')
        ->orderBy('data', 'DESC')
        ->get();

        break;

        //caso pagamento NÃO PAGOS
        case '2':
        $usados = Servico::where('servico', 'U')
        ->where('loja_id', $request->loja_id)
        ->where('tiposervico_id', $request->tiposervico_id)
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->where(function ($query) {  
        $query->where('servicoPago', 'LIKE', '0')
         ->orWhere('ipvaPago', 'LIKE', '0')
         ->orWhere('outrosPago', 'LIKE', '0');
        })
        ->get();


        break;

        default:
                
        break;
    }

    $tipoServico = Tiposervico::find($request->tiposervico_id);

    $pagamento = $request->pagamentos;

    $dataInicio = $request->dataInicio;

    $dataFim = $request->dataFim;

    $tipoServicos = Tiposervico::all();

    $loja = Loja::find($request->loja_id);

    $lojas = Loja::all();

    return view('usados.index', compact('usados', 'tipoServico', 'pagamento', 'dataInicio', 'dataFim', 'tipoServicos', 'loja', 'lojas'));

}





public function filterEmplacamentos(Request $request){

    switch ($request->pagamentos) {

        //caso pagamento AMBOS
        case '%':
        $emplacamentos = Servico::where('servico', 'E')
        ->where('loja_id', $request->loja_id)       
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->orderBy('data', 'DESC')
        ->get();
        break;   

        //caso pagamento PAGOS
        case '1':
        $emplacamentos = Servico::where('servico', 'E')
        ->where('loja_id', $request->loja_id)
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->where('guiaPago', '1')
        ->where('ipvaPago', '1')
        ->where('placaEspPago', '1')
        ->where('provisorioPago', '1')
        ->where('outrosPago', '1')
        ->orderBy('data', 'DESC')
        ->get();

        break;

        //caso pagamento NÃO PAGOS
        case '2':
        $emplacamentos = Servico::where('servico', 'E')
        ->where('loja_id', $request->loja_id)
        ->where('tiposervico_id', $request->tiposervico_id)
        ->whereBetween(DB::raw('DATE(data)'), array($request->dataInicio, $request->dataFim))
        ->where(function ($query) {  
        $query->where('guiaPago', 'LIKE', '0')
         ->orWhere('ipvaPago', 'LIKE', '0')
         ->orWhere('outrosPago', 'LIKE', '0')
         ->orWhere('provisorioPago', 'LIKE', '0')
         ->orWhere('placaEspPago', 'LIKE', '0');
        })
        ->get();


        break;

        default:
                
        break;
    }

   

    $pagamento = $request->pagamentos;

    $dataInicio = $request->dataInicio;

    $dataFim = $request->dataFim;

    

    $loja = Loja::find($request->loja_id);

    $lojas = Loja::all();

    return view('emplacamentos.index', compact('emplacamentos', 'pagamento', 'dataInicio', 'dataFim', 'loja', 'lojas'));

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
    $servico->trocaPlaca = $request->trocaPlaca;
    $servico->carhouseOuCliente = $request->carhouseOuCliente;
    $servico->valorGuia = $request->valorGuia;
    $servico->guiaPago = $request->guiaPago;        
    $servico->valorIpva = $request->valorIpva;
    $servico->ipvaPago = $request->ipvaPago;
    $servico->valorServico = $request->valorServico;
    $servico->servicoPago = $request->servicoPago;
    $servico->provisorioPago = $request->provisorioPago;
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
