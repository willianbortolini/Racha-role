<?php
namespace app\models\dao;
use app\core\Model;

class InventarioDao extends Model
{   
    public function inventariosCompartilhados($usuarios_id){
        $sql = "SELECT inventario.* "
                . "FROM inventario_compartilhado "
                . "INNER JOIN inventario ON "
                . "inventario.inventario_id = inventario_compartilhado.inventario_id "
                . "WHERE inventario_compartilhado.usuarios_id = :usuarios_id" ;     
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":usuarios_id", $usuarios_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
   
}