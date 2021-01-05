@extends('layout')

@section('cabecalho')
Cadastrar cliente
@endsection

@section('conteudo')
<form method="post" action="/clientes/armazenar">
	@csrf
	<h6>Dados do cliente</h6>
		<div class="row border-top pb-5">
			<div class="col col-6">
				<label for="nome">Nome</label>
				<input type="type" name="nome" id="nome" class="form-control" >


		
				
			</div>

			<div class="col col-6">
				<label for="cpf">CPF / CNPJ</label>
				<input type="type" name="cpf" id="search" class="form-control" >

				<input type="hidden" name="cliente_id" id="cliente_id">
			</div>
		</div>

		

		<div class="row">

			<div class="col col-6">
				<label for="rg">RG</label>
				<input type="text" name="rg" id="rg" class="form-control" >
			</div>
			<!--<div class="col col-6">
				<label for="cnpj">CNPJ</label>
				<input type="text" name="cnpj" id="cnpj" class="form-control" >
			</div>-->
		</div>


		<div class="row">
			<div class="col col-6">
				<label for="endereco">Endereço</label>
				<input type="text" name="endereco" id="endereco" class="form-control" >
			</div>
			<div class="col col-1">
				<label for="numero">N°</label>
				<input type="text" name="numero" id="numero" class="form-control" >
			</div>
			<div class="col col-5">
				<label for="complemento">Complemento</label>
				<input type="text" name="complemento" id="complemento" class="form-control" >
			</div>
		</div>

		<div class="row pb-5">

			<div class="col col-6">
				<label for="cidade">Cidade</label>
				<input type="text" name="cidade" id="cidade" class="form-control" >
			</div>
			<div class="col col-6">
				<label for="uf">UF</label>
				<input type="text" name="uf" id="uf" class="form-control" >
			</div>
		</div>

		










		<div class="row">

			<div class="col col-6">
				<label for="cep">CEP</label>
				<input type="text" name="cep" id="cep" class="form-control" >
			</div>

				<div class="col col-6">
				<label for="bairro">Bairro</label>
				<input type="text" name="bairro" id="bairro" class="form-control" >
			</div>
			
		</div>

		<div class="row  pb-5">
			<div class="col col-6">
				<label for="email">Email</label>
				<input type="text" name="email" id="email" class="form-control" >
			</div>
			
		</div>






	

		<div class="row">

			<div class="col col-6">
				<label for="telefone">Telefone</label>
				<span class="d-flex">
					<input type="text" name="telefone" id="telefone" class="form-control mr-2" >
					
				</span>
			</div>
			<div class="col col-6">
				<label for="celular">Celular</label>
				<span class="d-flex">
					<input type="text" name="celular" id="celular" class="form-control mr-2" >
					
				</span>
			</div>
		</div>

		

	











		<button class="btn btn-info mt-2">Cadastrar</button>
</form>







@endsection