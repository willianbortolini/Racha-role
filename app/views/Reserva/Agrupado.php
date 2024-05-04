<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Reservas por pedido</h1>
            <div class="card col-12 mb-2">
                <div class="card-body">
                    <form action="<?php echo URL_BASE . "Reserva/pesquisar" ?>" method="POST">


                        <div class="row">
                            <label for="pedidos">Pedidos</label>
                            <div class="overflow-auto col-1" style="max-height: 200px;">
                                <?php foreach ($pedidos as $pedido) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="pedido<?php echo $pedido->pedidos_id ?>" name="pedidos[]"
                                            value="<?php echo $pedido->pedidos_id ?>" <?php echo (in_array($pedido->pedidos_id, $pesquisa->pedidos)) ? 'checked' : ''; ?>>
                                        <label class="form-check-label"
                                            for="pedido<?php echo $pedido->pedidos_id ?>"><?php echo $pedido->pedidos_id ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="form-group mb-2 col-12 col-md-2">
                                <input type="checkbox" class="form-check-input" id="reservado_sim" name="reservado_sim"
                                    <?php echo ((isset($pesquisa->reservado_sim) && $pesquisa->reservado_sim == 1) or (!isset($pesquisa->reservado_sim))) ? 'checked' : ''; ?>>
                                <label for="reservado_sim">Reservado</label>
                            </div>
                            <div class="form-group mb-2 col-12 col-md-2">
                                <input type="checkbox" class="form-check-input" id="reservado_nao" name="reservado_nao"
                                    <?php echo (isset($pesquisa->reservado_nao) && $pesquisa->reservado_nao == 1) ? 'checked' : ''; ?>>
                                <label for="reservado_nao">Liberado</label>
                            </div>

                            <div class="col-auto d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn text-light btn-info">Pesquisar</button>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <?php //i($reserva); ?>
    <hr>
    <table id="tabela" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reserva as $item) { ?>
                <tr>
                    <td>
                        <?php echo $item->produtos_nome; ?>
                    </td>
                    <td>
                        <?php echo $item->quantidade; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
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
            "pageLength": 25,
            "columnDefs": [
                { type: 'date-br', targets: 0 }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

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

</script>