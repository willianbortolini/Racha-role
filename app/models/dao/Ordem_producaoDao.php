<?php
namespace app\models\dao;

use app\core\Model;
use Exception;

class Ordem_producaoDao extends Model
{
    public function conteudoDaPosicaoDosItensNaOp($ordem_producao_id)
    {

        $conn = $this->db;
        try {
            $sql = "SELECT op_item_posicao.* 
            FROM  ordem_producao_item 
            INNER JOIN op_item_posicao ON
            op_item_posicao.ordem_producao_item_id = ordem_producao_item.ordem_producao_item_id
            WHERE ordem_producao_item.ordem_producao_id = :ordem_producao_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":ordem_producao_id", $ordem_producao_id);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function produtosReservadosParaOP($ordem_producao_id)
    {        
        $sql = "SELECT reserva.*, produtos.produtos_nome 
            FROM  reserva 
            INNER JOIN produtos ON
            produtos.produtos_id = reserva.produtos_id
            WHERE reserva.tipo = :tipo
            AND reserva.documento = :documento";

        $parametros = array(
           'documento' => $ordem_producao_id,
           'tipo' => RESERVA_OP 
        );
        return $this->consultar($this->db, $sql, $parametros, true);
    }



}