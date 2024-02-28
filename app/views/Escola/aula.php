  

<div class="caixa">
    <h2 class="titulo"><span class="case"><i class="ico curso"></i><?php echo $curso->curso ?></span> <?php echo $capitulo->titulo_capitulo ?> <i class="seta"></i> <?php echo $aula->aula ?></h2>
</div>
<div class="base-home">
    <div class="rows base-cursos ver_videos py-3">
        <div class="col-9 d-flex">
            <div class="caixa">
                <span class="titulo2"><?php echo $aula->aula ?></span>
                <div class="caixa-video">
                    <div class="caixa-embed">
                        <iframe src="https://www.youtube.com/embed/<?php echo $aula->embed ?>?ecver=2" class="embed-item" width="655" height="360" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                    <div class="controles">
                        <a href="<?php
                        echo URL_BASE . "escola/aula/";
                        echo ($aulaAnterior > 0) ? $aulaAnterior : $aula->aula_id;
                        ?>" class="btn anterior">Anterior</a>
                        <a href="<?php
                        echo URL_BASE . "escola/aula/";
                        echo ($proximaAula > 0) ? $proximaAula : $aula->aula_id;
                        ?>" class="btn proximo">Próximo</a>  
                    </div>
                </div>
            </div>

        </div>
        <div class="col-3 d-flex">	
            <div class="caixa">	
                <span class="titulo2">Lista de aulas</span>
                <div class="menu-sidebar">		


                    <ul id="nav"> 
                        <?php
                        $capituloAtual = 0;
                        foreach ($aulas as $key => $item) {

                            if ($capituloAtual != $item->capitulo_id) {
                                if ($capituloAtual != 0) {
                                    ?> 
                                </ul>
                                </li>
                            <?php } ?> 
                            <li>
                                <label for="sub<?php echo $item->capitulo_id ?>">
                                    <h4><?php echo $item->titulo_capitulo ?></h4>
                                    <small><?php echo $item->qtd_aulas . " aulas - duração:" . $item->duracao ?></small>

                                </label>
                                <input id="sub<?php echo $item->capitulo_id ?>" type="checkbox" <?php echo ($item->capitulo_id == $capitulo->capitulo_id) ? "checked" : "" ?>>
                                <ul>                                    

                                    <?php
                                    $capituloAtual = $item->capitulo_id;
                                }
                                ?> 
                                <li class="<?php echo ($item->aula_id == $aula->aula_id) ? "aula-assistindo" : "" ?>"><a href="<?php echo URL_BASE . "escola/aula/" . $item->aula_id ?>"><?php echo $item->ordem_aula . "." . $item->aula ?><br><small><?php echo "   " . $item->duracao_aula ?>   <?php echo ($item->assistida == 1) ? "assistida" : "" ?></small></a></li>
                            <?php } ?>                         

                        </ul>


                </div>	
            </div>	
        </div>
    </div>
    <div class="rows base-cursos pb-3">
        <div class="col-9 mb-3">

           <div class="caixa">
                 <span class="titulo2">PERGUNTA DA AULA</span>
                <?php if($pergunta->pergunta){ ?>
                 <div class="radio-toolbar">
                    <form action="<?php echo URL_BASE . "escola/salvarPergunta" ?>" method="POST">
                        <p><?php echo $pergunta->pergunta ?></p>
                        
                        <?php foreach ($opcoes as $key => $opcao) { ?> 
                            <input type="radio" id="radio<?php echo $opcao->id_pergunta_opcao ?>" name="resposta" value="<?php echo $opcao->id_pergunta_opcao ?>"  <?php echo ($jaRespondeu > 0)? "disabled":""  ?>>
                            <label class="<?php echo ($correta == $opcao->id_pergunta_opcao)?"resposta-certa":"" ?> <?php if($correta != $jaRespondeu && $jaRespondeu == $opcao->id_pergunta_opcao){echo "resposta-errada";} ?>" for="radio<?php echo $opcao->id_pergunta_opcao ?>"><?php echo $opcao->opcao ?></label>
                        <?php } ?>  
                        <?php if($jaRespondeu > 0){    
                            if($correta != $jaRespondeu){ ?>
                                <h4 class="text-vermelho text-center mt-3"> Resposta incorreta</h4>
                            <?php }else{ ?> 
                                <h4 class="text-verde text-center mt-3"> Resposta correta</h4>
                            <?php } ?> 
                        <?php }else{ ?> 
                            <input type="hidden" value="<?php echo $pergunta->id_pergunta ?>" name="id_pergunta" > 
                            <input type="hidden" value="<?php echo $aula->aula_id ?>" name="aula_id"> 
                            <input class="btn my-2" type="submit" value="Responder">                        
                        <?php } ?> 
                    </form>
                </div>
                <?php }else{ ?>                 
                 <h4 class="text-center">SEM PERGUNTA</h4>
                <?php } ?>
            </div>

            <div class="v-downloads mt-2">
                <div class="caixa">
                    <span class="titulo2">ARQUIVOS DISPONÍVEÍS PARA DOWNLOAD</span>						
                    <ul>
                        <?php foreach ($dowloads as $key => $dowload) { ?> 
                            <li>
                                <a href="<?php echo $dowload->path ?>" class="icon" target="_blank">
                                    <?php echo $dowload->titulo_download ?>
                                </a>
                            </li>	
                        <?php } ?>   
                    </ul>
                    <?php echo (count($dowloads) == 0)?"<h4 class='text-center'>SEM DOWNLOAD</h4>" :""?>
                </div>
            </div>            

            <div class="base-comentario">
                <div class="caixa">	
                    <form action="<?php echo URL_BASE . "escola/salvarComentario/" . $aula->aula_id ?>" method="POST">    
                        <span class="titulo2">Comentários </span>	
                        <textarea name="comentario" rows="3" placeholder="Deixe seu comentrio"></textarea>	
                        <input type="submit" name="" value="Comentário" class="btn">
                    </form>
                </div>
                <?php if(count($comentarios)>0){?>
                <div class="caixa duvidas">
                    <ul>                        
                        <?php
                        $comentarioAtual = 0;
                        foreach ($comentarios as $key => $comentarios) {
                            if ($comentarioAtual != $comentarios->id_comentario) {
                                if ($comentarioAtual != 0) {
                                    ?>

                                    </li>
                                <?php } ?>  
                                <li>
                                    <img src="<?php echo URL_BASE . "assets/img/escola/" ?>ico-comentarios.png">
                                    <span class="titulo">Dúvida: <?php echo $comentarios->comentario ?> </span>
                                    <span class="tt1">Aula: <?php echo $comentarios->aula ?>  </span>
                                    <?php
                                    $comentarioAtual = $comentarios->id_comentario;
                                }
                                ?> 
                                <?php if ($comentarios->resposta != '') { ?>  
                                    <div class="resposta">
                                        <span class="titulo">Resposta <small>Data:<?php echo databr($comentarios->data_resposta) ?></small></span>
                                        <p> <?php echo $comentarios->resposta ?></p>
                                    </div>
                                <?php } ?>  

                            <?php } ?>  

                    </ul>

                </div>
                <?php }?>
            </div>
        </div>
        <div class="col-3">	
            <div class="v-desempenho">						
                <div class="caixa">	
                    <span class="titulo2">Seus acessos no curso</span>					
                    <ul>
                        <li>
                            <i class="ico acesso"></i>
                            <span class="tt1">ÚLTIMO AULA ASSISTIDA</span>
                            <span class="tt2"><?php echo databr($ultimaAulaAssistida) . " " . substr($ultimaAulaAssistida, 11, 5) ?></span>
                        </li>
                        <li>
                            <i class="ico horas"></i>
                            <span class="tt1">Duração total do curso</span>
                            <span class="tt2"><?php echo $duracaoCurso ?>  </span>
                        </li>
                        <li>
                            <i class="ico aula"></i>
                            <span class="tt1">Total de Aulas</span>
                            <span class="tt2"><?php echo $curso->qtd_aulas ?> aulas </span>
                        </li>

                        <li>
                            <i class="ico aula-ass"></i>
                            <span class="tt1">Aulas assistidas</span>
                            <span class="tt2"><?php echo $centConcluido->qtd_aulas_assistidas ?> aulas </span>
                        </li>


                    </ul>
                </div>
            </div>

        </div>
    </div>				
</div>




