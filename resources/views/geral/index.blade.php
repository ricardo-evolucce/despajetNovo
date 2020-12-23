@extends('layout')

@section('cabecalho')
Resultado geral | {{ \Carbon\Carbon::parse($data)->format('d/m/Y')}} 
@endsection


@section('conteudo')



<div class="containder-fluid">
	<form action="/geral/filtrar" method="post">
		@csrf
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Lojas</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="loja_id">
					<option value="1">Gravatai</option>
					<option value="2">Taquara</option>
					<option value="3">Sertório</option>
				</select>
			</div>




			<label for="inputEmail3" class="col-sm-1 col-form-label">Serviço</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="servicoPago">
					<option value="">Ambos</option>
					<option value="1">Usado</option>
					<option value="2">Emplacamentos</option>
				</select>
			</div>
		</div>


		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Data</label>
			<div class="col-sm-2">
				<input type="date" class="form-control-sm" name="data">
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
					Val. Serv.
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
			@foreach($servicos as $servico)
			<tr><td>{{$servico->id}}</td>
				<td>{{$servico->data->format('d/m/Y')}}</td>			
				<td>{{$servico->cliente->nome}}</td>
				<td>{{$servico->modelo}}</td>
				<td>{{$servico->chassi}}</td>
				<td>{{$servico->placa}}</td>
				<td>{{$servico->renavam}}</td>			
				<td>{{$servico->loja->nome}}</td>
				<td  @if($servico->guiaPago==0) class="text-danger" @endif>{{$servico->valorGuia}}</td>	
				<td  @if($servico->servicoPago==0) class="text-danger" @endif>{{$servico->valorServico}}</td>		
				<td  @if($servico->ipvaPago==0) class="text-danger" @endif>{{$servico->valorIpva}}</td>
				<td  @if($servico->provisorioPago==0) class="text-danger" @endif>{{$servico->valorProvisorio}}</td>
				<td  @if($servico->placaEspPago==0) class="text-danger" @endif>{{$servico->valorPlacaEsp}}</td>				
				<td  @if($servico->outrosPago==0) class="text-danger" @endif>{{$servico->valorOutros}}</td>		
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




