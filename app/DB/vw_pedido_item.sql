alter VIEW vw_pedido_item AS
SELECT
    produtos.produtos_nome,
    produtos.imagem_produto,
    pedido_item.pedido_item_altura,
    pedido_item.pedido_item_id,
    pedido_item.pedido_item_largura,
    pedido_item.pedido_item_quantidade,
    pedido_item.pedido_item_valor_opcionais,
    pedido_item.pedido_item_valor_total,
    pedido_item.pedido_item_valor_unitario,
    pedido_item.pedidos_id,
    pedido_item.produtos_id,
    pedido_item.pedido_item_descricao,
    pedido_item.pedido_item_composicao_descricao,
    pedido_item.pedido_item_markup,
    (
        pedido_item.pedido_item_valor_total * pedido_item.pedido_item_markup
    ) pedido_item_valor_venda,
    (
        SELECT
            GROUP_CONCAT(
                CONCAT(
                    IF(
                        compAvo.composicao_nome IS NOT NULL,
                        CONCAT(compAvo.composicao_nome, '\n └ '),
                        ''
                    ),
                    IF(
                        compPai.composicao_nome IS NOT NULL,
                        CONCAT(compPai.composicao_nome, ' / '),
                        ''
                    ),
                    composicao.composicao_nome,
                    IF(
                        composicao.composicao_tipo_id IN (2, 6),
                        CONCAT(
                            ': ',
                            pedido_item_composicao.pedido_item_composicao_valor
                        ),
                        ''
                    ),
                    IF(
                        composicao.composicao_tipo_id = 9,
                        CONCAT(
                            ': ',
                            pedido_item_composicao.texto
                        ),
                        ''
                    )
                )
                ORDER BY
                    composicao.composicao_id SEPARATOR '\n'
            ) AS resultado
        FROM
            pedido_item_composicao
            INNER JOIN composicao ON composicao.composicao_id = pedido_item_composicao.composicao_id
            LEFT JOIN composicao compPai ON compPai.composicao_id = composicao.composicao_pai_id
            LEFT JOIN composicao compAvo on compAvo.composicao_id = compPai.composicao_pai_id
        WHERE
            pedido_item_id = pedido_item.pedido_item_id
            AND composicao.composicao_tipo_id <> 8
            AND composicao.composicao_tipo_id <> 7
        GROUP BY
            pedido_item_id
    ) AS composicoes
FROM
    pedido_item
    LEFT JOIN produtos ON produtos.produtos_id = pedido_item.produtos_id