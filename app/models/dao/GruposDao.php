<?php
namespace app\models\dao;
use app\core\Model;

class GruposDao extends Dao
{ 
    protected $table = 'grupos';
    
    protected static function createDao()
    {
        return new GruposDao();
    }
    /*
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM grupos
                    WHERE grupos_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( grupos_id LIKE '" . $valor_pesquisa . "' 
                      OR nome LIKE '" . $valor_pesquisa . "' 
                ) ";
            }

            $sql .= " ORDER BY " . $parametros['colunaOrder'] . " " . $parametros['direcaoOrdenacao'] . " LIMIT " . $parametros['inicio'] . " , " . $parametros['quantidade'] . " ";

            return self::select($this->db, $sql, true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function gruposDoUsuario($user_id)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM grupos
                    INNER JOIN usuarios_grupos ON
                    usuarios_grupos.grupos_id = grupos.grupos_id
                    WHERE usuarios_grupos.users_id =  :users_id";
            $parametros = ['users_id' => $user_id];
            return self::consultar($this->db, $sql, $parametros, true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  

    public function quantidadeDeLinhas($valor_pesquisa)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT count(grupos_id) total
                    FROM grupos
                    WHERE grupos_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( grupos_id LIKE '" . $valor_pesquisa . "' 
                      OR nome LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  
   */
}