<?php
namespace app\models\dao;
use app\core\Model;

class PagamentosDao extends Model
{ 
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM pagamentos
                    WHERE pagamentos_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( pagamentos_id LIKE '" . $valor_pesquisa . "' 
                      OR pagador LIKE '" . $valor_pesquisa . "' 
                      OR recebedor LIKE '" . $valor_pesquisa . "' 
                      OR valor LIKE '" . $valor_pesquisa . "' 
                      OR data LIKE '" . $valor_pesquisa . "' 
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
            $sql = "SELECT count(pagamentos_id) total
                    FROM pagamentos
                    WHERE pagamentos_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( pagamentos_id LIKE '" . $valor_pesquisa . "' 
                      OR pagador LIKE '" . $valor_pesquisa . "' 
                      OR recebedor LIKE '" . $valor_pesquisa . "' 
                      OR valor LIKE '" . $valor_pesquisa . "' 
                      OR data LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  
   
}