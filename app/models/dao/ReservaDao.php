<?php
namespace app\models\dao;

use app\core\Model;
use Exception;

class ReservaDao extends Model
{
    public function excluiOP($id_OP)
    {

        $conn = $this->db;
        try {
            $sql = "DELETE 
            FROM  reserva
            WHERE reserva.tipo = :tipo
            AND reserva.documento = :documento";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":tipo", RESERVA_OP);
            $stmt->bindValue(":documento", $id_OP);
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function liberarReservasDeDocumento($tipo_documento, $documento)
    {

        $conn = $this->db;

        try {
            $sql = "UPDATE reserva SET reservado = 0
            WHERE reserva.tipo = :tipo
            AND reserva.documento = :documento";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":tipo", $tipo_documento);
            $stmt->bindValue(":documento", $documento);
            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function pesquisa($pesquisa)
    {
        $sql = "";
        
        if ($pesquisa->reservado_sim != $pesquisa->reservado_nao) {
            if ($pesquisa->reservado_sim == 1) {
                $sql = "SELECT vw_reserva.produtos_nome, SUM(quantidade)  quantidade
                FROM vw_reserva
                INNER JOIN ordem_producao on
                ordem_producao.ordem_producao_id  = vw_reserva.documento
                WHERE reservado = 1 ";
            } else {
                $sql = "SELECT vw_reserva.produtos_nome, SUM(quantidade)  quantidade
                FROM vw_reserva
                INNER JOIN ordem_producao on
                ordem_producao.ordem_producao_id  = vw_reserva.documento
                WHERE reservado = 0 ";
            }
        } else {
            $sql = "SELECT vw_reserva.produtos_nome, SUM(quantidade)  quantidade
            FROM vw_reserva
            INNER JOIN ordem_producao on
            ordem_producao.ordem_producao_id  = vw_reserva.documento
            WHERE reservado < 2 ";
        }
        if (!empty($pesquisa->pedidos)) {
            $sql .= " AND ordem_producao.pedidos_id IN (" . implode(",", $pesquisa->pedidos) . ")";
        }

        $sql .= " GROUP BY vw_reserva.produtos_nome  ";
        
        return self::select($this->db, $sql, true);

        /*$sql = "SELECT * 
        FROM vw_reserva
        ";
        unset($pesquisa->tipos);
        $parametros = objToArray($pesquisa);
        return self::consultar($this->db, $sql, $parametros, true);*/
    }

}