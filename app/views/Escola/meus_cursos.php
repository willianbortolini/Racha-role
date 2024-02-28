  
		
			<div class="caixa">
				<h2 class="titulo"><span class="case"><i class="ico duvida"></i>Meus Cursos</span> Lista de Cursos</h2>
			</div>
		<div class="base-home">
			<div class="rows cursos py-3">
                
                <?php foreach ($cursos as $key => $curso) { ?>  
                <div class="col-3">             
                        <div class="caixa">
                                <img src="<?php echo URL_BASE . "assets/img/escola/" . $curso->imagem ?>">
                                <div class="del-curso">
                                        <p><?php echo $curso->curso?></p>
                                        <!--<small>Desempenho <b>50%</b></small>
                                        <progress value="4" max="7"></progress>-->
                                        <a href="<?php echo ($curso->curso_id > 0) ? URL_BASE . "escola/curso/". $curso->curso_id : URL_BASE . "loading/loading/". $curso->curso_curso_id; ?>" class="btn <?php echo ($curso->curso_id > 0) ? "" : "btn-azul"; ?>">
                                            <?php echo ($curso->curso_id > 0) ? "Ir para o curso" : "Adiquirir curso"; ?>
                                            
                                        </a>
                                </div>
                        </div>
                </div>
                <?php } ?>    
                
        </div>
</div>
                    
		
	
