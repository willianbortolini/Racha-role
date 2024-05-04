<?php

namespace app\models\dao;

use app\core\Model;

class StoreDao extends Model
{
    public function getStoresUser()
    {
        $id_usuario = $_SESSION['id'];

        $conn = $this->db;
        try {
            $sql = "SELECT store_users.stores_id, stores.stores_name "
                . "FROM store_users "
                . "INNER JOIN stores ON "
                . "stores.stores_id = store_users.stores_id "
                . "WHERE id_usuario = :id_usuario ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario);          
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}