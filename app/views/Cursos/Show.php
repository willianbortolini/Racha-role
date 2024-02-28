<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Listagem de Cursos</h1>
            <a href="<?php echo URL_BASE . "Cursos/create" ?>" class="btn btn-primary mb-3">Adicionar Cursos</a>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nome do curso</th>
                        <th>Area</th>
                        <th>Descrição</th>
                        <th>Desconto</th>
                        <th>Preço original</th>
                        <th>Preço</th>
                        <th>professor</th>
                        <th>Imagem do curso</th>

                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Cursos as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->cursos_id; ?>
                            </td>
                            <td>
                                <?php echo $item->nome; ?>
                            </td>
                            <td>
                                <?php echo $item->area; ?>
                            </td>
                            <td>
                                <?php echo $item->descricao; ?>
                            </td>
                            <td>
                                <?php echo $item->desconto; ?>
                            </td>
                            <td>
                                <?php echo $item->preco_original; ?>
                            </td>
                            <td>
                                <?php echo $item->preco; ?>
                            </td>
                            <td>
                                <?php echo $item->professor_id_name; ?>
                            </td>
                            <td>
                                <?php if (isset($item->url_imagem)) { ?>
                                    <img class="img-thumbnail" width="200"
                                        src="<?php echo (URL_IMAGEM_150 . $item->url_imagem) ?>">
                                <?php } ?>
                            </td>

                            <td>
                                <a href="<?php echo URL_BASE . "Cursos/edit/" . $item->cursos_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->cursos_id; ?>)" type="button"
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

    controller = 'Cursos';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>