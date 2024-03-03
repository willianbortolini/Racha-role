<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Usuários membros desse inventário</h1>
            <a href="<?php echo URL_BASE   . "Inventario"?>" class="btn btn-sm btn-outline-info m-1 col-12 col-md-auto">Voltar para inventarios</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Inventario</th>
                        <th>usuario</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventario_compartilhado as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->nome; ?>
                            </td>
                            <td>
                                <?php echo $item->email; ?>
                            </td>
                            <td>
                                <?php if ($item->habilitado == 1) { ?>
                                    <a href="<?php echo URL_BASE . "Inventario_compartilhado/desabilitar/" . $item->inventario_compartilhado_id ?>"
                                        class="btn btn-outline-primary btn-sm">Desabilitar</a>
                                <?php } else { ?>
                                    <a href="<?php echo URL_BASE . "Inventario_compartilhado/habilitar/" . $item->inventario_compartilhado_id ?>"
                                        class="btn btn-outline-primary btn-sm">Habilitar</a>
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
            "rowReorder": {
                selector: 'td:nth-child(2)'
            },
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Inventario_compartilhado';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>