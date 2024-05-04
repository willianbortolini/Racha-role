<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Foto do ambientes</h1>
            <a href="<?php echo URL_BASE   . "Foto_item_pedido/create" ?>" class="btn btn-primary mb-3">Adicionar Foto do ambiente</a>
            <hr>
            <input class="mb-1" type="text" id="filtro" placeholder="Filtrar por...">
            <table id="tabela" class="table table-bordered">
                <thead>
                    <tr>                        
                        <th>imagem</th>
                        <th>id do produto</th>

                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foto_item_pedido as $item) { ?>
                        <tr>
                            <td>
                                <?php if (isset($item->foto_item_pedido_caminho)) { ?>
                                    <img class="img-thumbnail" width="200" src="<?php echo (URL_IMAGEM_150 . $item->foto_item_pedido_caminho) ?>">
                                <?php } ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_id; ?>
                            </td>
                      
                            <td> 
                                <a href="<?php echo URL_BASE   . "Foto_item_pedido/edit/" . $item->foto_item_pedido_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button id_linha="<?php echo $item->foto_item_pedido_id; ?>" type="button"
                                    class="btn btn-danger btn-sm deletar" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                    Deletar
                                </button>

                            </td>   
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <ul id="paginacao" class="pagination"></ul>
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
        $('#filtro').keyup(function () {
            filtrarTabela($(this).val());
        });

        function filtrarTabela(filtro) {
            $('#tabela tbody tr').hide();
            $('#tabela tbody tr').each(function () {
                if ($(this).text().toLowerCase().indexOf(filtro.toLowerCase()) !== -1) {
                    $(this).show();
                }
            });
        }

        // Configuração da paginação
        var linhasPorPagina = 5;
        var totalLinhas = $('#tabela tbody tr').length;
        var totalPaginas = Math.ceil(totalLinhas / linhasPorPagina);

        for (var i = 1; i <= totalPaginas; i++) {
            $('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>').appendTo('#paginacao');
        }

        $('#tabela tbody tr').hide();
        $('#tabela tbody tr').slice(0, linhasPorPagina).show();

        $('#paginacao li:first-child').addClass('active');

        $('#paginacao li a').click(function () {
            var pagina = $(this).text();
            var inicio = (pagina - 1) * linhasPorPagina;
            var fim = inicio + linhasPorPagina;

            $('#tabela tbody tr').hide();
            $('#tabela tbody tr').slice(inicio, fim).show();

            $('#paginacao li').removeClass('active');
            $(this).parent('li').addClass('active');
        });
    });

    controller = 'Foto_item_pedido';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }

</script>