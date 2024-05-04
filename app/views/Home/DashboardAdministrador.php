<div class="row align-items-stretch d-flex">
    <div class="col-3 p-2">
        <div class="card">
            <h5 class="card-header">Resumo do mês</h5>
            <div class="card-body">
                <h5 class="card-title"></h5>
                <div><?php echo count($orcamentosDoMes) ?> Orçamentos</div>
                <div><?php echo count($pedidosDoMes) ?> Pedido</div>
            </div>
        </div>
    </div>
</div>
<div class="row align-items-stretch d-flex">
    <div class="col-6 p-2">
        <div class="card">
            <div id="orcamentos" class="half card-body">
                <div class="row">
                    <div class="col-6">
                        <h2>Orçamentos</h2>
                    </div>
                    <div class="col-auto">
                        <form action="<?php echo URL_BASE . "Pedido/save" ?>" method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <input type='hidden' name='statusPedido_id' value='1'>
                            <button type="submit" class="btn btn-primary float-end col-12 col-md-auto mb-3">Adicionar
                                novo
                                orçamento</button>
                        </form>
                    </div>
                </div>
                <table id="tabelaOrcamento" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th data-sortable="true">Nº</th>
                            <th data-sortable="true">Usuário</th>
                            <th data-sortable="true">Descrição</th>
                            <th data-sortable="true">Data criação</th>
                            <th data-sortable="true">Valor venda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orcamentos as $item) {
                            if ($item->statusPedido_id == 1) { ?>

                                <tr>
                                    <td>
                                        <?php echo $item->pedidos_id; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->usuario; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->pedidos_nome; ?>
                                    </td>
                                    <td>
                                        <?php echo databr($item->pedido_dataCriacao); ?>
                                    </td>
                                    <td>
                                        <?php echo (isset($item->total_valor_venda)) ?  moedaBr($item->total_valor_venda) : ""; ?>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6 p-2">
        <div class="card">
            <div id="pedidos" class="half  card-body">
                <h2>Pedidos</h2>
                <table id="tabelaPedidos" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th data-sortable="true">Nº</th>
                            <th data-sortable="true">Usuário</th>
                            <th data-sortable="true">Descrição</th>
                            <th data-sortable="true">Data criação</th>
                            <th data-sortable="true">Status</th>
                            <th data-sortable="true">Valor venda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $statusClasses = [
                            2 => 'primary',
                            3 => 'secondary',
                            4 => 'success',
                        ]; ?>
                        <?php foreach ($pedidos as $item) {
                            if ($item->statusPedido_id > 1) { ?>
                                <tr>
                                    <td>
                                        <?php echo $item->pedidos_id; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->usuario; ?>
                                    </td>
                                    <td>
                                        <?php echo $item->pedidos_nome; ?>
                                    </td>
                                    <td>
                                        <?php echo databr($item->pedido_dataCriacao); ?>
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill text-bg-<?php echo $statusClasses[$item->statusPedido_id] ?>">
                                            <?php echo $item->statusPedido_nome; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo (isset($item->total_valor_venda)) ?  moedaBr($item->total_valor_venda) : ""; ?>
                                    </td>

                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
                <ul id="paginacaoPedido" class="pagination"></ul>
            </div>
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
            "lengthChange": false,
            "searching": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 5,
            "columnDefs": [
                { type: 'date-br', targets: 3 } // Substitua 0 pelo índice da coluna de data
            ],
            "order": [
                [0, 'desc']
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Pedido';
    caminhoRetornoDelete = ' ';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

</script>