<?php
namespace app\models\dao;
use app\core\Model;

class TicketsDao extends Model
{ 
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM tickets
                    WHERE tickets_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( tickets_id LIKE '" . $valor_pesquisa . "' 
                      OR user_id LIKE '" . $valor_pesquisa . "' 
                      OR subject LIKE '" . $valor_pesquisa . "' 
                      OR CPF LIKE '" . $valor_pesquisa . "' 
                      OR status LIKE '" . $valor_pesquisa . "' 
                      OR priority LIKE '" . $valor_pesquisa . "' 
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
            $sql = "SELECT count(tickets_id) total
                    FROM tickets
                    WHERE tickets_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( tickets_id LIKE '" . $valor_pesquisa . "' 
                      OR user_id LIKE '" . $valor_pesquisa . "' 
                      OR subject LIKE '" . $valor_pesquisa . "' 
                      OR CPF LIKE '" . $valor_pesquisa . "' 
                      OR status LIKE '" . $valor_pesquisa . "' 
                      OR priority LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  
   
}