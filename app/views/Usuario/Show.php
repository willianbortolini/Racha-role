<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Representantes</h1>
            <a href="<?php echo URL_BASE . ((isset($tipo_usuario))?'User/create/'.$tipo_usuario:'User/create') ;?>" class="btn btn-primary mb-3">Adicionar um
                representante</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>nome completo</th>
                        <th>celular</th>
                        <th>estado</th>
                        <th>cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->usuario; ?>
                            </td>
                            <td>
                                <?php echo $item->email; ?>
                            </td>
                            <td>
                                <?php echo $item->nome_completo; ?>
                            </td>
                            <td>
                                <?php echo $item->celular; ?>
                            </td>
                            <td>
                                <?php echo $item->estado; ?>
                            </td>
                            <td>
                                <?php echo $item->cidade; ?>
                            </td>

                            <td>
                                <?php if ($item->habilitado == 1) {?>
                                    <a href="<?php echo URL_BASE . "User/desabilitaRepresentante/" . $item->usuarios_id ?>"
                                    class="btn btn-success btn-sm">Desabilita</a>
                                    <?php }else{?>
                                        <a href="<?php echo URL_BASE . "User/habilitaRepresentante/" . $item->usuarios_id ?>"
                                    class="btn btn-warning btn-sm">Habilita</a>
                                        <?php }?>   
                                <a href="<?php echo URL_BASE . "User/edit/" . $item->usuarios_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->usuarios_id; ?>)" type="button"
                                    class="btn btn-danger btn-sm " data-bs-toggle="modal"
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

    controller = 'User';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }    
</script>