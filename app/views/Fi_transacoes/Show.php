<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Valor</th>
                        <th>data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Conta</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fi_transacoes as $item) { ?>
                        <tr>
                            <td class="<?php echo (($item->tipo == 1) ? "saida" : "entrada") ?>">
                                <?php echo (($item->tipo == 1) ? "-" : "") . $item->valor; ?>
                            </td>
                            <td>
                                <?php echo databr($item->data); ?>
                            </td>
                            <td>
                                <?php echo $item->descricao; ?>
                            </td>
                            <td>
                                <?php echo $item->fi_categorias_nome; ?>
                            </td>
                            <td>
                                <?php echo $item->fi_conta_nome; ?>
                            </td>

                            <td>
                                <a href="<?php echo URL_BASE . "Fi_transacoes/edit/" . $item->fi_transacoes_id ?>"
                                    class="btn btn-primary btn-sm">Editar</a>

                                <button onclick="deletarItem(<?php echo $item->fi_transacoes_id; ?>)" type="button"
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
<div class="col-auto">
    <a href="<?php echo URL_BASE . "Fi_transacoes" ?>" class="btn btn-primary">Voltar</a>
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

    controller = 'Fi_transacoes';
    caminhoRetornoDelete = '<?php echo 'Fi_transacoes/show' ?>'
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>