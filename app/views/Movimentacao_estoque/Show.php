<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Movimentação de estoque</h1>
            <div class="card col-12 mb-2">
                <div class="card-body">
                    <form action="<?php echo URL_BASE . "Movimentacao_estoque/pesquisar" ?>" method="POST">
                        <div class="row">
                            <div class="form-group mb-2 col-md-4 col-12">
                                <label for="produtos_id">Produto</label>
                                <select class="form-select" aria-label="Default select example" name="produtos_id"
                                    required>
                                    <?php foreach ($produtos as $produto) {
                                        echo "<option value='$produto->produtos_id'" . ($produto->produtos_id == $pesquisa->produtos_id ? "selected" : "") . ">$produto->produtos_nome</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group mb-2 col-md-2 col-12 mb-2">
                                <label for="dataInicio">Data inicial</label>
                                <input type="datetime-local" class="form-control" id="dataInicio" name="dataInicio"
                                    value="<?php echo (isset($pesquisa->dataInicio)) ? $pesquisa->dataInicio : ''; ?>">
                            </div>
                            <div class="form-group mb-2 col-md-2 col-12 mb-2">
                                <label for="dataFim">Data final</label>
                                <input type="datetime-local" class="form-control" id="dataFim" name="dataFim"
                                    value="<?php echo (isset($pesquisa->dataFim)) ? $pesquisa->dataFim : ''; ?>">
                            </div>
                            <div class="col-auto d-flex align-items-center justify-content-center">
                                <button type="submit" class="btn text-light btn-info">Pesquisar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-2 col-12 col-md-1">
                                <input type="checkbox" class="form-check-input" id="he_entrada" name="he_entrada" <?php echo (isset($pesquisa->he_entrada) && $pesquisa->he_entrada == 1) ? 'checked' : ''; ?>>
                                <label for="he_entrada">Entrada</label>
                            </div>
                            <div class="form-group mb-2 col-12 col-md-1">
                                <input type="checkbox" class="form-check-input" id="he_saida" name="he_saida" <?php echo (isset($pesquisa->he_saida) && $pesquisa->he_saida == 1) ? 'checked' : ''; ?>>
                                <label for="he_saida">Saída</label>
                            </div>
                            <div class="form-group mb-2 col-12 col-md-1">
                                <input type="checkbox" class="form-check-input" id="he_reserva" name="he_reserva" <?php echo (isset($pesquisa->he_reserva) && $pesquisa->he_reserva == 1) ? 'checked' : ''; ?>>
                                <label for="he_reserva">Reserva</label>
                            </div>

                        </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <table id="tabela" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Data da movimentação</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Descrição</th>
                <th>Usuário</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($intesPesquisados)) {
                foreach ($intesPesquisados as $item) { ?>
                    <tr>
                        <td>
                            <?php echo dataHoraBr($item->data); ?>
                        </td>
                        <td>
                            <?php echo $item->produtos_nome; ?>
                        </td>
                        <td>
                            <?php echo $item->quantidade; ?>
                        </td>
                        <td>
                            <?php echo $item->descricao; ?>
                        </td>
                        <td>
                            <?php echo $item->usuario; ?>
                        </td>
                    </tr>
                <?php }
            } ?>
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