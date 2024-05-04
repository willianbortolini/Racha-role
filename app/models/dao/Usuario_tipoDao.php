<?php
namespace app\models\dao;
use app\core\Model;

class Usuario_tipoDao extends Model
{ 
    public function usuariosComTipo($usuario_tipo)
    {
        $empresa = $_SESSION['id'];
        $conn = $this->db;
        try {
            $sql = "SELECT * "
                . "FROM usuario_tipo "
                . "INNER JOIN usuarios ON "
                . "usuarios.usuarios_id = usuario_tipo.usuarios_id "
                . "WHERE usuario_tipo = :usuario_tipo "
                . "AND empresa = :empresa ";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuario_tipo", $usuario_tipo);   
            $stmt->bindValue(":empresa", $empresa);        
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }   

    public function tiposUsuario($usuarios_id){
        $conn = $this->db;
        try {
            $sql = "SELECT usuario_tipo "
                . "FROM usuario_tipo "                
                . "WHERE usuarios_id = :usuarios_id ";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuarios_id);         
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
            
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }
   
}