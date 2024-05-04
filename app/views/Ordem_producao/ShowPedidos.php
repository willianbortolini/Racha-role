<!-- Seção de Pedidos -->
<div id="pedidos" class="half">
    <h2>Pedidos</h2>
    <table id="tabelaPedidos" class="display" style="width:100%">
        <thead>
            <tr>
                <th data-sortable="true">Pedido</th>
                <th data-sortable="true">Descrição</th>
                <th data-sortable="true">Data criação</th>
                <th data-sortable="false">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $item) {
                if ($item->statusPedido_id > 1) { ?>
                    <tr>
                        <td>
                            <?php echo $item->pedidos_id; ?>
                        </td>
                        <td>
                            <?php echo $item->pedidos_nome; ?>
                        </td>
                        <td>
                            <?php echo databr($item->pedido_dataCriacao); ?>
                        </td>
                        <td>
                            <a href="<?php echo URL_BASE . "Pedido/visualizar/" . $item->pedidos_id ?>"
                                class="btn btn-primary btn-sm">Visualizar pedido</a>
                            <?php if (!isset($item->ordem_producao_id)) { ?>
                                <a href="<?php echo URL_BASE . "ordem_producao/criarOsComPedido/" . $item->pedidos_id ?>"
                                    class="btn btn-secondary btn-sm">Criar OP</a>
                            <?php } else { ?>
                                <a href="<?php echo URL_BASE . "ordem_producao/detalhe/" . $item->ordem_producao_id ?>"
                                    class="btn btn-secondary btn-sm">Visualizar OP</a>
                                <?php if ($item->data_inicio == '') { ?>
                                    <button onclick="deletarItem(<?php echo $item->ordem_producao_id; ?>)" type="button"
                                        class="btn btn-danger btn-sm deletar" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        Deletar OP
                                    </button>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php }
            } ?>
        </tbody>
    </table>
    <ul id="paginacaoPedido" class="pagination"></ul>
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

<script>
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-br-pre": function (a) {
            if (a == null || a == "") {
                return 0;
            }
            var brDatea = a.split('/');
            return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
        },

        "date-br-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-br-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });
    $(document).ready(function () {

        var table = new DataTable('table.display', {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { type: 'date-br', targets: 2 } // Substitua 0 pelo índice da coluna de data
            ],
            "order": [
                [0, 'desc']
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Ordem_producao';
    caminhoRetornoDelete = 'ordem_producao/pedidos_ordens_producao';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

</script>