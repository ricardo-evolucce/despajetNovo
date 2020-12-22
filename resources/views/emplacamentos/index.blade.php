@extends('layout')

@section('cabecalho')
Serviços de emplacamentos em todas as lojas | {{ \Carbon\Carbon::parse($data)->format('d/m/Y')}} 
@endsection


@section('conteudo')

	@if($mensagem)
		<div class="alert alert-success">
		{{ $mensagem }}
		</div>
	@endif

<div class="containder-fluid">
<form action="/emplacamentos/filtrar" method="post">
	@csrf
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-1 col-form-label">Loja</label>
    <div class="col-sm-2">
      <select class="form-control-sm" name="loja_id">
      	@foreach ($lojas as $loja)
					<option value="{{$loja->id}}">{{$loja->nome}}</option>
		@endforeach
      </select>
    </div>
 


  
    <label for="inputEmail3" class="col-sm-1 col-form-label">Pagamento</label>
    <div class="col-sm-2">
      <select class="form-control-sm" name="servicoPago">
      	<option value="">Ambos</option>
      	<option value="1">Pagos</option>
      	<option value="0">Não pagos</option>
      </select>
    </div>
  </div>


  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-1 col-form-label">Período</label>
    <div class="col-sm-2">
		<input type="date" class="form-control-sm" name="periodo1">
    </div>
    <div class="col-sm-2">
		até <input type="date" class="form-control-sm" name="periodo2">
    </div>
     

    
  </div>





  <div class="form-group row">
  
    
    <div class="col-sm-2">
		<button class="btn btn-primary">Pesquisar</button>
    </div>
    
  </div>





</form>


	<table class="table" id="table">
		<thead>
			<tr>
				<th scope="col">
					*
				</th>
				<th scope="col">
					Data
				</th>
				<th scope="col">
					Pedido
				</th>
				<th scope="col">
					Cliente
				</th>
				<th scope="col">
					Modelo
				</th>
				<th scope="col">
					Chassi
				</th>
				<th scope="col">
					Placa
				</th>
				<th scope="col">
					Renavam
				</th>
				<th scope="col">
					Loja
				</th>
				<th scope="col">
					Guia
				</th>
				<th scope="col">
					IPVA
				</th>
				<th scope="col">
					Provisório
				</th>
				<th scope="col">
					Placa Esp
				</th>
				<th scope="col">
					Outros
				</th>
				<th scope="col">
					Total
				</th>

			</tr>
		</thead>
		<tbody>
			@foreach($emplacamentos as $emplacamento)
				<tr><td>{{$emplacamento->id}}</td>
					<td>{{$emplacamento->data->format('d/m/Y')}}</td>
					<td>{{$emplacamento->numeroPedido}}</td>
					<td><a href="{{route('editarEmplacamento', $emplacamento->id)}}">{{$emplacamento->cliente->nome}}</a></td>
					<td>{{$emplacamento->modelo}}</td>
					<td>{{$emplacamento->chassi}}</td>
					<td>{{$emplacamento->placa}}</td>
					<td>{{$emplacamento->renavam}}</td>			
					<td>{{$emplacamento->loja->nome}}</td>
					<td  @if($emplacamento->guiaPago==0) class="text-danger" @endif>{{$emplacamento->valorGuia}}</td>
					<td  @if($emplacamento->ipvaPago==0) class="text-danger" @endif>{{$emplacamento->valorIpva}}</td>
					<td  @if($emplacamento->provisorioPago==0) class="text-danger" @endif>{{$emplacamento->valorProvisorio}}</td>
					<td  @if($emplacamento->placaEspPago==0) class="text-danger" @endif>{{$emplacamento->valorPlacaEsp}}</td>
					<td  @if($emplacamento->outrosPago==0) class="text-danger" @endif>{{$emplacamento->valorOutros}}</td>
					<td></td>
				</tr>
			@endforeach
		</tbody>
		<tfoot><th>
				
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
					
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
					
				</th>
				<th>
				</th><th>
				</th>
			<th>
				</th></tfoot>
	</table>
</div>



<script>
    $(document).ready( function () {
        $('#table').DataTable({
        	

            dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print'
        ], 


         language: { url: 'http://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json' },

            columns: [
            { data: "num" },
            { data: "data" },
            { data: "pedido" },
            { data: "cliente" },
            { data: "modelo" },
            { data: "chassi" },
            { data: "placa" },
            { data: "renavam" },
            { data: "loja" },
            { data: "guia" },
            { data: "ipva" },
            { data: "provisorio" },
            { data: "placa esp" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
            { data: "outros",  render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
            { data: "total" },
          
        ], 









        
    } );
    } );
</script>


@endsection




