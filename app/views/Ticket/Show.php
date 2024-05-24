<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Ticketss</h1>
            <a href="<?php echo URL_BASE   . "Ticket/create" ?>" class="btn btn-primary mb-3">Adicionar Tickets</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>                        
                        <th>Ticket ID</th>
                        <th>User ID</th>
                        <th>Subject</th>
                        <th>Imagem de perfil</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created At</th>
                        <th>Updated At</th>

                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->tickets_id; ?>
                            </td>
                            <td>
                                <?php echo $item->user_id; ?>
                            </td>
                            <td>
                                <?php echo $item->subject; ?>
                            </td>
                            <td>
                                <?php if (isset($item->imagem_perfil)) { ?>
                                    <img class="img-thumbnail" width="200" src="<?php echo (URL_IMAGEM_150 . $item->imagem_perfil) ?>">
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo $item->description; ?>
                            </td>
                            <td>
                                <?php echo $item->status; ?>
                            </td>
                            <td>
                                <?php echo $item->priority; ?>
                            </td>
                            <td>
                                <?php echo $item->created_at; ?>
                            </td>
                            <td>
                                <?php echo $item->updated_at; ?>
                            </td>
                      
                            <td> 
                                <a href="<?php echo URL_BASE   . "Ticket/edit/" . $item->tickets_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->tickets_id; ?>)" type="button"
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

    controller = 'Ticket';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>