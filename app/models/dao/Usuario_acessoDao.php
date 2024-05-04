<?php
namespace app\models\dao;
use app\core\Model;
use Exception;

class Usuario_acessoDao extends Model
{ 
    public function acessosDoUsuario($usuarios_id){
        try {
            $sql = "SELECT acesso FROM usuario_acesso WHERE usuarios_id =:usuarios_id " ;
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuarios_id);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }catch (\PDOException $e){
            throw new Exception($e->getMessage());
        } 
    }  
    
    public function deleteUsuarioAcesso($usuarios_id, $acesso){
        try {
            $sql = "DELETE FROM usuario_acesso 
                    WHERE usuarios_id =:usuarios_id 
                    AND acesso = :acesso" ;
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":usuarios_id", $usuarios_id);
            $stmt->bindValue(":acesso", $acesso);
            $stmt->execute();
            //return $stmt->fetchAll(\PDO::FETCH_OBJ);
        }catch (\PDOException $e){
            throw new Exception($e->getMessage());
        } 
    } 
   
}