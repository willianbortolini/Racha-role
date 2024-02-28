
<div class="p-1">
    <?php
    $this->verMsg();
    $this->verErro();
    //$imagem = ($produto->imagem) ? $produto->imagem : "semproduto.png";
    ?>
</div>
<div class="caixa mt-2 col-4">
    <div class="lista">
        <div class="caixa">
            <span class="titulo2">Lista de aulas</span>

            <ul id="grade_curicular"> 
                <?php
                $capituloAtual = 0;
                foreach ($aulas as $key => $aula) {

                    if ($capituloAtual != $aula->capitulo_id) {
                        if ($capituloAtual != 0) {
                            ?> 
                            <a class="btn"href="<?php echo URL_BASE . "escola/adicionaAula/" . $curso_id . "/" . $aula->capitulo_id ?>"> + aula</a>   
                        </ul>
                        </li>
                    <?php } ?> 
                    <li >
                        <br><label for="sub<?php echo $aula->capitulo_id ?>">
                            <input capitulo_id="<?php echo $aula->capitulo_id ?>" type="text" value="<?php echo $aula->titulo_capitulo ?>"> 


                        </label>

                        <ul>                                    

                            <?php
                            $capituloAtual = $aula->capitulo_id;
                        }
                        ?> 
                        <li >
                            <input type="text" aula_id="<?php echo $aula->aula_id ?>" value="<?php echo $aula->aula ?>"> 
                            <a href="<?php echo URL_BASE . "escola/criarCurso/" . $curso_id . "/" . $aula->aula_id ?>"><span class="material-icons">edit</span></a>
                        </li> 
                    <?php } ?>                          

                </ul>





        </div>
        <a class="btn"href="<?php echo URL_BASE . "escola/adicionaCapitulo/" . $curso_id ?>"> criar capitulo</a>
    </div>
</div>



<div class="caixa mt-2 col-8 ">  
    <?php if($aulaIn){ ?>
    <form action="<?php echo URL_BASE . "escola/salvarAula" ?>" method="POST"enctype="multipart/form-data">
        
        <input type="hidden" name="aula_id" value="<?php echo $aulaIn->aula_id ?>">
        <input type="hidden" name="curso_id" value="<?php echo $curso_id ?>">        
        <input type="submit" value="Salvar alterações" class="btn btn-laranja btn-medio d-block m-auto">
        <h4 class="mt-2 titulo2">Informações da aula</h4>
        <div class="rows">
        <div class="col-12">
        <label >titulo da aula</label>
        <input  type="text" name="titulo_aula" value="<?php echo $aulaIn->aula ?>">
        </div>
        <div class="col-4 mt-2">
        <label>Embed</label>
        <input  type="text" name="embed" value="<?php echo $aulaIn->embed ?>">
        </div>
        <div class="col-4 mt-2">
        <label>Duração</label>
        <input  type="time" step="2" $aulaInname="duracao" value="<?php echo $aulaIn->duracao_aula ?>">
        </div>
        <div class="col-4 mt-2">
        <label>Ordem exibição aula</label>
        <input  type="text"  name="ordem" value="<?php echo $aulaIn->ordem_aula ?>">
        </div>
        </div>
        <h4 class="mt-2 titulo2">downloads</h4>
        
        <div class="rows">
        <?php foreach ($dowloads as $key => $dowload) { ?>
            <div class="col-3 mt-2">
            <label>Titulo Download <?php echo $key + 1 ?></label>
            <input type="text" name="titulo_dowload<?php echo $key + 1 ?>" value="<?php echo $dowload->titulo_download ?>">
            </div>
            <div class="col-8 mt-2">
            <label>Link Download <?php echo $key + 1 ?></label>
            <input type="text" name="link_dowload<?php echo $key + 1 ?>" value="<?php echo $dowload->path ?>">
            </div>
            <input type="hidden" name="id_download<?php echo $key + 1 ?>" value="<?php echo $dowload->id_download ?>">            
            <div class="col-1 mt-3">
            <a class="btn btn-vermelho"href="<?php echo URL_BASE . "escola/excluiDownload/" . $dowload->id_download . "/" . $curso_id . "/" . $aulaIn->aula_id ?>"> <span class="material-icons">delete</span></a>
            </div>
        <?php } ?>
        </div>    
            
            
        <?php if(count($dowloads) < 4){?>     
            <a class="btn mt-3"href="<?php echo URL_BASE . "escola/adicionaDownload/" . $curso_id . "/" . $aulaIn->aula_id ?>"> Adiciona Download</a>
        <?php } ?>
        

        <h4 class="mt-2 titulo2">pergunta</h4>
        <?php if ($pergunta->pergunta != '') { ?>
            
            <input type="hidden" name="id_pergunta" value="<?php echo $pergunta->id_pergunta ?>">  
            <div class="rows"> 
            <div class="col-12 mt-2">
            <label>Pergunta</label>
            <textarea name="pergunta"  rows="2" cols="50"><?php echo $pergunta->pergunta ?></textarea>
            </div>
            <?php foreach ($opcoes as $key => $opcao) { ?>
                <div class="col-10 mt-2">
                <label>Opção <?php echo $key + 1 ?></label>  
                <textarea name="opcao<?php echo $key + 1 ?>"  rows="2" cols="50"><?php echo $opcao->opcao ?></textarea>
                
                </div>
                <input type="hidden" name="id_pergunta_opcao<?php echo $key + 1 ?>" value="<?php echo $opcao->id_pergunta_opcao ?>">  
                <div class="col-1 mt-4">
                <label for="<?php echo "opcao" . $key + 1 ?>">Correta</label>
                <input type="radio" id="<?php echo "opcao" . $key + 1 ?>" name="opcaoCorreta" value="<?php echo $opcao->id_pergunta_opcao ?>" required>
                
                </div>
            <?php } ?>
            </div>    
            <a class="btn btn-vermelho mt-2"href="<?php echo URL_BASE . "escola/excluiPergunta/" . $pergunta->id_pergunta. "/" . $curso_id . "/" . $aula->aula_id ?>"> Excluir Pergunta</a>
                
        <?php } else { ?>
            <a class="btn"href="<?php echo URL_BASE . "escola/adicionaPergunta/" . $curso_id . "/" . $aula->aula_id ?>"> Adiciona pergunta</a>
        <?php } ?>
    </form> 
    <?php } ?>
</div>

<script type="text/javascript" src="<?php echo URL_BASE ?>assets/js/escola/js_cria_curso.js"></script>	









