<?php

namespace app\models\dao;

use app\core\Model;

class Participantes_despesasDao extends Model
{

    public function meusDebitosEmAberto($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "WITH saldos AS (
                        SELECT 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END AS usuario,
                            SUM(CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.valor - p1.valor_pago
                                ELSE -(p1.valor - p1.valor_pago) 
                            END) AS saldo
                        FROM 
                            participantes_despesas p1
                        WHERE 
                            (p1.valor - p1.valor_pago) > 0
                            AND (p1.devendo_para = :users_id OR p1.users_id = :users_id)
                            AND p1.devendo_para != p1.users_id
                        GROUP BY 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END
                    )
                    SELECT 
                        s.usuario AS devendo_para,
                        u.username AS devendo_para_nome,
                        s.saldo AS valor_devendo
                    FROM 
                        saldos s
                    INNER JOIN 
                        users u ON u.users_id = s.usuario
                    WHERE 
                        s.saldo > 0
                        AND s.usuario != :users_id";

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
            $sql = "WITH saldos AS (
                        SELECT 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END AS usuario,
                            SUM(CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.valor - p1.valor_pago
                                ELSE -(p1.valor - p1.valor_pago) 
                            END) AS saldo
                        FROM 
                            participantes_despesas p1
                        WHERE 
                            (p1.valor - p1.valor_pago) > 0
                            AND (p1.devendo_para = :users_id OR p1.users_id = :users_id)
                            AND p1.devendo_para != p1.users_id
                        GROUP BY 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END
                    )
                    SELECT 
                        s.usuario AS a_receber_de,
                        u.username AS a_receber_nome,
                        -s.saldo AS valor_receber
                    FROM 
                        saldos s
                    INNER JOIN 
                        users u ON u.users_id = s.usuario
                    WHERE 
                        s.saldo < 0
                        AND s.usuario != :users_id";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function meusValores($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "WITH saldos AS (
                        SELECT 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END AS usuario,
                            SUM(CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.valor - p1.valor_pago
                                ELSE -(p1.valor - p1.valor_pago) 
                            END) AS saldo
                        FROM 
                            participantes_despesas p1
                        WHERE 
                            (p1.valor - p1.valor_pago) > 0
                            AND (p1.devendo_para = :users_id OR p1.users_id = :users_id)
                            AND p1.devendo_para != p1.users_id
                        GROUP BY 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END
                    )
                    SELECT 
                        s.usuario AS a_receber_de,
                        u.username AS a_receber_nome,
                        -s.saldo AS valor_receber
                    FROM 
                        saldos s
                    INNER JOIN 
                        users u ON u.users_id = s.usuario
                    WHERE 
                        AND s.usuario != :users_id";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function meusValoresPorGrupo($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "WITH saldos AS (
                        SELECT 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END AS usuario,
                            SUM(CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.valor - p1.valor_pago
                                ELSE -(p1.valor - p1.valor_pago) 
                            END) AS saldo,
    						despesas.grupos_id
                        FROM 
                            participantes_despesas p1
    					INNER JOIN despesas ON
    					despesas.despesas_id = p1.despesas_id 
                        WHERE 
                            (p1.valor - p1.valor_pago) > 0
                            AND (p1.devendo_para = :users_id OR p1.users_id = :users_id)
                            AND p1.devendo_para != p1.users_id
                        GROUP BY 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END
    						, despesas.grupos_id
                    )
                    SELECT 
                        s.usuario AS users_id,
                        u.username AS username,
                        -s.saldo AS valor,
                        s.grupos_id, grupos.nome nome_grupo, grupos.foto
                    FROM 
                        saldos s
                    INNER JOIN 
                        users u ON u.users_id = s.usuario
                    LEFT JOIN grupos ON
                    grupos.grupos_id = s.grupos_id
                    WHERE
                         s.usuario != :users_id
                    ORDER BY s.grupos_id";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function resumoValoresAmigos($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "WITH saldos AS (
                        SELECT 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END AS usuario,
                            SUM(CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.valor - p1.valor_pago
                                ELSE -(p1.valor - p1.valor_pago) 
                            END) AS saldo
                        FROM 
                            participantes_despesas p1
                        WHERE 
                            (p1.valor - p1.valor_pago) > 0
                            AND (p1.devendo_para = :users_id OR p1.users_id = :users_id)
                            AND p1.devendo_para != p1.users_id
                        GROUP BY 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END
                    )
                    SELECT 
                        s.usuario AS users_id,
                        u.username AS username,
                        s.saldo AS valor,
                        u.foto_perfil,
                        u.users_uid,
                        u.pix,
                        u.avatar,
                        u.email
                    FROM 
                        saldos s
                    INNER JOIN 
                        users u ON u.users_id = s.usuario
                    WHERE  s.usuario != :users_id";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function saldoUsuario($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "WITH saldos AS (
                        SELECT 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END AS usuario,
                            SUM(CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.valor - p1.valor_pago
                                ELSE -(p1.valor - p1.valor_pago) 
                            END) AS saldo
                        FROM 
                            participantes_despesas p1
                        WHERE 
                            (p1.valor - p1.valor_pago) > 0
                            AND (p1.devendo_para = :users_id OR p1.users_id = :users_id)
                            AND p1.devendo_para != p1.users_id
                        GROUP BY 
                            CASE 
                                WHEN p1.devendo_para = :users_id THEN p1.users_id
                                ELSE p1.devendo_para 
                            END
                    )
                    SELECT 
                        sum(s.saldo ) as valor
                    FROM 
                        saldos s
                    WHERE  s.usuario != :users_id";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro, false)->valor;
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
    
    public function totalDividasEntreUsuarios($devedor, $credor)
    {
        $conn = $this->db;
        try {
            $sql = "WITH saldos AS (
                SELECT 
                    CASE 
                        WHEN p1.devendo_para = :devedor THEN p1.users_id
                        ELSE p1.devendo_para 
                    END AS usuario,
                    SUM(CASE 
                        WHEN p1.devendo_para = :devedor THEN p1.valor - p1.valor_pago
                        ELSE -(p1.valor - p1.valor_pago) 
                    END) AS saldo
                FROM 
                    participantes_despesas p1
                WHERE 
                    (p1.valor - p1.valor_pago) > 0
                    AND (p1.devendo_para = :devedor OR p1.users_id = :devedor)
                    AND (p1.devendo_para = :credor OR p1.users_id = :credor)
                    AND p1.devendo_para != p1.users_id
                GROUP BY 
                    CASE 
                        WHEN p1.devendo_para = :devedor THEN p1.users_id
                        ELSE p1.devendo_para 
                    END
            )
            SELECT 
                sum(s.saldo ) as valor
            FROM 
                saldos s
            WHERE  s.usuario != :devedor";
            $parametro = array(
                'devedor' => $devedor,
                'credor' => $credor
            );

            return self::consultar($this->db, $sql, $parametro,FALSE)->valor;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function negociacoesEntreDoisUsuarios($eu, $outro, $inicio = null, $fim = null)
    {
        $conn = $this->db;

        // Definir a data de fim como hoje se não for fornecida
        if ($fim === null) {
            $fim = date('Y-m-d', strtotime('+1 day'));
        }

        // Definir a data de início como um mês atrás se não for fornecida
        if ($inicio === null) {
            $inicio = date('Y-m-d', strtotime('-3 month'));
        }

        try {
            $sql = "
            SELECT 
                'despesa' AS tipo,
                despesas.descricao AS descricao,
                despesas.despesas_id,
                CASE 
                    WHEN participantes_despesas.users_id = :eu THEN -participantes_despesas.valor
                    WHEN participantes_despesas.users_id = :outro THEN participantes_despesas.valor
                END AS valor,
                DATE_ADD(despesas.created_at, INTERVAL 1 SECOND) AS data,
                grupos.nome grupos_nome
            FROM 
                participantes_despesas
            INNER JOIN despesas ON
                despesas.despesas_id = participantes_despesas.despesas_id
            LEFT JOIN grupos ON
                grupos.grupos_id = despesas.grupos_id
            WHERE 
                ((participantes_despesas.users_id = :eu AND participantes_despesas.devendo_para = :outro) OR
                 (participantes_despesas.users_id = :outro AND participantes_despesas.devendo_para = :eu))
                AND despesas.created_at BETWEEN :inicio AND :fim

            UNION ALL

            SELECT 
                'pagamento' AS tipo,
                'pagamento' AS descricao,
                0 despesas_id,
                CASE 
                    WHEN pagamentos.pagador = :eu THEN -pagamentos.valor
                    WHEN pagamentos.pagador = :outro THEN pagamentos.valor
                END AS valor,
                pagamentos.created_at data,
                '' grupos_nome
            FROM 
                pagamentos
            WHERE
                ((pagamentos.pagador = :eu AND pagamentos.recebedor = :outro) OR
                 (pagamentos.pagador = :outro AND pagamentos.recebedor = :eu))
                AND pagamentos.created_at BETWEEN :inicio AND :fim

            ORDER BY 
                data DESC;
        ";

            $parametro = array(
                'eu' => $eu,
                'outro' => $outro,
                'inicio' => $inicio,
                'fim' => $fim
            );

            return self::consultar($conn, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
