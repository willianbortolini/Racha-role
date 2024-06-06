<?php
namespace app\models\dao;
use app\core\Model;

class DespesasDao extends Model
{ 
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM despesas
                    WHERE despesas_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( despesas_id LIKE '" . $valor_pesquisa . "' 
                      OR descricao LIKE '" . $valor_pesquisa . "' 
                      OR valor LIKE '" . $valor_pesquisa . "' 
                      OR data LIKE '" . $valor_pesquisa . "' 
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
            $sql = "SELECT count(despesas_id) total
                    FROM despesas
                    WHERE despesas_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( despesas_id LIKE '" . $valor_pesquisa . "' 
                      OR descricao LIKE '" . $valor_pesquisa . "' 
                      OR valor LIKE '" . $valor_pesquisa . "' 
                      OR data LIKE '" . $valor_pesquisa . "' 
                      OR users_id LIKE '" . $valor_pesquisa . "' 
                      OR grupos_id LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  
   
}