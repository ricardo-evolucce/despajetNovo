<?php
$mensagem_tipo = null;
$mensagem = null;
foreach (['error', 'warning', 'success', 'info'] as $key ){
    if(Session::has($key)){
        $mensagem_tipo = $key;
        $mensagem = Session::get($key);
        break;
    }
}

?>

@extends('layout')

@section('cabecalho')
    Notas fiscais | LOJA: {{$lojaNome = $loja->nome ?? 'Todas'}}

	@if(!empty($dataFim))
		{{\Carbon\Carbon::parse($dataInicio)->format('d/m/Y')}} até {{\Carbon\Carbon::parse($dataFim)->format('d/m/Y')}}
	@else
		{{\Carbon\Carbon::now()->format('d/m/Y')}}
	@endif
@endsection

@section('conteudo')

@if($mensagem)
<script>
    Swal.fire({
        icon: '{{$mensagem_tipo}}',
        text: '{{$mensagem}}',
    })
</script>
@endif

<div class="containder-fluid">
	<form action="/nota-fiscal/central-acoes" method="post">
		@csrf
		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Lojas</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="loja_id">
					@if(!empty($loja))
					<option value="{{$loja->id}}">{{$loja->nome}}</option>
		@endif
      	<option value="%">TODAS</option>
					@foreach ($lojas as $loja)
						<option value="{{$loja->id}}">{{$loja->nome}}</option>
					@endforeach
				</select>
			</div>




			<label for="inputEmail3" class="col-sm-1 col-form-label">Serviço</label>
			<div class="col-sm-2">
				<select class="form-control-sm" name="servico">

					@if(!empty($tiposervico))
					@switch($tiposervico)
						@case('%')
						<option value="%">Ambos</option>
						@break
						@case('E')
						<option value="E">Emplacamentos</option>
						@break
						@case('U')
						<option value="U">Usados</option>
						@break
						@default
						Erro

					@endswitch

					@endif
					<option value="%">Ambos</option>
					<option value="U">Usado</option>
					<option value="E">Emplacamentos</option>
				</select>
			</div>
		</div>

		<div class="form-group row">
			<label for="inputEmail3" class="col-sm-1 col-form-label">Data</label>
			<div class="col-sm-4">
				<input type="date" class="form-control-sm" name="dataInicio" @if(!empty($dataInicio))value="{{$dataInicio}}"@endif> até <input type="date" class="form-control-sm" name="dataFim"  @if(!empty($dataFim))value="{{$dataFim}}"@endif>
			</div>




		</div>

		<div class="form-group row">


			<div class="col-sm-2">
				<button class="btn btn-primary">Pesquisar</button>
			</div>

		</div>

        <div id="nfe_container">
            <input type="hidden" id="nfe_acao" name="nfe[acao]" value="">
            <input type="hidden" id="nfe_ids" name="nfe[ids]" value="">
        </div>
	</form>


	<table class="table" id="table">
		<thead>
			<tr>
                <td width="3%">
                        <div>
                            <input type="checkbox" class="selectAll" name="selectAll" value="all">
                        </div>
                    </td>
				<th scope="col">
					#
				</th>
				<th scope="col">
					Data
				</th>

				<th scope="col">
					Cliente
				</th>
				{{-- <th scope="col">
					Modelo
				</th>
				<th scope="col">
					Chassi
				</th> --}}
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
                <th scope="col">
                    NFe
                </th>

			</tr>
		</thead>
		<tbody>
			@foreach($servicos as $servico)
            <tr>
                <td></td>
                <td>{{$servico->id}}</td>
				<td>{{$servico->DATA->format('d/m/Y')}}</td>
				<td>{{$servico->cliente->nome}}</td>
				{{-- <td>{{$servico->modelo}}</td>
				<td>{{$servico->chassi}}</td> --}}
				<td>{{$servico->placa}}</td>
				<td>{{$servico->renavam}}</td>
				<td>{{$servico->loja->nome}}</td>
				<td  @if($servico->guiaPago==0) class="text-danger" @endif>{{$servico->valorGuia}}</td>
				<td  @if($servico->servicoPago==0) class="text-danger" @endif>{{$servico->valorServico}}</td>
				<td  @if($servico->ipvaPago==0) class="text-danger" @endif>{{$servico->valorIpva}}</td>
				<td  @if($servico->provisorioPago==0) class="text-danger" @endif>{{$servico->valorProvisorio}}</td>
				<td  @if($servico->placaEspPago==0) class="text-danger" @endif>{{$servico->valorPlacaEsp}}</td>
				<td  @if($servico->outrosPago==0) class="text-danger" @endif>{{$servico->valorOutros}}</td>
                <td>{{$servico->valorGuia + $servico->valorIpva + $servico->valorProvisorio + $servico->valorPlacaEsp + $servico->valorOutros + $servico->valorServico}} </td>
                <td>{{$servico->nfe_id}}</td>
			</tr>
			@endforeach



		</tbody>
        <tfoot>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            {{-- <th> </th>
            <th> </th> --}}
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
            <th> </th>
        </tfoot>
    </table>
</div>



	<script>

	</script>


    @endsection

@section('js_custom')
    <script type="text/javascript" src="/public/js/nfe.js"></script>
@endsection




