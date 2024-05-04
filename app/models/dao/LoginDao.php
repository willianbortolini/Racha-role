<?php
namespace app\models\dao;

use Exception;
use app\core\Model;

class LoginDao extends Model
{

    public function getLogin($tabela, $campo, $valor)
    {
        try {
            $sql = "SELECT * FROM " . $tabela . " WHERE " . $campo . " =:campo ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":campo", $valor);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}