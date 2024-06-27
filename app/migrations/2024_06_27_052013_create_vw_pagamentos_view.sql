CREATE VIEW vw_pagamentos AS
SELECT t.*, f_pagador.username AS pagador_nome, f_recebedor.username AS recebedor_nome
FROM pagamentos t
JOIN users f_pagador ON t.pagador = f_pagador.users_id
JOIN users f_recebedor ON t.recebedor = f_recebedor.users_id
