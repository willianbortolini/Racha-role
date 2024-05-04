<?php
namespace app\models\dao;
use app\core\Model;

class PedidoDao extends Model
{   
    public function listaOrcamentoRepresentante()
    {
        $usuarios_id = $_SESSION['id'];

        $conn = $this->db;
        try {
            $sql = "SELECT * "
                . "FROM vw_pedidos "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND statusPedido_id = :statusPedido_id "
                . "ORDER BY pedidos_id desc ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuarios_id); 
            $stmt->bindValue(":statusPedido_id", ORCAMENTO);             
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }
    

    public function listaPedidoRepresentante()
    {
        $usuarios_id = $_SESSION['id'];

        $conn = $this->db;
        try {
            $sql = "SELECT * "
                . "FROM vw_pedidos "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND statusPedido_id >= :statusPedido_id "
                . "ORDER BY pedidos_id desc";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuarios_id); 
            $stmt->bindValue(":statusPedido_id", PEDIDO);             
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }
   
}