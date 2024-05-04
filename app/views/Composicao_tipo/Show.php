<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Tipo de composiçãos</h1>
            <a href="<?php echo URL_BASE . "Composicao_tipo/create" ?>" class="btn btn-primary mb-3">Adicionar Tipo de
                composição</a>
            <hr>
            <input class="mb-1" type="text" id="filtro" placeholder="Filtrar por...">
            <table id="tabela" class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($composicao_tipo as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->composicao_tipo_id; ?>
                            </td>
                            <td>
                                <?php echo $item->composicao_tipo_nome; ?>
                            </td>

                            <td>
                                <a href="<?php echo URL_BASE . "Composicao_tipo/edit/" . $item->composicao_tipo_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->composicao_tipo_id; ?>)" type="button"
                                    class="btn btn-danger btn-sm" data-bs-toggle="modal"
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
        var linhasPorPagina = 20;
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

    controller = 'Composicao_tipo';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>