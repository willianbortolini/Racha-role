<?php
namespace app\models\dao;
use app\core\Model;

class Usuarios_gruposDao extends Model
{ 

    public function membrosDoGrupo($grupos_id)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT *
                    FROM usuarios_grupos
                    INNER JOIN users ON
                    users.users_id = usuarios_grupos.users_id
                    WHERE usuarios_grupos.grupos_id = :grupos_id ";

            $parametro = array(
                'grupos_id' => $grupos_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function estaNoGrupo($users_id, $grupos_id)
    {
        try {
            $sql = "SELECT * 
                    FROM usuarios_grupos 
                    WHERE users_id = :users_id
                    and grupos_id = :grupos_id";

            $parametro = array(
                'users_id' => $users_id,
                'grupos_id' => $grupos_id,
            );

            $resultado = self::consultar($this->db, $sql, $parametro);

            if ($resultado && count($resultado) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
   
}