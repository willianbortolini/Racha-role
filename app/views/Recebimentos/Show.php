<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Recebimentoss</h1>
            <a href="<?php echo URL_BASE   . "Recebimentos/create" ?>" class="btn btn-primary mb-3">Adicionar Recebimentos</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr> 
                    <th>ID</th>                       
                        <th>Usuario</th>
                        <th>Curso</th>
                        <th>Valor</th>
                        <th>Método</th>
                        <th>Id mercado pago</th>
                        <th>Email</th>
                        <th>Data do recebimento</th>
                        <th>Status do recebimento</th>
                        <th>Data da liberação do recebimento</th>

                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recebimentos as $item) { ?>
                        <tr>
                        <td>
                                <?php echo $item->recebimentos_id; ?>
                            </td>
                            <td>
                                <?php echo $item->usuarios_id; ?>
                            </td>
                            <td>
                                <?php echo $item->cursos_id; ?>
                            </td>
                            <td>
                                <?php echo $item->valor; ?>
                            </td>
                            <td>
                                <?php echo $item->metodo; ?>
                            </td>
                            <td>
                                <?php echo $item->id_mercado_pago; ?>
                            </td>
                            <td>
                                <?php echo $item->email; ?>
                            </td>
                            <td>
                                <?php echo $item->recebimento_data; ?>
                            </td>
                            <td>
                                <?php echo $item->recebimento_status; ?>
                            </td>
                            <td>
                                <?php echo $item->recebimento_data_liberacao; ?>
                            </td>
                      
                            <td> 
                                <a href="<?php echo URL_BASE   . "Recebimentos/edit/" . $item->recebimentos_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->recebimentos_id; ?>)" type="button"
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
            "rowReorder": {
                selector: 'td:nth-child(2)'
            },
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Recebimentos';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>