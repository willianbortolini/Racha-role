<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Contas</h1>
            <a href="<?php echo URL_BASE   . "Fi_conta/create" ?>" class="btn btn-primary mb-3">Adicionar Conta</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>                        
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fi_conta as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->fi_conta_nome; ?>
                            </td>
                      
                            <td> 
                                <a href="<?php echo URL_BASE   . "Fi_conta/edit/" . $item->fi_conta_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button  onclick="deletarItem(<?php echo $item->fi_conta_id; ?>)" type="button"
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

    controller = 'Fi_conta';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>