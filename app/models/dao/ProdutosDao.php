<?php
namespace app\models\dao;
use app\core\Model;

class ProdutosDao extends Model
{       
    public function produtosOrdenados()
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * "
                . "FROM produtos "
                . "WHERE he_produto_final = 1 "
                . "ORDER BY ordem, produtos_id asc ";

            $stmt = $conn->prepare($sql);            
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function EstoqueInsumo()
    {
        $sql = "SELECT * 
                FROM vw_produtos_estoque
                WHERE he_produto_insumo = 1 ";
        return $this->select($this->db, $sql);
    }
   
}