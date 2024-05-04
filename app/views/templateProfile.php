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

  <div class="d-flex flex-column min-vh-100">
    <?php include "headerProfile.php" ?>
    <div class="conteudo">
      <div class="ml-1 mr-2">
        <?php
        $this->verMsg();
        $this->verErro();
        ?>
      </div>
      <?php $this->load($view, $viewData) ?>

    </div>
  </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
  <script src="<?php echo URL_BASE ?>assets/js/componentes/js_mascara.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function fecharAlerta(botao) {
      // Navegar até o elemento pai (div com a classe "alert") do botao e ocultá-lo
      var divPai = botao.closest(".alert");
      divPai.remove();
    }

  </script>
</body>


</html>