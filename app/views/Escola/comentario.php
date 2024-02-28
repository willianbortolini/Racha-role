     

<div class="caixa">
    <h2 class="titulo"><span class="case"><i class="ico duvida"></i>Comentários</span> Perguntas e resposta da plataforma</h2>
</div>
<div class="rows duvidas py-3">
    <div class="col-12">
        <div class="caixa">
            <ul>
                <!--<li>
                    <img src="nao-matriculado.png">
                    <span class="titulo"><b>Nehuma resposta ainda</b> </span>
                    <span class="tt1">Aula: nenhuma</span>
                </li>-->
                <?php
                $comentarioAtual = 0;
                foreach ($comentarios as $key => $comentarios) {
                    if($comentarioAtual != $comentarios->id_comentario){
                        if($comentarioAtual != 0){?>
                            	
                            </li>
                        <?php } ?>  
                    <li>
                        <img src="<?php echo URL_BASE . "assets/img/escola/" ?>ico-comentarios.png">
                        <span class="titulo">Dúvida: <?php echo $comentarios->comentario ?> </span>
                        <span class="tt1">Aula: <?php echo $comentarios->aula ?>  </span>
                    <?php $comentarioAtual = $comentarios->id_comentario;
                    } 
                    ?> 
                        <?php if($comentarios->resposta != ''){ ?>  
                        <div class="resposta">
                            <span class="titulo">Resposta <small>Data:<?php echo databr($comentarios->data_resposta) ?></small></span>
                            <p> <?php echo $comentarios->resposta ?></p>
                        </div>
                        <?php } ?>  
                    
                    <?php } ?>  

            </ul>
        </div>
    </div>

</div>       

<!--<li>
    <img src="ico-comentarios.png">
    <span class="titulo">Dúvida: Lorem ipsum dolor sit amet, consectetur adipiscing elit. </span>
    <span class="tt1">Aula: aprendendo pensar como programador</span>
    <div class="resposta">
        <span class="titulo">Resposta <small>Data:08/07/2018</small></span>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras tellus ante, iaculis sed nulla consequat, interdum posuere arcu. Suspendisse pellentesque, augue vitae cursus cursus, tellus purus hendrerit elit, quis malesuada est nunc ac diam. </p>
    </div>	
</li>-->

