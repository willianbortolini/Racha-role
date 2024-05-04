<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Pedido item composiçãos</h1>
            <a href="<?php echo URL_BASE . "Pedido_item_composicao/create" ?>" class="btn btn-primary mb-3">Adicionar
                Pedido item composição</a>
            <hr>
            <input class="mb-1" type="text" id="filtro" placeholder="Filtrar por...">
            <table id="tabela" class="table table-bordered">
                <thead>
                    <tr>
                        <th>pedido_item_id</th>
                        <th>composicao_id</th>
                        <th>valor no select</th>
                        <th>valor financeiro</th>

                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedido_item_composicao as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->pedido_item_id; ?>
                            </td>
                            <td>
                                <?php echo $item->composicao_id; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_composicao_valor; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_composicao_valorMonetario; ?>
                            </td>

                            <td>
                                <a href="<?php echo URL_BASE . "Pedido_item_composicao/edit/" . $item->pedido_item_composicao_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->pedido_item_composicao_id; ?>)" type="button"
                                    class="btn btn-danger btn-sm " data-bs-toggle="modal"
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
        var linhasPorPagina = 25;
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

    controller = 'Pedido_item_composicao';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
    
</script>