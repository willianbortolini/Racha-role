<?php
namespace app\models\dao;
use app\core\Model;
use Exception;

class Op_item_posicaoDao extends Model
{ 
    public function posicoesOrdenaras()
    {
        $conn = $this->db;
        try {
            $sql = "SELECT *
            FROM posicao_op
            WHERE posicao_op.ativo = 1
            ORDER BY posicao_op.ordem";

            $stmt = $conn->prepare($sql);        
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }   
   
}