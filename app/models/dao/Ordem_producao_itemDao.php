<?php
namespace app\models\dao;
use app\core\Model;
use Exception;

class Ordem_producao_itemDao extends Model
{  
    public function posicoesOpParaItemPedido($pedido_item_id)
    {
        $id_usuario = $_SESSION['id'];

        $conn = $this->db;
        try {
            $sql = "SELECT posicao_op.posicao_op_id, composicao.composicao_op_formula, pedido_item_composicao.pedido_item_composicao_valor,
            pedido_item_composicao.texto
            FROM posicao_op
            LEFT JOIN composicao ON
            composicao.composicao_op_posicao = posicao_op.posicao_op_id
            INNER JOIN pedido_item_composicao ON
            pedido_item_composicao.composicao_id = composicao.composicao_id
            WHERE pedido_item_composicao.pedido_item_id = :pedido_item_id
            AND posicao_op.ativo = 1
            ORDER BY posicao_op.ordem";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":pedido_item_id", $pedido_item_id);          
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    } 

    public function insumosUtilizadosNaOpPorItemDoPedido($pedido_item_id)
    {
        $id_usuario = $_SESSION['id'];

        $conn = $this->db;
        try {
            $sql = "SELECT composicao.insumo, composicao.quantidade_insumo, vw_produtos_estoque.estoque_quantidade,
            vw_produtos_estoque.produtos_nome, vw_produtos_estoque.quantidade_reservada 
            FROM pedido_item_composicao
            INNER JOIN composicao ON
            composicao.composicao_id = pedido_item_composicao.composicao_id
            INNER JOIN vw_produtos_estoque ON
            vw_produtos_estoque.produtos_id = composicao.insumo
            WHERE pedido_item_composicao.pedido_item_id = :pedido_item_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":pedido_item_id", $pedido_item_id);          
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    } 
}