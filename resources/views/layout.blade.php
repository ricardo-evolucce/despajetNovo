<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Despajet</title>      


  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> 

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.21/api/sum().js"></script>

  <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>


</head>
<body>
  <div class="container-fluid">

    <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-center">
      <a class="navbar-brand" href="#"><img src="http://despajet.com.br/nelio/images/despajet-logo.jpg"></a>

      <div style="text-align: center;">  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/usados/criar">Criar usado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/usados">Listar usados</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/emplacamentos/criar">Criar emplacamento</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/emplacamentos">Listar emplacamentos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/clientes/criar">Criar cliente</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/clientes">Clientes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/geral">Geral</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>





  <div class="jumbotron p-1">
    <h4>@yield('cabecalho')</h4>
  </div>
  @yield('conteudo')
</div>


</body>
</html>