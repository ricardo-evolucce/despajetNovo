@extends('layout')

@section('cabecalho')
Clientes 
@endsection

@section('conteudo')



<div class="containder-fluid">



	<table class="table" id="table">
		<thead>
			<tr>
				<th scope="col">
					Nome
				</th>
				<th scope="col">
					CPF
				</th>
			
				

			</tr>
		</thead>
		<tbody>
			@foreach($clientes as $cliente)
				<tr><td><a href="{{route('editarCliente', $cliente->id)}}">{{$cliente->nome}}</a></td>
					<td>{{$cliente->cpf}}</td>
		
			
				</tr>
			@endforeach
		</tbody>
		<tfoot><th>
				
				</th>
				<th>
					
				</th>
			</tfoot>
	</table>
</div>





<script>
    $(document).ready( function () {
        $('#table').DataTable({
        	



         language: { url: 'http://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json' },

    





         drawCallback: function () {
      var api = this.api();

      var numFormat = $.fn.dataTable.render.number( '.', ',', 2, 'R$' ).display;


      $( api.table().footer() ).html(
        numFormat(api.column( [9,10,11], {page:'current'} ).data().sum())
      );

     



    }



        
    } );
    } );
</script>
@endsection



