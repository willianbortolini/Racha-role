SELECT
  pedido_item_id,
  GROUP_CONCAT(
    CONCAT(
      IF(
        compAvo.composicao_nome IS NOT NULL,
        CONCAT(compAvo.composicao_nome, '\n    '),
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