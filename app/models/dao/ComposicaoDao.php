<?php
namespace app\models\dao;
use app\core\Model;

class ComposicaoDao extends Model
{   
    public function composicao($produto_id)
    {

        $conn = $this->db;
        try {
            $sql = "WITH RECURSIVE composicao_recursiva AS ( "
                    ."SELECT * " 
                    ."FROM vw_composicao "
                    ."WHERE produtos_id = :produtos_id "                
                    ."UNION ALL "                
                    ."SELECT "
                    .    "c.* "
                    ."FROM vw_composicao c "
                    ."JOIN composicao_recursiva cr ON "
                    .    "((cr.composicao_padrao_id = c.composicao_id)OR(c.composicao_pai_id = cr.composicao_id AND c.produtos_id = -1)) "
                .") "
                ."SELECT DISTINCT * "
                ."FROM composicao_recursiva " 
                ."ORDER BY composicao_ordem, composicao_id asc";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":produtos_id", $produto_id);             
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function composicoesDeUmaComposicao($composicao_id)
    {

        $conn = $this->db;
        try {
            $sql = "WITH RECURSIVE composicao_recursiva AS ( "
            ."    SELECT *  "
            ."    FROM vw_composicao "
            ."    WHERE composicao_id = :composicao_id"                
            ."    UNION ALL "                
            ."    SELECT "
            ."    c.* "
            ."    FROM vw_composicao c "
            ."    JOIN composicao_recursiva cr ON "
            ."    c.composicao_pai_id = cr.composicao_id "
            .") "
            ."SELECT * "
            ."FROM composicao_recursiva "  
            ."ORDER BY composicao_ordem, composicao_id asc";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":composicao_id", $composicao_id);             
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }



    
}