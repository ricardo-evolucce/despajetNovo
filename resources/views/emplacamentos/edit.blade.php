@extends('layout')

@section('cabecalho')
Editar serviço de emplacamento
@endsection

@section('conteudo')
<form method="post" action="/servicos/atualizar">
	@csrf
	<h6>Dados do cliente</h6>

	<input type="hidden" value="E" name="servico">

		<div class="row border-top pb-5">
			<div class="col col-6">
				<label for="nome">Nome</label>
				<input type="type" name="nome" id="nome" class="form-control" value="{{$emplacamento->cliente->nome}}">


				<input type="hidden" name="id" value="{{$emplacamento->id}}">
				
			</div>

			<div class="col col-6">
				<label for="cpf">CPF</label>
				<input type="type" name="cpf" id="search" class="form-control" value="{{$emplacamento->cliente->cpf}}">

				<input type="hidden" name="cliente_id" id="cliente_id" value="{{$emplacamento->cliente->id}}">
			</div>
		</div>

		<h6>Dados do veículo</h6>

		<div class="row border-top">

			<div class="col col-6">
				<label for="modelo">Modelo</label>
				<input type="text" name="modelo" id="modelo" class="form-control" value="{{$emplacamento->modelo}}">
			</div>
			<div class="col col-6">
				<label for="placa">Placa</label>
				<input type="text" name="placa" id="placa" class="form-control" value="{{$emplacamento->placa}}">
			</div>
		</div>


		<div class="row">
			<div class="col col-6">
				<label for="renavam">Renavam</label>
				<input type="text" name="renavam" id="renavam" class="form-control" value="{{$emplacamento->renavam}}">
			</div>
			<div class="col col-6">
				<label for="data">Data</label>
				<input type="date" name="data" id="data" class="form-control" value="{{$emplacamento->data->format('Y-m-d')}}" required>
			</div>
		</div>

		<div class="row pb-5">

			<div class="col col-6">
				<label for="chassi">Chassi</label>
				<input type="text" name="chassi" id="chassi" class="form-control" value="{{$emplacamento->chassi}}" maxlength="17">
			</div>
			<div class="col col-6">
				<label for="modelo">NFE</label>
				<input type="text" name="nfe" id="nfe" class="form-control" value="{{$emplacamento->nfe}}">
			</div>
		</div>

		







		<h6>Dados do serviço</h6>

		<div class="row border-top pb-5">

			<div class="col col-6">
				<label for="loja_id">Loja</label>
				<select name="loja_id" class="form-control">
					<option value="{{$emplacamento->loja_id}}">{{$emplacamento->loja->nome}}</option>
						@foreach ($lojas as $loja)
							<option value="{{$loja->id}}">{{$loja->nome}}</option>
						@endforeach
				</select>
			</div>

				<div class="col col-6">
				<label for="numeroPedido">N° do pedido</label>
				<input type="text" name="numeroPedido" id="numeroPedido" class="form-control" value="{{$emplacamento->numeroPedido}}">
			</div>
			
		</div>

	







		<h6>Taxas</h6>

		<div class="row border-top">

			<div class="col col-6">
				<label for="valorServico">Valor da guia</label>
				<span class="d-flex">
					<input type="text" name="valorGuia" id="valorGuia" class="form-control mr-2" value="{{$emplacamento->valorGuia}}">
					<select class="form-control" name="guiaPago">
							@switch($emplacamento->guiaPago)
								@case(1)
									<option value="1">Pago</option>
									<option value="0">Não pago</option>
								@break
								@default
									<option value="0">Não pago</option>
									<option value="1">Pago</option>
							@endswitch
					</select>
				</span>
			</div>
			<div class="col col-6">
				<label for="valorIpva">Valor IPVA</label>
				<span class="d-flex">
					<input type="text" name="valorIpva" id="valorIpva" class="form-control mr-2" value="{{$emplacamento->valorIpva}}">
					<select class="form-control" name="ipvaPago">
						@switch($emplacamento->ipvaPago)
								@case(1)
									<option value="1">Pago</option>
									<option value="0">Não pago</option>
								@break
								@default
									<option value="0">Não pago</option>
									<option value="1">Pago</option>
							@endswitch
					</select>
				</span>
			</div>
		</div>

		<div class="row">
			<div class="col col-6">
				<label for="valorProvisorio">Valor provisório</label>
				<span class="d-flex">
					<input type="text" name="valorProvisorio" id="valorProvisorio" class="form-control mr-2" value="{{$emplacamento->valorProvisorio}}">
					<select class="form-control" name="provisorioPago">
							@switch($emplacamento->provisorioPago)
								@case(1)
									<option value="1">Pago</option>
									<option value="0">Não pago</option>
								@break
								@default
									<option value="0">Não pago</option>
									<option value="1">Pago</option>
							@endswitch
					</select>
				</span>
			</div>

			<div class="col col-6">
				<label for="valorPlacaEsp">Valor Placa Especial</label>
				<span class="d-flex">
					<input type="text" name="valorPlacaEsp" id="valorPlacaEsp" class="form-control mr-2" value="{{$emplacamento->valorPlacaEsp}}">
					<select class="form-control" name="placaEspPago">
							@switch($emplacamento->placaEspPago)
								@case(1)
									<option value="1">Pago</option>
									<option value="0">Não pago</option>
								@break
								@default
									<option value="0">Não pago</option>
									<option value="1">Pago</option>
							@endswitch
					</select>
				</span>
			</div>
			
		</div>

		<div class="row">
			<div class="col col-6">
				<label for="valorOutros">Valor outros</label>
				<span class="d-flex">
					<input type="text" name="valorOutros" id="valorOutros" class="form-control mr-2" value="{{$emplacamento->valorOutros}}">
					<select class="form-control" name="outrosPago">
						@switch($emplacamento->outrosPago)
							@case(1)
								<option value="1">Pago</option>
								<option value="0">Não pago</option>
							@break
							@default
							<option value="0">Não pago</option>
							<option value="1">Pago</option>
						@endswitch
					</select>
				</span>
			</div>

			<div class="col col-6">
				<label for="valorNfe">Valor NFe</label>
				<span class="d-flex">
					<input type="text" name="valorNfe" id="valorNfe" class="form-control mr-2" value="{{$emplacamento->valorNfe}}">
				
				</span>
			</div>
			
		</div>











		<button class="btn btn-info mt-2">Atualizar</button>
</form>

	<form method="post" action="/servicos/deletar/{{$emplacamento->servico}}/{{$emplacamento->id}}"
						onsubmit="return confirm('Confirma remoção de {{$emplacamento->id}} ?')">
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