<?php
namespace app\models\dao;
use app\core\Model;

class AmigosDao extends Model
{ 
    public function meusAmigos($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT u.users_id, u.users_uid, u.username, u.email, u.telefone, u.foto_perfil
                    FROM amigos a
                    INNER JOIN users u ON a.amigo_id = u.users_id
                    WHERE a.usuario_id = :users_id

                    UNION

                    SELECT u.users_id, u.users_uid, u.username, u.email, u.telefone, u.foto_perfil
                    FROM amigos a
                    INNER JOIN users u ON a.usuario_id = u.users_id
                    WHERE a.amigo_id = :users_id

                    UNION

                    SELECT u.users_id, u.users_uid, u.username, u.email, u.telefone, u.foto_perfil
                    FROM usuarios_grupos ug
                    INNER JOIN usuarios_grupos ug2 ON ug.grupos_id = ug2.grupos_id
                    INNER JOIN users u ON u.users_id = ug2.users_id
                    WHERE ug.users_id = :users_id
                    GROUP BY u.users_id, u.username, u.email, u.telefone, u.foto_perfil;
                    ";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function jaEamigo($users_id, $amigo)
    {
        try {
            $sql = "SELECT * 
                    FROM amigos
                    WHERE (usuario_id = :users_id and amigo_id = :amigo) OR
                    (usuario_id = :amigo and amigo_id = :users_id)";

            $parametro = array(
                'users_id' => $users_id,
                'amigo' => $amigo,
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