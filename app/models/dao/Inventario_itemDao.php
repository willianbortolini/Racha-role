<?php
namespace app\models\dao;
use app\core\Model;

class Inventario_itemDao extends Model
{   
    public function identiradesContadas($inventarios_id){
        $sql = "SELECT ean13 code, COUNT(quantidade) quantity "
                . "FROM inventario_item " 
                . "WHERE inventario_id = :inventario_id "
                . "GROUP BY ean13 "
                . "ORDER BY COUNT(quantidade) DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":inventario_id", $inventarios_id);      
        $stmt->execute();
        return $stmt->fetchaLL(\PDO::FETCH_OBJ);        
    }
   
}