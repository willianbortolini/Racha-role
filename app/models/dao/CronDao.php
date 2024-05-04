<?php
namespace app\models\dao;
use app\core\Model;

class CronDao extends Model{  
    public function criaFatura()
    {

        $conn = $this->db;
        try {
            $sql = "INSERT INTO fi_faturas (fornecedor, empresa, data_emissao, data_vencimento, valor_total, descricao, permite_editar) "
                ."SELECT 1 fornecedor, " 
                . "usuario_tipo.empresa empresa, " 
                . "CURDATE() data_emissao,  "
                . "DATE_ADD(LAST_DAY(NOW()), INTERVAL 10 DAY) data_vencimento, " 
                . "COUNT(usuario_tipo.empresa)*25+200 valor_total,  "
                . "CONCAT('Fatura W9B2, R$100 pedidos + R$100 orçamentos personalizáveis + R$25 por representante "
                . "ativo (', CAST(count(usuario_tipo.empresa) AS CHAR), ' usuários ativos)') AS descricao, "
                . "0 permite_editar  "
                . "FROM usuario_tipo  "
                . "INNER JOIN usuarios ON "
                . "usuarios.usuarios_id = usuario_tipo.usuarios_id "
                . "WHERE usuario_tipo.usuario_tipo = 50 " 
                . "AND usuarios.habilitado = 1 "
                . "AND usuarios.he_representante = 1 "
                . "AND usuarios.he_administrador = 0 "
                . "GROUP BY usuario_tipo.empresa ";

            $stmt = $conn->prepare($sql);            
            $stmt->execute();            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }

}