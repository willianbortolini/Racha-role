<?php
namespace app\models\dao;
use app\core\Model;

class ConvitesDao extends Model
{ 
    public function lista($parametros)
    {
        $conn = $this->db;
        try {
            $sql = "SELECT * 
                    FROM convites
                    WHERE convites_id > 0 ";

            $valor_pesquisa = $parametros['valor_pesquisa'];

            if ($valor_pesquisa != '') {
                $sql .= " AND ( convites_id LIKE '" . $valor_pesquisa . "' 
                      OR usuario_id LIKE '" . $valor_pesquisa . "' 
                      OR convidado_id LIKE '" . $valor_pesquisa . "' 
                      OR email LIKE '" . $valor_pesquisa . "' 
                      OR telefone LIKE '" . $valor_pesquisa . "' 
                      OR status LIKE '" . $valor_pesquisa . "' 
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
            $sql = "SELECT count(convites_id) total
                    FROM convites
                    WHERE convites_id > 0 ";

            if ($valor_pesquisa != '') {
                $sql .= " AND ( convites_id LIKE '" . $valor_pesquisa . "' 
                      OR usuario_id LIKE '" . $valor_pesquisa . "' 
                      OR convidado_id LIKE '" . $valor_pesquisa . "' 
                      OR email LIKE '" . $valor_pesquisa . "' 
                      OR telefone LIKE '" . $valor_pesquisa . "' 
                      OR status LIKE '" . $valor_pesquisa . "' 
                ) ";
            }
            return self::select($this->db, $sql, false);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  
   
}