<?php
namespace app\models\dao;

use app\core\Model;

class Fi_transacoesDao extends Model
{

    public function gastoSemanal($usuario)
    {
        $conn = $this->db;
        try {
            $amanha = (new \DateTime())->modify('+1 day')->format('Y-m-d');
            $segundaFeiraPassada = (new \DateTime())->modify('last monday')->format('Y-m-d');

            $sql = "SELECT SUM(vw_fi_transacoes.VALOR) total "
                . "FROM vw_fi_transacoes "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND TIPO = 1 "
                . "AND data BETWEEN :segundaFeiraPassada AND :amanha "
                . "AND custo_fixo = 0";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuario);
            $stmt->bindValue(":amanha", $amanha);
            $stmt->bindValue(":segundaFeiraPassada", $segundaFeiraPassada);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ)->total;

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function gastoPorCategoriaSemanal($usuario)
    {
        $conn = $this->db;
        try {
            $amanha = (new \DateTime())->modify('+1 day')->format('Y-m-d');
            $segundaFeiraPassada = (new \DateTime())->modify('last monday')->format('Y-m-d');

            $sql = "select vw_fi_transacoes.fi_categorias_nome, SUM(vw_fi_transacoes.valor) valor, vw_fi_transacoes.fi_categorias_id "
                . "FROM vw_fi_transacoes "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND TIPO = 1 "
                . "AND data BETWEEN :segundaFeiraPassada AND :amanha "
                . "AND custo_fixo = 0 "
                . "GROUP by vw_fi_transacoes.fi_categorias_id ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuario);
            $stmt->bindValue(":amanha", $amanha);
            $stmt->bindValue(":segundaFeiraPassada", $segundaFeiraPassada);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function gastoMensal($usuario)
    {
        $conn = $this->db;
        try {
            $amanha = (new \DateTime())->modify('+1 day')->format('Y-m-d');
            $primeiroDiaDoMes = (new \DateTime('first day of this month'))->format('Y-m-d');

            $sql = "SELECT SUM(vw_fi_transacoes.VALOR) total "
                . "FROM vw_fi_transacoes "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND TIPO = 1 "
                . "AND data BETWEEN :primeiroDiaDoMes AND :amanha ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuario);
            $stmt->bindValue(":amanha", $amanha);
            $stmt->bindValue(":primeiroDiaDoMes", $primeiroDiaDoMes);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ)->total;

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
    public function gastoPorCategoriaMes($usuario)
    {
        $conn = $this->db;
        try {
            $amanha = (new \DateTime())->modify('+1 day')->format('Y-m-d');
            $primeiroDiaDoMes = (new \DateTime('first day of this month'))->format('Y-m-d');

            $sql = "select vw_fi_transacoes.fi_categorias_nome, SUM(vw_fi_transacoes.valor) valor, vw_fi_transacoes.fi_categorias_id  "
                . "FROM vw_fi_transacoes "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND TIPO = 1 "
                . "AND data BETWEEN :primeiroDiaDoMes AND :amanha "
                . "GROUP by vw_fi_transacoes.fi_categorias_id ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuario);
            $stmt->bindValue(":amanha", $amanha);
            $stmt->bindValue(":primeiroDiaDoMes", $primeiroDiaDoMes);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function CategoriaSemana($usuario,$id_categoria)
    {
        $conn = $this->db;
        try {
            $amanha = (new \DateTime())->modify('+1 day')->format('Y-m-d');
            $segundaFeiraPassada = (new \DateTime())->modify('last monday')->format('Y-m-d');

            $sql = "select vw_fi_transacoes.* "
                . "FROM vw_fi_transacoes "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND TIPO = 1 "
                . "AND data BETWEEN :segundaFeiraPassada AND :amanha "
                . "AND custo_fixo = 0 "
                . "AND fi_categorias_id = :id_categoria ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuario);
            $stmt->bindValue(":amanha", $amanha);
            $stmt->bindValue(":segundaFeiraPassada", $segundaFeiraPassada);
            $stmt->bindValue(":id_categoria", $id_categoria);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    
    public function CategoriaMes($usuario,$id_categoria)
    {
        $conn = $this->db;
        try {
            $amanha = (new \DateTime())->modify('+1 day')->format('Y-m-d');
            $primeiroDiaDoMes = (new \DateTime('first day of this month'))->format('Y-m-d');

            $sql = "select vw_fi_transacoes.*  "
                . "FROM vw_fi_transacoes "
                . "WHERE usuarios_id = :usuarios_id "
                . "AND TIPO = 1 "
                . "AND data BETWEEN :primeiroDiaDoMes AND :amanha "
                . "AND fi_categorias_id = :id_categoria ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuario);
            $stmt->bindValue(":amanha", $amanha);
            $stmt->bindValue(":primeiroDiaDoMes", $primeiroDiaDoMes);
            $stmt->bindValue(":id_categoria", $id_categoria);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}