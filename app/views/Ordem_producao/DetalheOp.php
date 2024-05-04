<style>
    table {
        border: solid black 1px;
    }

    table td {
        border: solid black 1px;
        padding: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    table th {
        padding: 5px;
        text-align: center;
        border: solid black 1px;
    }

    @media print {

        #noprint,
        .botoes {
            display: none;
        }
    }
</style>
<div class="row">
    <?php if ($ordem_producao->data_inicio == '') { ?>
        <a href="<?php echo URL_BASE . "ordem_producao/iniciar/" . $ordem_producao->ordem_producao_id ?>"
            class="btn botoes col-auto m-3 btn-primary btn-sm">Iniciar OP</a>
    <?php } ?>
    <?php if (($ordem_producao->data_inicio != '') && ($ordem_producao->data_finalizacao == '')) { ?>
        <a href="<?php echo URL_BASE . "ordem_producao/finalizar/" . $ordem_producao->ordem_producao_id ?>"
            class="btn botoes col-auto m-3 btn-success btn-sm">Finalizar OP</a>
    <?php } ?>
</div>
<table id="tabelaCabecalho" class="display" style="width:100%">
    <tbody>
        <tr>
            <td>Pedido:
                <?php echo $ordem_producao->pedidos_id ?>
            </td>
            <td>Ordem Produção:
                <?php echo $ordem_producao->ordem_producao_id ?>
            </td>
            <td>Cliente: <?php echo $pedido->cliente_nome ?></td>
        </tr>
        <tr>
            <td>Data confirmação pedidos: <?php echo dataHoraBr($ordem_producao->data_confirmacao_pedido) ?></td>
            <td>Data limite produção: <?php echo dataHoraBr($ordem_producao->data_limite_producao) ?></td>
            <td>Data limite instalação: <?php echo dataHoraBr($ordem_producao->data_limite_instalcao) ?></td>
        </tr>
    </tbody>
</table>
<table id="tabela" class="display" style="width:100%">
    <thead>
        <tr>
            <th>item</th>
            <th>Cômodo</th>
            <th>Qtd.</th>
            <th>Tipo</th>
            <th>larg. (cm)</th>
            <th>alt. (cm)</th>
            <?php foreach ($posicoes as $posicao) {
                if ($posicao->ordem > -1) { ?>
                    <th>
                        <?php echo $posicao->descricao ?>
                    </th>
                <?php }
            } ?>
        </tr>
    </thead>
    <tbody>
        <?php $contItem = 0;
        $arrayOpcionais = array();
        foreach ($ordem_producao_item as $item) {
            $contItem = $contItem + 1; ?>
            <tr>
                <td>
                    <?php echo $contItem; ?>
                </td>
                <td style="max-width: 40px;">
                    <?php echo $item->ambiente; ?>
                </td>
                <td style="max-width: 40px;">
                    <?php echo $item->quantidade; ?>
                </td>
                <td>
                    <?php echo $item->descricao_os; ?>
                </td>
                <td>
                    <?php echo removeZerosADireita($item->largura); ?>
                </td>
                <td>
                    <?php echo removeZerosADireita($item->altura); ?>
                </td>
                <?php foreach ($posicoes as $posicao) {
                    $contem = false;
                    foreach ($posicaoItemOp as $itemPosicao) {
                        if (($posicao->posicao_op_id == $itemPosicao->posicao_op_id) && ($itemPosicao->ordem_producao_item_id == $item->ordem_producao_item_id)) {
                            if ($posicao->ordem == -1) {
                                $linha = array(
                                    'conteudo' => $itemPosicao->conteudo_op_item,
                                    'contItem' => $contItem
                                );
                                $arrayOpcionais[] = $linha;
                            } else {
                                echo '<td>' . $itemPosicao->conteudo_op_item . '</td>';
                            }
                            $contem = true;
                        }
                    }
                    if ((!$contem) && ($posicao->ordem > -1)) {
                        echo '<td></td>';
                    }
                } ?>

            </tr>
        <?php } ?>
    </tbody>
</table>
<table style="width:100%">
    <thead>
        <tr>
            <th colspan="2">Opcionais</th>
        </tr>
        <tr>
            <th style="width:130px">Item referencia</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            if (!empty($arrayOpcionais)) {
                foreach ($arrayOpcionais as $itensDoArrayOpcionais) { ?>
                <tr>
                    <td>
                        <?php echo $itensDoArrayOpcionais['contItem'] ?>
                    </td>
                    <td>
                        <?php echo $itensDoArrayOpcionais['conteudo'] ?>
                    </td>
                </tr>
            <?php }
            } else { ?>
            <td colspan="2">OP não possui nenhum opcional</td>
        <?php } ?>
        </tr>
    </tbody>
</table>
<table style="width:100%">
    <thead>
        <tr>
            <th colspan="2">Material utilizado</th>
        </tr>
        <tr>
            <th style="width:130px">Quantidade</th>
            <th>Material</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            if (!empty($reservasOp)) {
                foreach ($reservasOp as $reserva) { ?>
                <tr>
                    <td>
                        <?php echo $reserva->quantidade ?>
                    </td>
                    <td>
                        <?php echo $reserva->produtos_nome ?>
                    </td>
                </tr>
            <?php }
            } else { ?>
            <td colspan="2">OP não possui reserva de materiais</td>
        <?php } ?>
        </tr>
    </tbody>
</table>

<div class="row mt-4 botoes">
    <div class="col-auto">
        <a href="<?php echo URL_BASE . "ordem_producao"; ?>" class="btn btn-primary">Voltar</a>
    </div>
    <div class="col-auto">
        <button type="button" id="imprimir" onclick="imprimirConteudo()" class="btn btn-primary">imprimir</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script>
    function imprimirConteudo() {
        window.print(); // Função de impressão
    }
</script>