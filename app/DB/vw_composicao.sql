alter VIEW vw_composicao AS
SELECT composicao.*, composicao_tipo.composicao_tipo_nome, composicao_padrao.composicao_nome composicao_padrao_nome,
posicao_op.descricao posicao_op_descricao, produtos.produtos_nome insumo_nome
FROM composicao
INNER JOIN composicao_tipo ON
composicao_tipo.composicao_tipo_id = composicao.composicao_tipo_id
LEFT JOIN composicao composicao_padrao ON
composicao_padrao.composicao_id = composicao.composicao_padrao_id
LEFT JOIN posicao_op ON
posicao_op.posicao_op_id = composicao.composicao_op_posicao
LEFT JOIN produtos ON
produtos.produtos_id = composicao.insumo