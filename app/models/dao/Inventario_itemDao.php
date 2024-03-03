<?php
namespace app\models\dao;
use app\core\Model;

class Inventario_itemDao extends Model
{   
    public function identiradesContadas($inventarios_id){
        $sql = "SELECT ean13 code, SUM(quantidade) quantity "
                . "FROM inventario_item " 
                . "WHERE inventario_id = :inventario_id "
                . "GROUP BY ean13 "
                . "ORDER BY SUM(quantidade) DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":inventario_id", $inventarios_id);      
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);        
    }

    public function itensInventarioUsuario($inventarios_id, $usuarios_id){
        $sql = "SELECT * "
                . "FROM inventario_item " 
                . "WHERE inventario_id = :inventario_id "
                . "AND usuarios_id = :usuarios_id "
                . "ORDER BY data_captura DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":inventario_id", $inventarios_id);      
        $stmt->bindValue(":usuarios_id", $usuarios_id);      
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);        
    }
   
}