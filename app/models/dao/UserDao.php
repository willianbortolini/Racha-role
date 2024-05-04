<?php
namespace app\models\dao;

use Exception;
use PDO;
use app\core\Model;

class UserDao extends Model
{
    public function listaUsuarios($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM usuarios
                    WHERE he_cliente = 1";

            if ($parametros['valor_pesquisa'] != '') {
                $sql .= " AND ( usuario LIKE '" . $parametros['valor_pesquisa'] . "' ";
                $sql .= " OR celular LIKE '" . $parametros['valor_pesquisa'] . "' ";
                $sql .= " OR fone LIKE '" . $parametros['valor_pesquisa'] . "' ";
                $sql .= " OR estado LIKE '" . $parametros['valor_pesquisa'] . "' ";
                $sql .= " OR cidade LIKE '" . $parametros['valor_pesquisa'] . "' ";
                $sql .= " OR bairro LIKE '" . $parametros['valor_pesquisa'] . "' ";
                $sql .= " OR email LIKE '" . $parametros['valor_pesquisa'] . "' ) ";
            }

            $sql .= " ORDER BY " . $parametros['colunaOrder'] . " " . $parametros['direcaoOrdenacao'] . " LIMIT " . $parametros['inicio'] . " , " . $parametros['quantidade'] . " ";

            //i($sql);
            return self::select($this->db, $sql, true);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function quantidadeClientes($valor_pesquisa)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT count(usuarios_id) total
                    FROM usuarios
                    WHERE he_cliente = 1 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( usuario LIKE '" . $valor_pesquisa . "' ";
                $sql .= " OR celular LIKE '" . $valor_pesquisa . "' ";
                $sql .= " OR fone LIKE '" . $valor_pesquisa . "' ";
                $sql .= " OR estado LIKE '" . $valor_pesquisa . "' ";
                $sql .= " OR cidade LIKE '" . $valor_pesquisa . "' ";
                $sql .= " OR bairro LIKE '" . $valor_pesquisa . "' ";
                $sql .= " OR email LIKE '" . $valor_pesquisa . "' ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}