@extends('layout')

@section('cabecalho')
Editar serviço de usado
@endsection

@section('conteudo')
<form method="post" action="/servicos/atualizar">
	@csrf

	<input type="hidden" name="servico" value="U">

	<h6>Dados do cliente</h6>
		<div class="row border-top pb-5">
			<div class="col col-6">
				<label for="nome">Nome</label>
				<input type="type" name="nome" id="nome" class="form-control" value="{{$usado->cliente->nome}}">

				
			</div>

			<div class="col col-6">
				<label for="cpf">CPF</label>
				<input type="type" name="cpf" id="search" class="form-control" value="{{$usado->cliente->cpf}}">

				<input type="hidden" name="cliente_id" id="cliente_id" value="{{$usado->cliente_id}}">
				<input type="hidden" name="id" id="id" value="{{$usado->id}}">


			</div>
		</div>

		<h6>Dados do veículo</h6>

		<div class="row border-top">

			<div class="col col-6">
				<label for="modelo">Modelo</label>
				<input type="text" name="modelo" id="modelo" class="form-control" value="{{$usado->modelo}}">
			</div>
			<div class="col col-6">
				<label for="placa">Placa</label>
				<input type="text" name="placa" id="placa" class="form-control" value="{{$usado->placa}}">
			</div>
		</div>

		<div class="row pb-5">
			<div class="col col-6">
				<label for="renavam">Renavam</label>
				<input type="text" name="renavam" id="renavam" class="form-control" value="{{$usado->renavam}}">
			</div>
			<div class="col col-6">
				<label for="data">Data</label>
				<input type="date" name="data" id="data" class="form-control" value="{{$usado->data->format('Y-m-d')}}">
			</div>
		</div>




		<h6>Dados do serviço</h6>

		<div class="row border-top">

			<div class="col col-6">
				<label for="loja_id">Loja</label>
				<select name="loja_id" class="form-control">
				<option value="{{$usado->loja_id}}">{{$usado->loja->nome}}	
					@foreach ($lojas as $loja)
						<option value="{{$loja->id}}">{{$loja->nome}}</option>
					@endforeach
				</select>
			</div>
			<div class="col col-6">
				<label for="tiposervico_id">Tipo Serviço</label>
				

				<select name="tiposervico_id" class="form-control">
						<option value="{{$usado->tiposervico_id}}">{{$usado->tiposervico->nome}}
							@foreach ($tiposervicos as $tiposervico)
							<option value="{{$tiposervico->id}}">{{$tiposervico->nome}}</option>
						@endforeach
				</select>
			</div>
		</div>

		<div class="row  pb-5">
			<div class="col col-6">
				<label for="trocaPlaca">Troca de placa</label>
				<select name="trocaPlaca" id="trocaPlaca" class="form-control" value="{{$usado->trocaPlaca}}">

					@switch($usado->trocaPlaca)
						@case(1)
						<option value="1">Sim</option>
						<option value="0">Não</option>
						@break
						@case(0)
						<option value="0">Não</option>
						<option value="1">Sim</option>
						@break
					@endswitch

					
					
				</select>
			</div>

			<div class="col col-6">
				<label for="carhouseOuCliente">CarHouse / Cliente</label>
				<select name="carhouseOuCliente" id="carhouseOuCliente" class="form-control" value="{{$usado->carhouseOuCliente}}">

					@switch($usado->carhouseOuCliente)
						@case(1)
						<option value="1">CarHouse</option>
						<option value="2">Cliente</option>
						<option value=""></option>
						@break
						@case(2)
						<option value="2">Cliente</option>
						<option value="1">CarHouse</option>
						<option value=""></option>
						@break
						@default
						<option value=""></option>
						<option value="1">CarHouse</option>
						<option value="2">Cliente</option>
						@break
					@endswitch

					
					
				</select>
			</div>
			
		</div>







		<h6>Taxas</h6>

		<div class="row border-top">

			<div class="col col-6">
				<label for="valorServico">Valor do serviço</label>
				<span class="d-flex">
					<input type="text" name="valorServico" id="valorServico" class="form-control mr-2" value="{{$usado->valorServico}}">
					<select class="form-control" name="servicoPago">
							@switch($usado->servicoPago)
								@case(1)
								<option value="1">Pago</option>
								<option value="0">Não pago</option>
								@break
								@case(0)
								<option value="0">Não pago</option>
								<option value="1">Pago</option>
								@break
							@endswitch
					</select>
				</span>
			</div>
			<div class="col col-6">
				<label for="valorIpva">Valor IPVA</label>
				<span class="d-flex">
					<input type="text" name="valorIpva" id="valorIpva" class="form-control mr-2" value="{{$usado->valorIpva}}">
					<select class="form-control" name="ipvaPago">
						@switch($usado->ipvaPago)
								@case(1)
								<option value="1">Pago</option>
								<option value="0">Não pago</option>
								@break
								@case(0)
								<option value="0">Não pago</option>
								<option value="1">Pago</option>
								@break
						@endswitch
					</select>
				</span>
			</div>
		</div>

		<div class="row">
			<div class="col col-6">
				<label for="valorOutros">Valor outros</label>
				<span class="d-flex">
					<input type="text" name="valorOutros" id="valorOutros" class="form-control mr-2" value="{{$usado->valorOutros}}">
					<select class="form-control" name="outrosPago">
							@switch($usado->outrosPago)
								@case(1)
								<option value="1">Pago</option>
								<option value="0">Não pago</option>
								@break
								@case(0)
								<option value="0">Não pago</option>
								<option value="1">Pago</option>
								@break
						@endswitch
					</select>
				</span>
			</div>

			<div class="col col-6">
				<label for="valorNfe">Valor NF</label>
				<span class="d-flex">
					<input type="text" name="valorNfe" id="valorNfe" class="form-control mr-2" value="{{$usado->valorNfe}}">
				
				</span>
			</div>
			
		</div>











		<button class="btn btn-info mt-2">Atualizar</button>

</form>


		<form method="post" action="/servicos/deletar/{{$usado->servico}}/{{$usado->id}}"
						onsubmit="return confirm('Confirma remoção de {{$usado->id}} ?')">
						@csrf
						@method('DELETE')
						<button class="btn btn-danger mt-2" >Apagar</button>
		</form>

<script>
	$(document).ready(function(){

		

		function buscar_dados(query = '')
		{
			$.ajax({
				url:"{{ route('live_search.action')}}",
				method: 'GET',
				data:{query:query},
				dataType:'json',
				success:function(data)
				{
					$('#nome').val(data[0].nome);
					$('#cliente_id').val(data[0].id);
					
				}
			})
		}

		$(document).on('keyup', '#search', function(){
			var query = $(this).val();
			buscar_dados(query);
		})

	});
</script>



@endsection