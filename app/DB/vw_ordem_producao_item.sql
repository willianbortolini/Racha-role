ALTER VIEW vw_ordem_producao_item  AS 
SELECT ordem_producao_item.*, produtos.descricao_os 
FROM ordem_producao_item 
inner join produtos on
produtos.produtos_id = ordem_producao_item.modelo