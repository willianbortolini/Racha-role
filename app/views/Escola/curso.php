

<div class="caixa">
    <h2 class="titulo text-uppercase"><span class="case"><i class="ico duvida"></i>Curso</span><?php echo $curso->curso ?></h2>
</div>

<div class="base-home">
    <div class="rows base-cursos py-3">
        <div class="col-9">
            <div class="caixa">
                <div class="base-caixa-curso rows">
                    <div class="col-4">
                        <div class="thumb"><img src="<?php echo URL_BASE . "assets/img/escola/" . $curso->imagem ?>"></div>
                    </div>
                    <div class="col-8">                        
                        <ul>
                            <li><i class="ico data"></i><small>DATA DE INÍCIO:</small> <span><?php echo databr($cliente_curso->data_matricula) ?></span></li>
                            <li><i class="ico hora"></i><small>Duração:</small> <span><?php echo $duracaoCurso ?></span></li>
                            <li><i class="ico qtd"></i><small>Quantidade:</small> <span><?php echo $curso->qtd_aulas ?> Aulas</span></li>
                        </ul>
                        <div class="progress">
                            <small>Nível de progressão deste curso <b><?php echo $centConcluido->concluido ?>%</b></small>
                            <progress value="<?php echo $centConcluido->concluido ?>" max="100"></progress>
                        </div>
                    </div>	
                </div>
            </div>



            <div class="lista">
                <div class="caixa">
                    <span class="titulo2">Lista de aulas</span>
                    
                    <ul id="nav"> 
                        <?php 
                        $capituloAtual = 0;
                        foreach ($aulas as $key => $aula) { 
                            
                            if($capituloAtual != $aula->capitulo_id){
                                if($capituloAtual != 0){?> 
                                    </ul>
                                    </li>
                                <?php }?> 
                                <li>
                                <label for="sub<?php echo $aula->capitulo_id ?>">
                                    <h4><?php echo $aula->titulo_capitulo ?></h4>
                                    <small><?php echo  $aula->qtd_aulas . " aulas - duração:" . $aula->duracao ?></small>
                                    
                                </label>
                                <input id="sub<?php echo $aula->capitulo_id ?>" type="checkbox">
                                <ul>                                    
                                	
                                <?php $capituloAtual = $aula->capitulo_id;
                            }   
                        ?> 
                                    <li><a href="<?php echo URL_BASE . "escola/aula/". $aula->aula_id ?>"><?php echo $aula->ordem_aula .".". $aula->aula ?><br><small><?php echo "   ".$aula->duracao_aula ?>   <?php echo ($aula->assistida == 1)?"assistida":""  ?></small></a></li>
                        <?php } ?>                         

                    </ul>
                    
                    
                </div>
            </div>
        </div>
        <!--sidebar-->
        <div class="col-3">
                <div class="v-desempenho">				
                                        
                <div class="caixa">	
                        <span class="titulo2">Seus acessos no curso</span>					
                        <ul>
                                <li>
                                        <i class="ico acesso"></i>
                                        <span class="tt1">ÚLTIMO AULA ASSISTIDA</span>
                                        <span class="tt2"><?php echo databr($ultimaAulaAssistida)." ".substr($ultimaAulaAssistida,11,5) ?></span>
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


</div>
