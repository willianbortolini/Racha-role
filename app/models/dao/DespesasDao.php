<?php
namespace app\models\dao;
use app\core\Model;

class DespesasDao extends Model
{ 
    public function jaGravouEssaDespesa($despesas)
    {
        try {
            $sql = "SELECT *
                    FROM despesas
                    WHERE descricao = :descricao
                    AND valor = :valor
                    AND data = :data";

            $parametro = array(
                'descricao' => $despesas->descricao,
                'valor' => $despesas->valor,
                'data' => $despesas->data,
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