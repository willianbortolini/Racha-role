<style>
    @media print {

        #noprint, .noprint,
        .botoes {
            display: none;
        }
    }
</style>
<div class="folha">
    <table class="table table-bordered" border="1" cellpadding="5" width='100%'>
        <tbody>

            <tr>
                <td>
                    <?php echo (isset($pedidos->pedidos_nome)) ? $pedidos->pedidos_nome : ''; ?>
                </td>
                <td>
                    Orçamento: <?php echo (isset($pedidos->pedidos_id)) ? $pedidos->pedidos_id : ''; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Validade do orçamento de 15 dias, a partir de
                </td>
                <td>
                    <?php echo date('d/m/Y'); ?>
                </td>
            </tr>
            <tr>

                <td>
                    Prazo para a instalação de 15 a 25 dias úteis.
                </td>
                <td>
                    vendedor: <?php echo (isset($pedidos->usuario)) ? $pedidos->usuario : ''; ?>
                </td>
            </tr>
        </tbody>

    </table>


    <?php if (count($pedido_item) > 0) { ?>
        <table id="tabela" class="table table-bordered" border="1" cellpadding="5" width='100%'>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Descrição</th>
                    <th>Largura</th>
                    <th>Altura</th>
                    <th class="colunaLimitada">Composição</th>
                    <th>Quantidade</th>
                    <th>Valor Venda</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedido_item as $item) { ?>
                    <tr>
                        <td>
                            <?php echo $item->produtos_nome; ?>
                        </td>
                        <td class="colunaLimitada">
                            <?php echo $item->pedido_item_descricao; ?>
                        </td>
                        <td>
                            <?php echo $item->pedido_item_largura; ?>
                        </td>
                        <td>
                            <?php echo $item->pedido_item_altura; ?>
                        </td>
                        <td>

                            <pre><?php echo $item->pedido_item_composicao_descricao; ?></pre>

                        </td>
                        <td>
                            <?php echo $item->pedido_item_quantidade; ?>
                        </td>
                        <td>
                            <?php echo (isset($item->pedido_item_valor_venda)) ? moedaBr($item->pedido_item_valor_venda) : NULL; ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6" class="text-right">
                        Valor total
                    </td>
                    <td>
                        <?php echo (isset($pedidos->total_valor_venda)) ? moedaBr($pedidos->total_valor_venda) : NULL; ?>
                    </td>
                </tr>

            </tbody>
        </table>
    <?php } ?>
</div>

<div class="row botoes">
    <div class="col-auto">
        <button type="button" id="imprimir" onclick="imprimirConteudo()" class="btn btn-primary">imprimir</button>
    </div>
    <div class="col-auto">
        <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-primary">Voltar</a>
    </div>

</div>

<script>
    function imprimirConteudo() {
        window.print(); // Função de impressão
    }
</script>