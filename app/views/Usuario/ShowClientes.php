<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Clientes</h1>
            <a href="<?php echo URL_BASE . 'User/createCliente'?>" class="btn btn-primary mb-3">Adicionar um
                cliente</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome</th>                        
                        <th>celular</th>
                        <th>telefone</th>
                        <th>estado</th>
                        <th>cidade</th>
                        <th>endereço</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    
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
   
    $(document).ready(function() {
        var table = new DataTable('table.display', {
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "autoWidth": false,
                "ajax": URL_BASE + "user/listaUsuarios",
                "language": {
                    "url": '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                }
            });
        });
    caminhoRetornoDelete = 'user/clientes';
    controller = 'User';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }    
</script>