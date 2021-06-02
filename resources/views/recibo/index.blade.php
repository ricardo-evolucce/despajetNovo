<!DOCTYPE html>
<html>

<head>
  <style>
    body{
      font-size: 12px;
      font-family: Arial, Helvetica, sans-serif;
    }
    p {
      height: 7px;
    }
    #tabela-nfe td {
      height: 20px;
      width: 90px;
    }
  </style>
</head>

<body>
  <table id="tabela-nfe" border="1" style="margin: 0 auto;">
    <tbody>
      <tr>
        <td>
            <img src="http://despajet.com.br/nelio/images/despajet-logo.jpg" style="width: 200px;" />
        </td>
        <td colspan="5" align="center">
          <div>
            <h2><b>DESPAJET SERVICOS DE DESPACHANTE LTDA</b></h2>
          </div>
          <div >
			           <h3>Rua Bolivia, 968 - São José<br>
			Canoas - RS<br>
			92420-170</h3>
          </div>
        </td>
        <td colspan="2" align="center">
            <h3>Recibo N° {{$servico->id}}</h3>
        </td>
      </tr>
       <tr>
        <td colspan="4" align="center" style="padding: 20px; font-size: 15px; text-align: justify;">
          Recebemos de {{$servico->loja->razaoSocial}}, CNPJ {{$servico->loja->cnpj}},
          a quantia de {{$valorExtenso}}.<br><br><br>
          Referente a:<br><br> Taxa: R$ {{$servico->valorGuia}}<br><br> Serviço: R$ {{$servico->valorServico}}<br><br>Digitalização / Outros: R$ {{$servico->valorOutros}}<br><br>
          Placa Especial: R$ {{$servico->valorPlacaEsp}}<br><br> Placa: R$ {{$servico->valorPlaca}}<br><br> IPVA: R$ {{$servico->valorIPVA}}<br><br>
          Provisório: R$ {{$servico->valorProvisorio}}<br><br><br>
          Serviço N° {{$servico->id}}, Veículo {{$servico->modelo}}, Placa {{$servico->placa}}, Renavam {{substr($servico->renavam, -6)}}

        </td>
          <td colspan="4" align="center" style="padding: 20px; font-size: 15px">
          <h1>R$ {{$valorTotal}}</h1>

        </td>
      </tr>


      <tr >
        <td colspan="8" style="height: 100px;" align="center">
         PORTO ALEGRE - RS, {{\Carbon\Carbon::now()->format('d/m/Y')}}<br><br><br><br>
         ___________________________________________________________________<br>
        DESPAJET SERVICOS DE DESPACHANTE LTDA<br>
        CNPJ 19.868.274/0001-25

        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>