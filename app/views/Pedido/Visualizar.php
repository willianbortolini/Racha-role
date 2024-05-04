<style>
    .hidden {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h1 class="mt-1">Itens do pedido</h1>
        <?php if (count($pedido_item) > 0) { ?>
            <table id="tabela" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="max-width: 80px;">Produto</th>
                        <th style="max-width: 80px;">Ambiente</th>
                        <th>Largura</th>
                        <th>Altura</th>
                        <th>Qtd.</th>
                        <th>Composição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedido_item as $item) { ?>
                        <tr>
                            <td style="max-width: 80px;">
                                <?php echo $item->produtos_nome; ?>
                            </td>
                            <td style="max-width: 80px;">
                                <?php echo $item->pedido_item_descricao; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_largura; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_altura; ?>
                            </td>
                            <td>
                                <?php echo $item->pedido_item_quantidade; ?>
                            </td>
                            <td style=" white-space: pre-line;">
                                <?php echo $item->pedido_item_composicao_descricao; ?>
                            </td>
                        </tr>
                    <?php } ?>


                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<div class="row">
    <div class="col-auto">
        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-primary">Voltar</a>
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

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
            },
        });

    });

</script>