@extends('layout')

@section('cabecalho')
Resultado geral | LOJA: {{$lojaNome = $loja->nome ?? 'Todas'}} 

	@if(!empty($dataFim))
		{{\Carbon\Carbon::parse($dataInicio)->format('d/m/Y')}} até {{\Carbon\Carbon::parse($dataFim)->format('d/m/Y')}}
	@else
		{{\Carbon\Carbon::now()->format('d/m/Y')}}
	@endif
@endsection


@section('conteudo')



<div class="containder-fluid">
	<form action="/geral/filtrar" method="post">
		@csrf
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Lojas</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="loja_id">
					@foreach ($lojas as $loja)
						<option value="{{$loja->id}}">{{$loja->nome}}</option>
					@endforeach
				</select>
			</div>




			<label for="inputEmail3" class="col-sm-1 col-form-label">Serviço</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="servico">
					<option value="%">Ambos</option>
					<option value="U">Usado</option>
					<option value="E">Emplacamentos</option>
				</select>
			</div>
		</div>


		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Data</label>
			<div class="col-sm-4">
				<input type="date" class="form-control-sm" name="dataInicio"> até <input type="date" class="form-control-sm" name="dataFim"> 
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
				<td>{{$servico->valorGuia + $servico->valorIpva + $servico->valorProvisorio + $servico->valorPlacaEsp + $servico->valorOutros + $servico->valorServico}}
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
			</th><th>
			</th>
			<th>
			</th><th>
			</th></tfoot>
		</table>
	</div>



	<script>
		$(document).ready( function () {
			$('#table').DataTable({

				"order": [[ 1, "desc" ]],

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
				{ data: "guia" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
				{ data: "ipva" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
				{ data: "provisorio" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
				{ data: "placa esp" , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
				{ data: "outros",  render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
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
                .column( 14 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 14, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


 
            // Update footer
            $( api.column( 14 ).footer() ).html(
                pageTotal
            );
        }





			} );
		} );
	</script>


	@endsection




