<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem acessos do usuário</h1>
            <div class="list-unstyled">
                <form action="<?php echo URL_BASE . "Usuario_acesso/save" ?>" method="POST">
                    <lu>
                        <?php foreach ($telas as $tela => $desc) { ?>
                            <li>
                                <div class="form-group mb-2 col-12 col-md-6 ">
                                    <input type="hidden" name="<?php echo $tela ?>" value="off">
                                    <input type="checkbox" class="form-check-input" id="<?php echo $tela ?>" value="on"
                                        <?php echo ((in_array($tela, $usuario_acesso))) ? 'checked' : ''; ?>
                                        name="<?php echo $tela ?>">
                                    <label for="<?php echo $tela ?>"><?php echo $desc ?> </label>
                                </div>
                            </li>
                        <?php } ?>
                    </lu>

                    <input type="hidden" name="usuarios_id"
                        value="<?php echo (isset($usuarios_id)) ? $usuarios_id : NULL; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    
                    <div class="row">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                        <div class="col-auto">
                            <a href="<?php echo URL_BASE . "/User/edit/" . $usuarios_id?>" class="btn btn-primary">Voltar</a>
                        </div>
                    </div>
                </form>
            </div>
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

    controller = 'Usuario_acesso';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>