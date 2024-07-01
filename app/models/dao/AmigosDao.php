<?php
namespace app\models\dao;
use app\core\Model;

class AmigosDao extends Model
{ 
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM amigos
                    WHERE amigos_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( amigos_id LIKE '" . $valor_pesquisa . "' 
                      OR usuario_id LIKE '" . $valor_pesquisa . "' 
                      OR amigo_id LIKE '" . $valor_pesquisa . "' 
                      OR status LIKE '" . $valor_pesquisa . "' 
                ) ";
            }

            $sql .= " ORDER BY " . $parametros['colunaOrder'] . " " . $parametros['direcaoOrdenacao'] . " LIMIT " . $parametros['inicio'] . " , " . $parametros['quantidade'] . " ";

            return self::select($this->db, $sql, true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function quantidadeDeLinhas($valor_pesquisa)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT count(amigos_id) total
                    FROM amigos
                    WHERE amigos_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( amigos_id LIKE '" . $valor_pesquisa . "' 
                      OR usuario_id LIKE '" . $valor_pesquisa . "' 
                      OR amigo_id LIKE '" . $valor_pesquisa . "' 
                      OR status LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  

    public function meusAmigos($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT u.users_id, u.username, u.email, u.telefone, u.foto_perfil
                    FROM amigos a
                    INNER JOIN users u ON a.amigo_id = u.users_id
                    WHERE a.usuario_id = :users_id

                    UNION

                    SELECT u.users_id, u.username, u.email, u.telefone, u.foto_perfil
                    FROM amigos a
                    INNER JOIN users u ON a.usuario_id = u.users_id
                    WHERE a.amigo_id = :users_id

                    UNION

                    SELECT u.users_id, u.username, u.email, u.telefone, u.foto_perfil
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
   
}