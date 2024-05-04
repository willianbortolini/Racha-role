<?php
namespace app\models\dao;
use app\core\Model;

class Movimentacao_estoqueDao extends Model
{   
    public function pesquisa($pesquisa)
    {
        
        $sql = "SELECT * 
        FROM vw_movimentacao_estoque
        WHERE produtos_id = :produtos_id
        AND data BETWEEN :dataInicio AND :dataFim
        AND tipo_movimentacao IN (".$pesquisa->tipos.")";
        unset($pesquisa->tipos);
        $parametros = objToArray($pesquisa);
        return self::consultar($this->db, $sql, $parametros, true);
    }
}