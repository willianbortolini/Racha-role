<?php
namespace app\models\dao;
use app\core\Model;

class Usuarios_gruposDao extends Model
{ 
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM usuarios_grupos
                    WHERE usuarios_grupos_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( usuarios_grupos_id LIKE '" . $valor_pesquisa . "' 
                      OR users_id LIKE '" . $valor_pesquisa . "' 
                      OR grupos_id LIKE '" . $valor_pesquisa . "' 
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
            $sql = "SELECT count(usuarios_grupos_id) total
                    FROM usuarios_grupos
                    WHERE usuarios_grupos_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( usuarios_grupos_id LIKE '" . $valor_pesquisa . "' 
                      OR users_id LIKE '" . $valor_pesquisa . "' 
                      OR grupos_id LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  

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