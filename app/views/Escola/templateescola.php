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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>

    <div class="base-topo">
        <div class="conteudo">
            <a href="" class="menu-m">menu mobile esquerdo</a><!-- aqui fico icone reponsavel pelo meno da esquerda-->
        </div>
    </div>

    <div class="site">        
        <div id="menu">
            <div class="menu-lateral">
                <ul>
                    <li><a href="<?php echo URL_BASE ?>escola/index"><span class="material-icons">home</span></i> HOME</a></li>
                    <li><a href="<?php echo URL_BASE ?>escola/meuscursos"><span class="material-icons">desktop_windows</span> MEUS CURSOS</a></li>
                    <li><a href="<?php echo URL_BASE ?>escola/perfil"><span class="material-icons">person</span> MEU PERFIL</a></li>
                    <li><a href="<?php echo URL_BASE ?>escola/comentario"><span class="material-icons">rate_review</span>COMENTÁRIOS</a></li>
                    <?php if ($_SESSION['nivel'] == 10) { ?>
                        <li><a href="<?php echo URL_BASE . "escola/dashboard" ?>"><span class="material-icons">code</span> DASHBOARD</a></li>
                    <?php } ?>
                    <li><a href="<?php echo URL_BASE . "login/logoff" ?>"><span class="material-icons">logout</span> SAIR</a></li>

                </ul>
            </div>
        </div>
        <div class="base-geral">
        <div class="oculta-menu" id="ocultar-menu">
        <span class="material-icons">menu</span>
        </div>
            <?php $this->load($view, $viewData) ?>
        </div>
</body>


</html>