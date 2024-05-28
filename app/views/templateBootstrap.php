<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <title>
    <?php
    if (isset($titulo)) {
      echo $titulo;
    } else {
      $url = explode("index.php", $_SERVER["PHP_SELF"]);
      $url = end($url);
      if ($url != "") {
        $url = explode('/', $url);
        array_shift($url);
        echo str_replace("_", " ", $url[0]);
      } else {
        echo 'W9b2';
      }
    }
    ?>
  </title>
  <link rel="manifest" type="text/css" href="<?php echo URL_BASE . "manifest.json" ?>">
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('<?php echo URL_BASE . "service-worker.js" ?>')
        .then(function (registration) {
          //console.log('Service Worker registrado com sucesso:', registration);
        })
        .catch(function (error) {
          console.log('Falha ao registrar o Service Worker:', error);
        });
    }
    const URL_BASE = "<?php echo URL_BASE ?>";
    const URL_IMAGEM = "<?php echo URL_IMAGEM ?>";
    const csrfToken = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var controller;
    var caminhoRetornoDelete;
  </script>

  <script src="<?php echo URL_BASE . "assets/js/jquery-3.7.0.js" ?>"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link href="<?php echo URL_BASE . "assets/css2/bootstrap.min.css" ?>" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE . "assets/css2/jquery.dataTables.min.css" ?>">
  <script type="text/javascript" src="<?php echo URL_BASE . "assets/js/jquery.dataTables.min.js" ?>"></script>

  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
  <script type="text/javascript"
    src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
  <script type="text/javascript"
    src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <?php include "sidebar.php" ?>
      <main class="col ps-md-2 pt-2">

        <div class="d-flex flex-column min-vh-100">


          <?php include "header.php" ?>

          <div class="container">
            <?php $this->load($view, $viewData) ?>
          </div>

          <?php include "rodape.php" ?>
        </div>

    </div>
    <script src="<?php echo URL_BASE . "assets/js/bootstrap.bundle.min.js" ?>"></script>
    <script src="<?php echo URL_BASE . "assets/js/popper.min.js" ?>"></script>
    <script src="<?php echo URL_BASE . "assets/js/bootstrap.min.js" ?>"></script>

    <script src="<?php echo URL_BASE . "assets/js/jsBase2.js" ?>"></script>
  </div>

</body>


</html>