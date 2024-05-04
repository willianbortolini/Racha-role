<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-1">Estoque</h1>
            <hr>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Qtd. estoque</th>
                        <th>Qtd. reservado</th>
                        <th>Qtd. disponível</th>
                        <th>Estoque minimo</th>
                        <th>Preço médio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item->produtos_nome; ?>
                            </td>
                            <td>
                                <?php echo $item->estoque_quantidade; ?>
                            </td>
                            <td>
                                <?php echo $item->quantidade_reservada; ?>
                            </td>                            
                            <td>
                                <?php echo $item->estoque_quantidade - $item->quantidade_reservada; ?>
                            </td>
                            <td>
                                <?php echo $item->estoque_minimo; ?>
                            </td>
                            <td>
                                <?php echo moedaBr($item->preco_medio) ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-auto">
    <a href="<?php echo URL_BASE ?>" class="btn btn-primary">Voltar</a>
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

<script>
    $(document).ready(function () {
        var table = new DataTable('table.display', {
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 50,             
            "order": [
                [1, 'asc'] 
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

    controller = 'Produtos';
    var idLinha = 0;
    function deletarItem(id) {
        idLinha = id;
    }
</script>
