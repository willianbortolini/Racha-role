<?php
namespace app\models\dao;
use app\core\Model;

class GruposDao extends Model
{ 
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
                                AND despesas.ativo = 1
                            GROUP BY 
                                despesas.grupos_id,
                                CASE 
                                    WHEN p1.devendo_para = :users_id THEN p1.users_id
                                    ELSE p1.devendo_para 
                                END
                        )
                        SELECT 
                            g.grupos_id,
                            g.nome AS nome_grupo,
                            g.foto
                        FROM 
                            grupos g
                        LEFT JOIN saldos s ON
                            g.grupos_id = s.grupos_id
                        INNER JOIN usuarios_grupos ON
                            usuarios_grupos.users_id = :users_id AND
                            usuarios_grupos.grupos_id = g.grupos_id
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