<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Faturas</h1>
            <a href="<?php echo URL_BASE . "Faturas/create" ?>" class="btn btn-primary mb-3 d-none">Adicionar Fatura</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Fatura</th>
                        <th>Usuários</th>
                        <th>Status</th>
                        <th>Data vencimento</th>
                        <th>Valor total</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fi_faturas as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->fi_faturas_id; ?>
                            </td>
                            <td>
                                <?php echo $item->fornecedor_nome; ?>
                            </td>
                            <td class="<?php
                            $dataVencimento = new DateTime($item->data_vencimento);
                            $dataVencimento->setTime(0, 0, 0);
                            $dataAtual = new DateTime();
                            $dataAtual->setTime(0, 0, 0);
                            if ($item->data_cancelamento > 0) {
                                $stilo_status = 'warning';
                            } else if ($item->data_pagamento > 0) {
                                $stilo_status = 'success';
                            } else if ($dataVencimento < $dataAtual) {
                                $stilo_status = 'danger';
                            } else {
                                $stilo_status = 'primary';
                            }
                            ?>">
                                <span class="badge rounded-pill text-bg-<?php echo $stilo_status ?>">
                                    <?php echo $item->status_fatura; ?>
                                </span>
                            </td>
                            <td>
                                <?php echo databr($item->data_vencimento) ?>
                            </td>
                            <td>
                                <?php echo $item->valor_total; ?>
                            </td>
                            <td>
                                <?php echo $item->descricao; ?>
                            </td>

                            <td>
                                <?php if ((!$item->data_pagamento > 0) && (!$item->data_cancelamento > 0)) { ?>
                                    <?php if ($item->permite_editar == 1) { ?>
                                        <a href="<?php echo URL_BASE . "Faturas/edit/" . $item->fi_faturas_id ?>"
                                            class="btn btn-primary btn-sm">Editar</a>

                                        <button onclick="deletarItem(<?php echo $item->fi_faturas_id; ?>)" type="button"
                                            class="btn btn-danger btn-sm deletar" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal">
                                            Deletar
                                        </button>
                                    <?php } ?>

                                    <a href="<?php echo URL_BASE . "Faturas/marcaPago/" . $item->fi_faturas_id ?>"
                                        class="btn btn-success btn-sm">Marcar como pago</a>

                                    <a href="<?php echo URL_BASE . "Faturas/marcaCancelado/" . $item->fi_faturas_id ?>"
                                        class="btn btn-warning btn-sm">Cancelar</a>
                                <?php } ?>
                                <?php if ($item->data_pagamento > 0) { ?>
                                    <a href="<?php echo URL_BASE . "Faturas/desmarcaPago/" . $item->fi_faturas_id ?>"
                                        class="btn btn-success btn-sm">Desmarcar como pago</a>
                                <?php } ?>
                                <?php if ($item->data_cancelamento > 0) { ?>
                                    <a href="<?php echo URL_BASE . "Faturas/desmarcaCancelado/" . $item->fi_faturas_id ?>"
                                        class="btn btn-warning btn-sm">Desmarcar como cancelar</a>
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

    controller = 'Faturas';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>