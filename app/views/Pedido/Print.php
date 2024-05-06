<style>
    @media print {

        #noprint,
        .botoes {
            display: none;
        }

        @page {
            size: auto;
            margin: 5mm 10mm 5mm 10mm;
            /* Ajuste as margens conforme necessário */
        }

        .folha {
            font-size: 10pt;
            width: 100%;
            /* Mudado de 900px para 100% para melhor ajuste */
            margin: auto;
        }

        .imagem-pg {
            width: 100%;
            /* Ajuste a largura para 100% para melhorar a compatibilidade de impressão */
            page-break-after: always;
            /* Isso fará com que cada imagem seja seguida por uma quebra de página */
        }

        .imagem {
            width: 100%;
        }

        th {
            background-color: #f29219 !important;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        .primeira_coluna {
            max-width: 150px;
            background-color: #233671 !important;
            color: white !important;
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        .conta {
            position: relative;
            display: inline-block;
        }

        .imagem-maior {
            width: 100%;
            display: block;
        }

        .imagem-menor {
            display: none;
        }

        .imagem-fundo {
            display: block;
            page-break-after: always;
            width: 100%;
        }


    }

    @page {
        size: auto;
        margin: 5mm 10mm 5mm 10mm;
    }

    .text-right {
        text-align: right;
    }

    .folha {
        width: 900px;
        margin: auto;
    }

    .imagem-pg {
        width: 900px;
    }

    .imagem {
        width: 900px;
    }

    .conta {
        position: relative;
        display: inline-block;
        /* Ajusta ao tamanho da imagem maior */
    }

    .imagem-maior {
        width: 100%;
        /* Ajusta a largura do contêiner */
        display: block;
        /* Remove o espaço abaixo da imagem */
    }

    th {
        text-align: center;
        background-color: #d0d0d0 !important;
    }

    td {
        text-align: center;
        padding: 10px !important;
        font-weight: 600 !important;
    }

    .primeira_coluna {
        max-width: 150px;
        background-color: #233671 !important;
        color: white !important;
    }

    .botoes {
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1000;
        /* Garante que a div fique acima de outros elementos da página */
    }

    .table {
        border-color: #8f8f8f !important;
    }

    /* Estilos específicos para dispositivos móveis */
    @media screen and (max-width: 768px) {
        .folha {
            width: 100%;
            /* Largura total para dispositivos móveis */
        }

        .imagem {
            width: 100%;
            /* Largura total para dispositivos móveis */
        }

        .folha {
            font-size: 9pt;
        }
    }
</style>
<div class="folha">
    <div class='conta'>
        <?php echo $usuario->orcamento_pagina_1 ?>
    </div>
</div>
<div class="folha">
    <div class='conta'>
        <?php echo $usuario->orcamento_pagina_2 ?>
    </div>
</div>
<div>
    <div class="folha">
        <div class='conta'>
            <?php echo $usuario->orcamento_pagina_3 ?>
        </div>
    </div>
</div>

<div>
    <div class="folha">
        <div class='conta'>
            <?php echo $usuario->orcamento_pagina_4 ?>
        </div>
    </div>

    <?php if (count($pedido_item) > 0) { ?>
        <div class="folha">
            <table id="tabela" class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Orçamento <?php echo $pedidos->pedidos_id ?></td>
                        <td>Emitido em: <?php echo databr($pedidos->pedido_dataCriacao) ?></td>
                        <td>Válido até:
                            <?php echo databr(date('Y-m-d', strtotime($pedidos->pedido_dataCriacao . ' +7 days'))); ?>
                        </td>
                    </tr>
                </tbody>
                <table id="tabela" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SERVIÇO</th>
                            <th>DESCRIÇÃO</th>
                            <th>QUANTIDADE</th>
                            <th>INVESTIMENTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedido_item as $item) { ?>
                            <tr>
                                <td>
                                    <?php echo mb_strtoupper($item->produtos_nome, 'UTF-8') ?>
                                </td>
                                <td>
                                    <?php echo mb_strtoupper($item->pedido_item_descricao, 'UTF-8'); ?>
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
                            <td>

                            </td>
                            <td>
                            </td>
                            <td class="primeira_coluna">
                                TOTAL
                            </td>
                            <td class="primeira_coluna">
                                <?php echo moedaBr($pedidos->total_valor_venda); ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
        </div>
    <?php } ?>

    <div class="folha">
        <div class='conta'>
            <?php echo $usuario->orcamento_pagina_5 ?>
        </div>
    </div>
</div>

<?php foreach ($imagem_produto as $item) {
    if (isset($item)) { ?>
        <div class="folha">
            <div class='conta'>
                <?php echo $item ?>
            </div>
        </div>
    <?php }
} ?>

<div class="folha">
    <div class='conta'>
        <?php echo $usuario->orcamento_pagina_6 ?>
    </div>
</div>
<div class="folha">
    <div class='conta'>
        <?php echo $usuario->orcamento_pagina_7 ?>
    </div>
</div>
</div>

<div class="row botoes">
    <?php if (isset($_SESSION['id'])) { ?>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Pedido/edit/" . $pedidos->pedidos_id ?>" class="btn btn-primary">Voltar</a>
        </div>
    <?php } ?>
    <div class="col-auto">
        <button type="button" id="imprimir" onclick="imprimirConteudo()" class="btn btn-primary">imprimir</button>
    </div>
    <div class="col-auto">
        <button type="button" onclick="copiarLink()" class="btn btn-primary">Copiar link compartilhável</button>
    </div>
</div>

<script>
    function imprimirConteudo() {
        window.print(); // Função de impressão
    }

    function copiarLink() {
        // Define o link que você quer copiar
        var linkParaCopiar = "<?php echo URL_BASE . 'Pedido/cliente/' . $pedidos->codigo_acesso_cliente ?>";

        // Cria um elemento input temporário para ajudar na cópia do link
        var tempInput = document.createElement("input");
        tempInput.value = linkParaCopiar;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput); // Remove o input temporário

        // Seleciona o botão pelo evento ou por ID se necessário
        var botao = event.currentTarget;

        // Muda a cor e o texto do botão
        botao.classList.remove("btn-primary");
        botao.classList.add("btn-secondary");
        botao.textContent = "Link compartilhável copiado";

        // Espera 10 segundos e reverte as mudanças
        setTimeout(function () {
            botao.classList.remove("btn-secondary");
            botao.classList.add("btn-primary");
            botao.textContent = "Copiar link compartilhável";
        }, 5000); // 10000 milissegundos = 10 segundos
    }
</script>