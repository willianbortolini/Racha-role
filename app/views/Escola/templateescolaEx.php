<!doctype html>
<html>
    <head>
        <title>Escola</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/escola/style.css?v=2">
        <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/escola/auxiliar.css?v=2">
        <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/escola/grade.css?v=2">               
        <link rel="stylesheet" type="text/css" href="<?php echo URL_BASE ?>assets/css/escola/m-style.css?v=2">		 
        <script src="<?php echo URL_BASE ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo URL_BASE ?>assets/js/escola/js.js"></script>	
        <script src="<?php echo URL_BASE ?>assets/js/jquery.mask.js"></script>
        <script src="<?php echo URL_BASE ?>assets/js/componentes/js_mascara.js"></script>
        
        
       </head>
    <body>

        <div class="base-geral">            
            <?php $this->load($view, $viewData) ?>
        </div>
    </body>
</html>