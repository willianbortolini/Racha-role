

<div class="caixa">
    <h2 class="titulo"><span class="case"><i class="ico duvida"></i>Home</span> Seja Bem Vindo</h2>
</div>

<div class="base-home">
    <div class="rows detalhes py-3">
        <div class="col-4">
            <figure class="caixa">
                <div class="thumb"><img src="<?php echo URL_BASE . "assets/img/escola/minhafoto300.png" ?>"></div>
                <figcaption>
                    <strong>Willian Ricardo Bortolini</strong>
                    <small><b>Seu tutor nos cursos</b></small>
                    <small>willian.borto@gmail.com</small>
                </figcaption>
            </figure>
        </div>
        <div class="col">
            <div class="caixa">
                <i class="ico video"></i>
                <small>Aulas assistidas</small>
                <h3><?php echo count($aulasAssistidas) ?> </h3>
            </div>
        </div>
        <div class="col">
            <div class="caixa">
                <i class="ico curso"></i>
                <small>Cursos assisitidos</small>
                <h3><?php echo count($cursos) ?></h3>
            </div>
        </div>
        <!--<div class="col">
                <div class="caixa">
                        <i class="ico exercicio"></i>
                        <small>Exrcicios concluídos</small>
                        <h3>200</h3>
                </div>
        </div>-->
    </div>


    <div class="rows listagem">
        <div class="col-6 matriculados d-flex mb-3">
            <div class="caixa">
                <span class="titulo2">CURSOS MATRICULADOS</span>
                <div class="rolagem">
                    <div class="lista"> 
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <thead>
                                <tr>
                                    <th align="left">CURSOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cursos as $key => $curso) { ?>  
                                    <tr><td><a href="<?php echo URL_BASE . "escola/curso/" . $curso->curso_id ?>"><?php echo $curso->curso ?></a></td></tr> 
                                <?php } ?>  											
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--
                <div class="naoativo">
                        <img src="img/nao-matriculado.png"><h2>Nenhum curso matriculado</h2>
                </div>
                -->
            </div>
        </div>
        <div class="col-6 assistidos d-flex mb-3">						
            <div class="caixa">						
                <span class="titulo2">ÚLTIMAS AULAS ASSISITIDAS</span>
                <div class="rolagem mb-3">
                    <div class="lista">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                                <tr>
                                    <th align="left">CURSO</th>
                                    <th>DATA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($aulasAssistidas as $key => $aula) { ?>  
                                    <tr>
                                        <td><i></i> <?php echo $aula->aula ?> </td>
                                        <td align="center"><?php echo databr($aula->data_assistida) ?></td>
                                    </tr>
                                <?php } ?>                                                         
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="<?php echo URL_BASE ?>escola/meuscursos" class="btn btn-curso d-table">VER MEUS CURSOS</a>

                <!--	<div class="naoativo">
                                <img src="img/nao-matriculado.png"><h2>Nenhuma aula assistida</h2>
                        </div>
                -->
            </div>
        </div>
    </div>
</div>        

</div>
</div>
