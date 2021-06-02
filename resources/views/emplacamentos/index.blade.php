@extends('layout')

@section('cabecalho')
Emplacamentos | LOJA: {{$lojaNome = $loja->nome ?? 'Todas'}}

|

@if(!empty($dataFim))
	{{\Carbon\Carbon::parse($dataInicio)->format('d/m/Y')}} até {{\Carbon\Carbon::parse($dataFim)->format('d/m/Y')}}
@else
	{{\Carbon\Carbon::now()->format('d/m/Y')}}
@endif

@endsection


@section('conteudo')


<div class="containder-fluid">
<form action="/servicos/filterEmplacamentos" method="post">
	@csrf
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-1 col-form-label">Loja</label>
    <div class="col-sm-2">
      <select class="form-control-sm" name="loja_id">
      	@if(!empty($loja))
					<option value="{{$loja->id}}">{{$loja->nome}}</option>
		@endif
      	<option value="%">TODAS</option>
      	@foreach ($lojas as $loj)
					<option value="{{$loj->id}}">{{$loj->nome}}</option>
		@endforeach
      </select>
    </div>
 


  
    <label for="inputEmail3" class="col-sm-1 col-form-label">Pagamento</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="pagamentos">

					@if(!empty($pagamento))
					@switch($pagamento)
						@case('%')
						<option value="%">Ambos</option>
						@break
						@case(1)
						<option value="1">Pagos</option>
						@break
						@case(2)
						<option value="2">Não Pagos</option>
						@break							
						@default
						Erro

					@endswitch

					@endif

					<option value="%">Ambos</option>
					<option value="1">Pagos</option>
					<option value="2">Não pagos</option>
				</select>
			</div>
  </div>


  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-1 col-form-label">Período</label>
    <div class="col-sm-2">
		<input type="date" class="form-control-sm" name="dataInicio" @if(!empty($dataInicio))value="{{$dataInicio}}"@endif>
    </div>
    <div class="col-sm-3">
		até <input type="date" class="form-control-sm" name="dataFim" @if(!empty($dataFim))value="{{$dataFim}}"@endif>
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
					Taxa
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
					Placa
				</th>
				<th scope="col">
					Total
				</th>

			</tr>
		</thead>
		<tbody>
			@foreach($emplacamentos as $emplacamento)
				<tr><td>{{$loop->iteration}}</td>
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
					<td  @if($emplacamento->placaPago==0) class="text-danger" @endif>{{$emplacamento->valorPlaca}}</td>
					<td>{{$emplacamento->valorGuia + $emplacamento->valorIpva + $emplacamento->valorProvisorio + $emplacamento->valorPlacaEsp + $emplacamento->valorOutros + $emplacamento->valorPlaca}}
					</td>
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
        	

        "paging": false,


            dom: 'Bfrtip',
        buttons: [
            'excel', 'print'
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
            { data: "guia" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
            { data: "ipva" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
            { data: "provisorio" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
            { data: "placa esp" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
            { data: "outros",  render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
            { data: "valorPlaca",  render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
            { data: "total" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
          
        ], 




        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 15 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 15, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


 
              var numFormat = $.fn.dataTable.render.number( '.', ',', 2 ).display;
 
            // Update footer
            $( api.column( 15 ).footer() ).html(
                numFormat(pageTotal)
            );
        }




        
    } );
    } );
</script>


@endsection




