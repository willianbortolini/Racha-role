<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <title>Racha Role
  </title>
  <link rel="manifest" type="text/css" href="<?php echo URL_BASE . "manifest.json" ?>">
  <script>
   /* if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('<?php //echo URL_BASE . "service-worker.js" ?>')
        .then(function (registration) {
          //console.log('Service Worker registrado com sucesso:', registration);
        })
        .catch(function (error) {
          console.log('Falha ao registrar o Service Worker:', error);
        });
    }*/

    if ('serviceWorker' in navigator) {
      alert('serviceWorker')
      navigator.serviceWorker.register('<?php echo URL_BASE . "service-worker.js" ?>').then(function (registration) {
        //console.log('ServiceWorker registration successful with scope: ', registration.scope);

        // Verifica se há uma atualização do service worker
        registration.onupdatefound = function () {
          alert('tem atualização')
          const installingWorker = registration.installing;
          installingWorker.onstatechange = function () {
            if (installingWorker.state === 'installed') {
              if (navigator.serviceWorker.controller) {
                // Novo service worker encontrado, informe ao usuário
                console.log('New or updated content is available.');
                alert('Nova versão disponível. Atualize a página.');
              } else {
                // Conteúdo pré-cachado foi atualizado
                console.log('Content is now available offline!');
              }
            }
          };
        };
      }).catch(function (error) {
        console.log('ServiceWorker registration failed: ', error);
      });
    }


    const URL_BASE = "<?php echo URL_BASE ?>";
    const csrfToken = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var controller;
    var caminhoRetornoDelete;
  </script>
  <script src="<?php echo URL_BASE . "assets/js/jquery-3.5.1.slim.min.js" ?>"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE . "assets/css2/jquery.dataTables.min.css" ?>">
  <link rel="stylesheet" href="<?php echo URL_BASE . "assets/css2/bootstrap.min.css" ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE . "assets/css/estilos.css" ?>">
  <script src="<?php echo URL_BASE . "assets/js/jquery.mask.js" ?>"></script>
</head>


<body>

  <div class="d-flex flex-column min-vh-100 ">


    <div class="ml-1 mr-2">
      <?php
      $this->verMsg();
      $this->verErro();
      ?>
    </div>
    <?php //include "header.php" 
    ?>

    <div class="container">
      <div class="rectangle-6"></div>
      <?php $this->load($view, $viewData) ?>
    </div>

    <?php include "rodape.php" ?>
  </div>

  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <script src="<?php echo URL_BASE . "assets/js/jsBase.js" ?>"></script>
</body>


</html>