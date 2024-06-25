<h1 class="ms-3">Grupos</h1>
<div class="row col-12">
    <div class="card col-12 m-2 m-md-4 p-4 p-md-4">
        <div class="col-md-12">
            <a href="<?php echo URL_BASE . 'Grupos/create' ?>" class="btn btn-primary mb-3">Adicionar um
                Grupos</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grupos as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->nome; ?>
                            </td>
                            <td>
                                <a href="<?php echo URL_BASE . "Grupos/edit/" . $item->grupos_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->grupos_id; ?>)" type="button"
                                    class="btn btn-danger btn-sm deletar" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    Deletar
                                </button>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-auto">
        <a href="<?php echo URL_BASE ?>" class="btn btn-primary">Voltar</a>
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
    $(document).ready(function () {
        var table = new DataTable('table.display', {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 20,

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Grupos';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>