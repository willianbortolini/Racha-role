<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <title>InvTrack
    <?php //echo $titulo 
    ?>
  </title>
  <link rel="manifest" type="text/css" href="<?php echo URL_BASE  . "manifest.json" ?>">
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('<?php echo URL_BASE  . "service-worker.js" ?>')
        .then(function(registration) {
          //console.log('Service Worker registrado com sucesso:', registration);
        })
        .catch(function(error) {
          console.log('Falha ao registrar o Service Worker:', error);
        });
    }
    const URL_BASE = "<?php echo URL_BASE?>";
    const csrfToken = <?php echo json_encode($_SESSION['csrf_token']); ?>;
    var controller;
    var caminhoRetornoDelete;
  </script>

    <script src="<?php echo URL_BASE  . "assets/js/jquery-3.7.0.js" ?>"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="<?php echo URL_BASE  . "assets/css2/bootstrap.min.css" ?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE  . "assets/css2/jquery.dataTables.min.css" ?>">
    
    <script type="text/javascript" src="<?php echo URL_BASE  . "assets/js/jquery.dataTables.min.js" ?>"></script>
    

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


</head>

<body>

  <div class="d-flex flex-column min-vh-100 ">


    <?php include "header.php" ?>
   
    <div class="container">
    <div class="rectangle-6"></div>
      <?php $this->load($view, $viewData) ?>
    </div>

    <?php include "rodape.php" ?>
  </div>

  </div>
  <?php if (DOCKER_CONTAINER == TRUE) { ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php } else { ?>
    <script src="<?php echo URL_BASE  . "assets/js/bootstrap.bundle.min.js" ?>" ></script>
    <script src="<?php echo URL_BASE  . "assets/js/popper.min.js" ?>"></script>
    <script src="<?php echo URL_BASE  . "assets/js/bootstrap.min.js" ?>"></script>
  <?php } ?> 
  
  <script src="<?php echo URL_BASE  . "assets/js/jsBase.js" ?>"></script>
</body>


</html>