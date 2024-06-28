<?php
namespace app\models\dao;

use app\core\Model;

class Participantes_despesasDao extends Model
{
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM participantes_despesas
                    WHERE participantes_despesas_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( participantes_despesas_id LIKE '" . $valor_pesquisa . "' 
                      OR despesas_id LIKE '" . $valor_pesquisa . "' 
                      OR users_id LIKE '" . $valor_pesquisa . "' 
                      OR devendo_para LIKE '" . $valor_pesquisa . "' 
                      OR valor LIKE '" . $valor_pesquisa . "' 
                      OR valor_pago LIKE '" . $valor_pesquisa . "' 
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
            $sql = "SELECT count(participantes_despesas_id) total
                    FROM participantes_despesas
                    WHERE participantes_despesas_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( participantes_despesas_id LIKE '" . $valor_pesquisa . "' 
                      OR despesas_id LIKE '" . $valor_pesquisa . "' 
                      OR users_id LIKE '" . $valor_pesquisa . "' 
                      OR devendo_para LIKE '" . $valor_pesquisa . "' 
                      OR valor LIKE '" . $valor_pesquisa . "' 
                      OR valor_pago LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function meusDebitosEmAberto($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT participantes_despesas.devendo_para, SUM(participantes_despesas.valor-participantes_despesas.valor_pago) valor,
             users.username devendo_para_nome 
             FROM participantes_despesas 
             inner join users ON 
             users.users_id = participantes_despesas.devendo_para 
             WHERE participantes_despesas.users_id = :users_id 
             AND (valor-valor_pago) > 0 
             GROUP BY devendo_para;";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function meusValoresAReceber($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT participantes_despesas.users_id, SUM(participantes_despesas.valor-participantes_despesas.valor_pago) valor,
             users.username a_receber_nome 
             FROM participantes_despesas 
             inner join users ON 
             users.users_id = participantes_despesas.users_id 
             WHERE participantes_despesas.devendo_para = :users_id
             AND (valor-valor_pago) > 0 
            GROUP BY participantes_despesas.users_id";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function dividasEntreUsuarios($devedor, $credor)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT participantes_despesas_id, valor, valor_pago
                    FROM participantes_despesas 
                    WHERE participantes_despesas.users_id = :devedor
                    AND participantes_despesas.devendo_para = :credor
                    AND (valor-valor_pago) > 0 ";

            $parametro = array(
                'devedor' => $devedor,
                'credor' => $credor
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    


}