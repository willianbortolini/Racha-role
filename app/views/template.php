<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>W9B2
    <?php //echo $titulo ?>
  </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.16.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
</head>

<body>

  <div class="d-flex min-vh-100 ">
    
    <main class="flex-grow-1">
    <div class="mt-2 mr-2">
      <?php
      $this->verMsg();
      $this->verErro();
      ?>
    </div>
      <?php $this->load($view, $viewData) ?>
    </main>

  </div>

  </div>

</body>


</html>

<script>
    function fecharAlerta(botao) {
      // Navegar até o elemento pai (div com a classe "alert") do botao e ocultá-lo
      var divPai = botao.closest(".alert");
      divPai.remove();
    }
    
  </script>