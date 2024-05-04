<style>
    .hidden {
        display: none;
    }


    .clicavel {
        cursor: pointer;
        border: 1px solid #000;
        padding: 10px;
        margin: 5px;
    }

    .destacado {
        box-shadow: 0 0 10px 5px #89db89 !important;
        border: solid 1px #56e956 !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">
                Listagem de Composições padrão
            </h1>
            <a href="<?php echo URL_BASE . "Composicao/create/-1/-1" ?>" class="btn btn-secondary  btn-sm m-2">
                Criar composição padrão
            </a>
            <div class="row">

                <table id="tabela" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($composicao as $item) { ?>
                            <tr>
                                <td>
                                    <?php echo $item->composicao_nome; ?>
                                </td>
                                <td>
                                    <?php echo $item->composicao_tipo_nome; ?>
                                </td>

                                <td>
                                    <a href="<?php echo URL_BASE . "Composicao/padrao_item/" . $item->composicao_id ?>"
                                        class="btn btn-primary btn-sm">Editar</a>

                                    <a href="<?php echo URL_BASE . "Composicao/copia/" . $item->composicao_id ?>"
                                        class="btn btn-success btn-sm">Copiar</a>

                                    <button onclick="deletarItem(<?php echo $item->composicao_tipo_id; ?>)" type="button"
                                        class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        Deletar
                                    </button>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-auto">
                <a href="<?php echo URL_BASE ?>" class="btn btn-primary">Voltar</a>
            </div>

            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza de que deseja deletar este registro?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" id="modal_ok" class="btn btn-primary">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    controller = 'Composicao';
    caminhoRetornoDelete = '<?php echo 'Composicao/padrao' ?>';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

    function deletaEditar(botao) {
        idLinha = botao.getAttribute('id_linha');
    }

</script>