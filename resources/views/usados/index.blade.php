@extends('layout')

@section('cabecalho')
Serviços de  {{$tipoS = $tipoServico->nome ?? 'usados'}} | LOJA: {{$lojaNome = $loja->nome ?? 'Todas'}}

|

@if(!empty($dataFim))
{{\Carbon\Carbon::parse($dataInicio)->format('d/m/Y')}} até {{\Carbon\Carbon::parse($dataFim)->format('d/m/Y')}}
@else
{{\Carbon\Carbon::now()->format('d/m/Y')}}
@endif

|

@if(isset($pagamento))
@switch($pagamento)
@case(1)
Pagos
@break
@case(2)
Não pagos
@break							
@default
Pagos e não pagos
@break

@endswitch
@else
Pagos e não pagos
@endif

@endsection

@section('conteudo')



<div class="containder-fluid">
	<form action="/servicos/filterUsados" method="post">
		@csrf

		<input type="hidden" value="U" name="servico">


		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Loja</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="loja_id">

					@if(!empty($loja))
					<option value="{{$loja->id}}">{{$loja->nome}}</option>
					@endif

					<option value="%">TODAS</option>
					@foreach($lojas as $loj)
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
				<input type="date" class="form-control-sm" name="dataFim" @if(!empty($dataFim))value="{{$dataFim}}"@endif>
			</div>



		</div>





		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Tipo</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="tiposervico_id">

					@if(!empty($tipoServico))
						<option value="{{$tipoServico->id}}">{{$tipoServico->nome}}</option>
					@else
						<option value="%">TODOS</option>
					@endif

					@foreach($tipoServicos as $tipoServic)
					<option value="{{$tipoServic->id}}">{{$tipoServic->nome}}</option>
					@endforeach

					<option value="%">TODOS</option>

				</select>
			</div>

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
					Cliente
				</th>
				<th scope="col">
					Modelo
				</th>
				<th scope="col">
					Renavam
				</th>
				<th scope="col">
					Placa
				</th>
				<th scope="col">
					Tipo Serviço
				</th>
				<th scope="col">
					Troca Placa
				</th>
				<th scope="col">
					Loja
				</th>
				<th scope="col">
					Valor Serviço
				</th>
				<th scope="col">
					IPVA
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
			
			@foreach($usados as $usado)
			<tr><td>{{$loop->iteration}}</td>
				<td>{{$usado->data->format('d/m/Y')}}</td>
				<td><a href="{{route('editarUsado', $usado->id)}}">{{$usado->cliente->nome}}</a></td>
				<td>{{$usado->modelo}}</td>
				<td>{{$usado->renavam}}</td>
				<td>{{$usado->placa}}</td>
				<td>{{$usado->tiposervico->nome}}</td>
				<td>
					@switch($usado->trocaPlaca)
					@case(1)
					Sim
					@break
					@case(0)
					Não
					@break

					@default
					Erro

					@endswitch
				</td>
				<td>{{$usado->loja->nome}}</td>
				<td @if($usado->servicoPago==0) class="text-danger" @endif>
					{{$usado->valorServico}}
				</td>
				<td @if($usado->ipvaPago==0) class="text-danger" @endif>
					{{$usado->valorIpva}}
				</td>
				<td @if($usado->outrosPago==0) class="text-danger" @endif>
					{{$usado->valorOutros}}
				</td>
				<td @if($usado->outrosPago==0) class="text-danger" @endif>
					{{$usado->valorPlaca}}
				</td>
				


				<td>{{$usado->valorServico + $usado->valorIpva + $usado->valorOutros + $usado->valorPlaca}}</td>
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
				{ data: "cliente" },
				{ data: "modelo" },
				{ data: "renavam" },
				{ data: "placa" },
				{ data: "tipoServico" },
				{ data: "trocaPlaca" },
				{ data: "loja" },
				{ data: "valorServico" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
				{ data: "ipva",  render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
				{ data: "outros", 
				render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
				{ data: "total", render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
				{ data: "valorPlaca", render: $.fn.dataTable.render.number( '.', ',', 2, '' )},

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
			.column( 13 )
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );

			// Total over this page
			pageTotal = api
			.column( 13, { page: 'current'} )
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );


			var numFormat = $.fn.dataTable.render.number( '.', ',', 2 ).display;

			// Update footer
			$( api.column( 13 ).footer() ).html(
				numFormat(pageTotal)
				);
		}




		
	} );
		} );
	</script>
	@endsection



