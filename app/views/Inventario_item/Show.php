<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if ($habilitado == 1) { ?>
                <h1 class="mt-1 text-center">ITENS DO INVENTARIO</h1>
                <a href="<?php echo URL_BASE . "Inventario_item/create/" . $inventario ?>"
                    class="btn btn-sm btn-outline-info m-1 col-12 col-md-auto">Adicionar EAN manualmente</a>
                <?php if ($mobile) { ?>
                    <a href="<?php echo URL_BASE . "Inventario_item/coletor/" . $inventario ?>"
                        class="btn btn-sm btn-outline-info m-1 col-12 col-md-auto">Ir para coletor</a>
                <?php } ?>
            <?php } ?>
            <a href="<?php echo URL_BASE . "Inventario" ?>"
                class="btn btn-sm btn-outline-info m-1 col-12 col-md-auto">Voltar para inventarios</a>

            <hr>

            <?php if ($habilitado == 1) { ?>
                <table id="tabela" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>EAN-13</th>
                            <th>Qtd.</th>
                            <th>Rua</th>
                            <th>Coluna</th>
                            <th>Nível</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventario_item as $item) { ?>
                            <tr>
                                <td>
                                    <?php echo $item->ean13; ?>
                                </td>
                                <td>
                                    <?php echo $item->quantidade; ?>
                                </td>
                                <td>
                                    <?php echo $item->rua; ?>
                                </td>
                                <td>
                                    <?php echo $item->coluna; ?>
                                </td>
                                <td>
                                    <?php echo $item->nivel; ?>
                                </td>
                                <td>
                                    <a href="<?php echo URL_BASE . "Inventario_item/edit/" . $item->inventario_item_id ?>"
                                        class="btn btn-sm btn-outline-primary mb-1">Editar</a>

                                    <button onclick="deletarItem(<?php echo $item->inventario_item_id; ?>)" type="button"
                                        class="btn btn-sm btn-outline-danger deletar mb-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        Deletar
                                    </button>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h3>Você não esta habilitado a editar esse inventário, solicite ao criador do inventário para liberar o seu
                    usuário nos membros do inventátio.</h3>
            <?php } ?>
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
            "pageLength": 25,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    caminhoRetornoDelete = 'Inventario_item/index/'+ '<?php echo $inventario ?>';
    controller = 'Inventario_item';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>