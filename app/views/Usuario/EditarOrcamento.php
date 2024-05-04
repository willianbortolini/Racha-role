<style>
    .conta {
        position: relative;
        display: inline-block;
        /* Ajusta ao tamanho da imagem maior */
    }

    .imagem-maior {
        width: 100%;
        /* Ajusta a largura do contêiner */
        display: block;
        /* Remove o espaço abaixo da imagem */
    }

    .imagem-menor {
        display: none;
    }

    .folha {
        width: 250;
        margin: auto;
    }
</style>

<form action="<?php echo URL_BASE . "User/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="row">        
        <div class="card p-2 m-2">
            <h3>Páginas do orçamento</h3>
            <div class="row">
                <?php for ($i = 1; $i <= 7; $i++) {
                    $nomePropriedade = "orcamento_pagina_" . $i; ?>
                    <div class=" col-md-3 col-12">
                        <label for="<?= $nomePropriedade ?>">
                            <?php switch ($i) {
                                case 1:
                                    echo "Capa";
                                    break;
                                case 2:
                                    echo "Quem somos";
                                    break;
                                case 3:
                                    echo "Nossos diferenciais";
                                    break;
                                case 4:
                                    echo "Parte superior da tabela de valores";
                                    break;
                                case 5:
                                    echo "Parte inferior da tabela de valores";
                                    break;
                                case 6:
                                    echo "Penultima página";
                                    break;
                                case 7:
                                    echo "Ultima página";
                                    break;

                                default:
                                    echo "";
                            } ?>
                        </label>
                        <div class="form-group mb-2">
                            <a href="<?php echo URL_BASE . 'User/editImagemOrcamento/' . $i .'/'.$usuarios->usuarios_id ?>">
                                <?php if (isset($usuarios->$nomePropriedade) && $usuarios->$nomePropriedade != '') { ?>
                                    <div class="folha">
                                        <?php echo $usuarios->$nomePropriedade ?>
                                    </div>
                                <?php } else { ?>
                                    <label class="container-imagem" for="<?= $nomePropriedade ?>">
                                        <svg class="bd-placeholder-img " width="250" height="353" role="img" focusable="false">
                                            <rect width="100%" height="100%" fill="#868e96"></rect>
                                            <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                                        </svg>
                                    </label>
                                <?php } ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>       
        <div class="row">
            <div class="col-auto">
                <a href="<?php echo URL_BASE . "User/Edit/" . $usuarios->usuarios_id; ?>" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>
</form>

<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>