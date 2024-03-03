<?php
namespace app\models\dao;
use app\core\Model;

class Inventario_compartilhadoDao extends Model
{   

    public function inventarioUsuario($inventarios_id, $usuarios_id){
        $sql = "SELECT * "
                . "FROM inventario_compartilhado " 
                . "WHERE inventario_id = :inventario_id "
                . "AND usuarios_id = :usuarios_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":inventario_id", $inventarios_id);  
        $stmt->bindValue(":usuarios_id", $usuarios_id);       
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);        
    }
   
}