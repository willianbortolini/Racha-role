<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Ordens de produção</h1>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>OP</th>
                        <th>Pedido</th>
                        <th>Criação</th>
                        <th>Confirmação do pedido</th>
                        <th>Inicio produção</th>
                        <th>Fim produção</th>
                        <th>Limite produção</th>
                        <th>Limite instalação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordem_producao as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->ordem_producao_id; ?>
                            </td>
                            <td>
                                <?php echo $item->pedidos_id; ?>
                            </td>
                            <td>
                                <?php echo databr($item->data_criacao) ?>
                            </td>
                            <td>
                                <?php echo databr($item->data_confirmacao_pedido); ?>
                            </td>
                            <td>
                                <?php echo dataHoraBr($item->data_inicio); ?>
                            </td>
                            <td>
                                <?php echo dataHoraBr($item->data_finalizacao); ?>
                            </td>
                            <td>
                                <?php echo databr($item->data_limite_producao); ?>
                            </td>
                            <td>
                                <?php echo databr($item->data_limite_instalcao); ?>
                            </td>

                            <td>
                                <a href="<?php echo URL_BASE . "Pedido/visualizar/" . $item->pedidos_id ?>"
                                    class="btn btn-secondary btn-sm mt-2">Visualizar pedido</a>
                                <a href="<?php echo URL_BASE . "ordem_producao/detalhe/" . $item->ordem_producao_id ?>"
                                    class="btn btn-secondary btn-sm mt-2">Visualizar OP</a>
                                <?php if ($item->data_inicio == '') { ?>
                                    <a href="<?php echo URL_BASE . "ordem_producao/iniciar/" . $item->ordem_producao_id ?>"
                                        class="btn btn-primary btn-sm mt-2">Iniciar OP</a>
                                <?php } ?>
                                <?php if (($item->data_inicio != '') && ($item->data_finalizacao == '')) { ?>
                                    <a href="<?php echo URL_BASE . "ordem_producao/finalizar/" . $item->ordem_producao_id ?>"
                                        class="btn btn-success btn-sm mt-2">Finalizar OP</a>
                                <?php } ?>
                                <?php if ($item->data_inicio == '') { ?>
                                    <button onclick="deletarItem(<?php echo $item->ordem_producao_id; ?>)" type="button"
                                        class="btn btn-danger btn-sm deletar mt-2" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        Deletar
                                    </button>
                                <?php } ?>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script>
    $(document).ready(function () {
        var table = new DataTable('table.display', {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Ordem_producao';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>