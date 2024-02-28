

    <div class="col menu-lateral position-relative">
        <nav class="menuprincipal" id="principal">				
            <ul class="menu-ul icones">                
                <li><a href="<?php echo URL_BASE . "laddertoc" ?>"><i class="fas fa-home"></i> Ladder / C</a></li>
                <li><a href="<?php echo URL_BASE . "newclp" ?>"><i class="icon fas fa-file"></i> Laddel / Esp32 </a></li>
                <li><a href="#menu_producao"><i class="fas fa-tools"></i> Equipamentos <span>+</span></a></li> 
                <?php if($_SESSION['nivel'] == 10){?>
                <li><a href="<?php echo URL_BASE . "escola" ?>"><i class="material-icons">school</i>  Ambiente de aprendizado </a></li>
                <?php } ?>
            </ul>
        </nav>
        <!-- MENU PRODUÇÃO -->

        <nav class="menuprincipal" id="menu_producao">
            <ul class="menu-lista">
                <li class="icones"><a href="" title="Recolher menu"><i class="fas fa-arrow-left ativo"></i></a></li>
                <h1 class="tt px-2"><b><i class="fas fa-cubes"></i> Produções</b></h1>
                <li><a href="<?php echo URL_BASE . "patio" ?>">Painel de máquinas</a></li>                
                <li><a href="<?php echo URL_BASE . "maquina/create" ?>">Cadastro de equipamentos</a></li>                             
                
            </ul>
        </nav>

    </div>
