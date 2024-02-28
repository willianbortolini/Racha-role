

<div class="caixa">
    <h3>novos inscritos</h3>
    <div class="lista mt-2">
        <table>
            <tr>
                <th>id</th>
                <th>email</th>
                <th>usuario</th>
                <th>data cadastro</th>
            </tr>
            <?php foreach ($ultimosCadastrados as $key => $usuario) { ?>

                <tr>
                    <td> <?php echo $usuario->id_usuario ?></td>
                    <td> <?php echo $usuario->email ?></td>
                    <td> <?php echo $usuario->usuario ?></td>
                    <td> <?php echo $usuario->data_cadastro ?></td>

                </tr>
            <?php } ?>

        </table>
    </div>
</div>

<div class="caixa mt-2">
    <h3>acessos recentes</h3>
    <div class="lista mt-2">
        <table>
            <tr>
                <th>id</th>
                <th>email</th>
                <th>usuario</th>
                <th>data acesso</th>
                <th>QTD acessos</th>
            </tr>
            <?php foreach ($recentes as $key => $usuario) { ?>

                <tr>
                    <td> <?php echo $usuario->id_usuario ?></td>
                    <td> <?php echo $usuario->email ?></td>
                    <td> <?php echo $usuario->usuario ?></td>
                    <td> <?php echo $usuario->ultimo_acesso ?></td>
                    <td> <?php echo $usuario->qtd_acessos ?></td>    
                </tr>
            <?php } ?>

        </table>
    </div>
</div>

<div class="caixa mt-2">
    editar cursos
    <?php foreach ($cursos as $key => $curso) { ?>  
                <div class="col-3">             
                        <div class="caixa">
                                
                                <div class="del-curso">
                                        <p><?php echo $curso->curso?></p>
                                        <!--<small>Desempenho <b>50%</b></small>
                                        <progress value="4" max="7"></progress>-->
                                        <a href="<?php echo URL_BASE . "escola/criarCurso/". $curso->curso_id  ?>" class="btn btn-azul">
                                            Ir para o curso
                                            
                                        </a>
                                </div>
                        </div>
                </div>
                <?php } ?>  
</div>

<div class="caixa mt-2 duvidas">
    
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
                    <span class="tt1">Aula: <?php echo $comentarios->aula ?> Aluno: <?php echo $comentarios->usuario ?>  Curso: <?php echo $comentarios->curso ?></span>
                    
                    <form action="<?php echo URL_BASE . "escola/salvarResposta" ?>" method="POST">   
                        <textarea name="resposta" rows="3" placeholder="Deixe seu comentrio"></textarea>
                        <input type="hidden" name="id_usuario" placeholder="" value="<?php echo  $comentarios->id_usuario ?>">
                        <input type="hidden" name="aula_id" placeholder="" value="<?php echo  $comentarios->aula_id ?>">
                        <input type="hidden" name="id_comentario" placeholder="" value="<?php echo  $comentarios->id_comentario ?>">
                        <input type="submit" name="" value="Comentário" class="btn">
                    </form>
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







