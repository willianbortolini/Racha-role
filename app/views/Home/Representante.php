<!-- Seção de Orçamentos -->
<div id="orcamentos" class="half">
    <h2>Orçamentos</h2>
    <form action="<?php echo URL_BASE . "Pedido/save" ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type='hidden' name='statusPedido_id' value='1'>
        <?php if ($habilitado) { ?>
            <button type="submit" class="btn btn-primary col-12 col-md-auto mb-3">Adicionar novo orçamento</button>
        <?php } ?>
    </form>
    <table id="tabelaOrcamento" class="display" style="width:100%">
        <thead>
            <tr>
                <th data-sortable="true">Orçamento</th>
                <th data-sortable="true">Descrição</th>
                <?php if (in_array(PERMITE_CADASTRARCLIENTENOPEDIDO, $_SESSION['acessos'])) { ?>
                    <th data-sortable="true">Cliente</th>
                <?php } ?>
                <th data-sortable="true">Data criação</th>
                <th data-sortable="true">Valor venda</th>
                <th data-sortable="false">Ação</th>
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
                            <?php echo $item->pedidos_nome; ?>
                        </td>
                        <?php if (in_array(PERMITE_CADASTRARCLIENTENOPEDIDO, $_SESSION['acessos'])) { ?>
                            <td>
                                <?php echo $item->cliente_nome; ?>
                            </td>
                        <?php } ?>
                        <td>
                            <?php echo databr($item->pedido_dataCriacao); ?>
                        </td>
                        <td>
                            <?php echo (isset($item->total_valor_venda)) ? moedaBr($item->total_valor_venda) : ""; ?>
                        </td>
                        <td>
                            <a href="<?php echo URL_BASE . "pedido/copiarPedido/" . $item->pedidos_id ?>"
                                class="btn btn-success btn-sm">copiar</a>
                            <a href="<?php echo URL_BASE . "Pedido/edit/" . $item->pedidos_id ?>"
                                class="btn btn-primary btn-sm">Editar</a>

                            <button onclick="deletarItem(<?php echo $item->pedidos_id; ?>)" type="button"
                                class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                Deletar
                            </button>

                        </td>
                    </tr>
                <?php }
            } ?>
        </tbody>
    </table>
</div>

<!-- Seção de Pedidos -->
<div id="pedidos" class="half">
    <h2>Pedidos</h2>
    <table id="tabelaPedidos" class="display" style="width:100%">
        <thead>
            <tr>
                <th data-sortable="true">Pedido</th>
                <th data-sortable="true">Descrição</th>
                <?php if (in_array(PERMITE_CADASTRARCLIENTENOPEDIDO, $_SESSION['acessos'])) { ?>
                    <th data-sortable="true">Cliente</th>
                <?php } ?>
                <th data-sortable="true">Data criação</th>
                <th data-sortable="true">Status</th>
                <th data-sortable="true">Valor venda</th>
                <th data-sortable="false">Ação</th>
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
                            <?php echo $item->pedidos_nome; ?>
                        </td>
                        <?php if (in_array(PERMITE_CADASTRARCLIENTENOPEDIDO, $_SESSION['acessos'])) { ?>
                            <td>
                                <?php echo $item->cliente_nome; ?>
                            </td>
                        <?php } ?>
                        <td>
                            <?php echo databr($item->pedido_dataCriacao); ?>
                        </td>
                        <td>
                            <span class="badge rounded-pill text-bg-<?php echo $statusClasses[$item->statusPedido_id] ?>">
                                <?php echo $item->statusPedido_nome; ?>
                            </span>
                        </td>
                        <td>
                            <?php echo (isset($item->total_valor_venda)) ? moedaBr($item->total_valor_venda) : ""; ?>
                        </td>
                        <td>
                            <a href="<?php echo URL_BASE . "pedido/copiarPedido/" . $item->pedidos_id ?>"
                                class="btn btn-success btn-sm">copiar</a>
                            <?php if ($item->statusPedido_id < PEDIDO_APROVADO) { ?>
                                <a href="<?php echo URL_BASE . "Pedido/edit/" . $item->pedidos_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>
                            <?PHP } else { ?>
                                <a href="<?php echo URL_BASE . "Pedido/visualizar/" . $item->pedidos_id ?>"
                                    class="btn btn-primary btn-sm">Visualizar pedido</a>
                            <?PHP } ?>
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

    controller = 'Pedido';
    caminhoRetornoDelete = ' ';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

</script>