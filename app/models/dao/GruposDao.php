<?php
namespace app\models\dao;
use app\core\Model;

class GruposDao extends Model
{ 
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM grupos
                    WHERE grupos_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( grupos_id LIKE '" . $valor_pesquisa . "' 
                      OR nome LIKE '" . $valor_pesquisa . "' 
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
            $sql = "SELECT count(grupos_id) total
                    FROM grupos
                    WHERE grupos_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( grupos_id LIKE '" . $valor_pesquisa . "' 
                      OR nome LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  

    public function gruposDoUsuario($usuario_id)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT grupos.grupos_id, grupos.nome, grupos.foto
                    FROM usuarios_grupos
                    INNER JOIN grupos ON
                    grupos.grupos_id = usuarios_grupos.grupos_id
                    WHERE usuarios_grupos.users_id = :usuario_id";

            $parametro = array(
                'usuario_id' => $usuario_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function gruposQuitados($users_id)
    {
        $conn = $this->db;
        try {
            $sql = "WITH saldos AS (
                            SELECT 
                                despesas.grupos_id,
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
                            INNER JOIN despesas ON
                                despesas.despesas_id = p1.despesas_id 
                            WHERE 
                                (p1.valor - p1.valor_pago) > 0
                                AND (p1.devendo_para = :users_id OR p1.users_id = :users_id)
                                AND p1.devendo_para != p1.users_id
                            GROUP BY 
                                despesas.grupos_id,
                                CASE 
                                    WHEN p1.devendo_para = :users_id THEN p1.users_id
                                    ELSE p1.devendo_para 
                                END
                        )
                        SELECT 
                            g.grupos_id,
                            g.nome AS nome_grupo
                        FROM 
                            grupos g
                        LEFT JOIN saldos s ON
                            g.grupos_id = s.grupos_id
                        GROUP BY 
                            g.grupos_id, g.nome
                        HAVING 
                            SUM(s.saldo) IS NULL OR SUM(s.saldo) = 0
                        ORDER BY 
                            g.nome;
                        ";

            $parametro = array(
                'users_id' => $users_id
            );

            return self::consultar($this->db, $sql, $parametro);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
   
}