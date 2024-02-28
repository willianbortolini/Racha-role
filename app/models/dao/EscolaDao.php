<?php

namespace app\models\dao;
use app\core\Model;

class EscolaDao extends Model{
    
    public function meusCursos($id_usuario) {
       $sql =  "SELECT * FROM cliente_curso INNER JOIN curso ON curso.curso_id = cliente_curso.curso_id WHERE cliente_curso.id_usuario = $id_usuario";
       return $this->select($this->db, $sql,true);
    }
    
    public function aulas_assistidas() {
       $id_usuario = $_SESSION[SESSION_LOGIN]->id_usuario;
       $sql =  "SELECT * FROM aula_assistida INNER JOIN aula ON aula.aula_id = aula_assistida.aula_id WHERE id_usuario = $id_usuario ORDER BY aula_assistida.data_assistida DESC";
       return $this->select($this->db, $sql,true);
    }
    
    public function verificaCursando($usuario, $curso){
         $sql = "SELECT id_usuario FROM cliente_curso WHERE curso_id = $curso and id_usuario = $usuario";
         if(count($this->select($this->db, $sql)) > 0){
            return true; 
         }
     }
    
    public function verificaCursandoAula($usuario, $aula){
         $sql = "SELECT * FROM cliente_curso INNER JOIN aula ON cliente_curso.curso_id = aula.curso_id where cliente_curso.id_usuario = $usuario and aula.aula_id = $aula";
         if(count($this->select($this->db, $sql)) > 0){
            return true; 
         }
     }
     
     
    public function getAulaAssistida($usuario, $aula, $curso){
         $sql = "SELECT * 
                FROM aula_assistida 
                WHERE aula_id = :aula_id
                AND id_usuario = :id_usuario
                AND curso_id = :curso_id";
         
         $stmt = $this->db->prepare($sql);
         $stmt->bindValue(":id_usuario", $usuario);
         $stmt->bindValue(":aula_id", $aula);
         $stmt->bindValue(":curso_id", $curso);         
         $stmt->execute();
         return $stmt->fetch(\PDO::FETCH_OBJ);
     }      
   
     
     public function proxima_aula($ordemAula,$curso){
        $sql = "SELECT aula_id 
                FROM aula 
                WHERE curso_id      = :curso_id
                and ordem_aula > :ordem_aula
                order by ordem_aula asc
                limit 1" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":curso_id", $curso);
        $stmt->bindValue(":ordem_aula", $ordemAula); 
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ)->aula_id; 
     }
     
     public function aulaAnterior($ordemAula,$curso){
        $sql = "SELECT aula_id 
                FROM aula 
                WHERE curso_id      = :curso_id
                and ordem_aula < :ordem_aula
                order by ordem_aula DESC
                limit 1" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":curso_id", $curso);
        $stmt->bindValue(":ordem_aula", $ordemAula); 
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ)->aula_id; 
     }
     
     public function todosCursos($id_usuario){
        $sql = "SELECT *,curso.curso_id curso_curso_id "
                . "FROM curso "
                . "left join cliente_curso ON "
                . "cliente_curso.curso_id = curso.curso_id AND "
                . "cliente_curso.id_usuario = :id_usuario" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
     
     public function aulasCapitulo($curso){
        $sql = "SELECT aula.capitulo_id , capitulo.titulo_capitulo, capitulo.qtd_aulas,capitulo.duracao,
                aula.duracao_aula, capitulo.capitulo_id,aula.aula_id,aula.ordem_aula,aula.aula ,IF(aula_assistida.aula_assistida_id > 0,1,0) assistida 
                FROM aula 
                INNER JOIN capitulo ON
                capitulo.capitulo_id = aula.capitulo_id 
                LEFT JOIN aula_assistida ON
                aula_assistida.aula_id = aula.aula_id
                AND aula_assistida.id_usuario = :id_usuario
                WHERE aula.curso_id = :curso_id
                ORDER BY capitulo.capitulo_id,aula.ordem_aula" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":curso_id", $curso);
        $stmt->bindValue(":id_usuario", $_SESSION[SESSION_LOGIN]->id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
     
     public function duracaoCurso($curso){
        $sql = "SELECT time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( duracao_aula ) ) ),'%H:%i:%s') duracao_curso "
                . "FROM aula"
                . " WHERE curso_id = :curso_id" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":curso_id", $curso);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ)->duracao_curso; 
     }
     
     public function centConcluido($curso){
        $sql = "SELECT count(aula_assistida.aula_assistida_id) qtd_aulas_assistidas,
            round(SUM( TIME_TO_SEC( duracao_aula ))/(SELECT SUM( TIME_TO_SEC( duracao_aula ) ) FROM aula WHERE curso_id = :curso_id)*100,0) concluido 
            FROM aula_assistida 
            INNER JOIN aula ON aula.aula_id = aula_assistida.aula_id 
            WHERE aula_assistida.id_usuario = :id_usuario 
            AND aula_assistida.curso_id = :curso_id" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":curso_id", $curso);
        $stmt->bindValue(":id_usuario", $_SESSION[SESSION_LOGIN]->id_usuario);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ); 
     }
     
     public function ultimaAulaAssistida($curso){
        $sql = "SELECT aula_assistida.data_assistida 
                FROM aula_assistida
                WHERE aula_assistida.id_usuario = :id_usuario
                and aula_assistida.curso_id = :curso_id
                ORDER BY aula_assistida.data_assistida
                LIMIT 1" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":curso_id", $curso);
        $stmt->bindValue(":id_usuario", $_SESSION[SESSION_LOGIN]->id_usuario);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ)->data_assistida; 
     }
     
     public function comentario(){
        $sql = "SELECT comentario.id_comentario, comentario.comentario,aula.aula,resposta.resposta,resposta.data_resposta "
                . "FROM comentario "
                . "LEFT JOIN resposta ON "
                . "resposta.id_comentario = comentario.id_comentario "
                . "INNER JOIN aula ON "
                . "aula.aula_id = comentario.aula_id "
                . "WHERE comentario.id_usuario = :id_usuario "
                . "ORDER BY comentario.data_comentario" ;   
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_usuario", $_SESSION[SESSION_LOGIN]->id_usuario);
        $stmt->execute(); 
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
     
     public function comentarioAula($aula){
        
        $sql = "SELECT comentario.id_comentario, comentario.comentario,aula.aula,resposta.resposta,resposta.data_resposta "
                . "FROM comentario "
                . "LEFT JOIN resposta ON "
                . "resposta.id_comentario = comentario.id_comentario "
                . "INNER JOIN aula ON "
                . "aula.aula_id = comentario.aula_id "
                . "WHERE comentario.id_usuario = :id_usuario "
                . "AND comentario.aula_id = :aula_id "
                . "ORDER BY comentario.data_comentario" ;          
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_usuario", $_SESSION[SESSION_LOGIN]->id_usuario);
        $stmt->bindValue(":aula_id", $aula);
        $stmt->execute(); 
    
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
     
     public function ultimosCadastrados(){
        $sql = "SELECT id_usuario, email, usuario, data_cadastro
                FROM `usuarios` 
                ORDER BY id_usuario DESC
                LIMIT 5" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
     
     public function acessosRecentes(){
        $sql = "SELECT id_usuario, email, usuario, ultimo_acesso, qtd_acessos
                FROM `usuarios` 
                WHERE id_usuario <> 55282
                ORDER BY ultimo_acesso DESC
                LIMIT 5" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
     
     public function comentariosResponder(){
        $sql = "SELECT comentario.id_comentario, comentario.id_usuario, comentario.curso_id,comentario.aula_id, comentario.comentario, aula.aula, resposta.resposta, resposta.data_resposta,usuarios.usuario,curso.curso
                FROM comentario 
                LEFT JOIN resposta ON 
                resposta.id_comentario = comentario.id_comentario 
                INNER JOIN aula ON 
                aula.aula_id = comentario.aula_id 
                INNER JOIN usuarios ON
                usuarios.id_usuario = comentario.id_usuario
                INNER JOIN curso ON
                comentario.curso_id = curso.curso_id
                ORDER BY comentario.data_comentario
                limit 10" ;   
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ); 
     }
     
     public function jaRespondeu($id_pergunta){        
        $sql = "SELECT id_pergunta_opcao
                FROM pergunta_cliente
                WHERE id_usuario = :id_usuario
                AND id_pergunta = :id_pergunta" ;          
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_usuario", $_SESSION[SESSION_LOGIN]->id_usuario);
        $stmt->bindValue(":id_pergunta", $id_pergunta);
        $stmt->execute();        
        return $stmt->fetch(\PDO::FETCH_OBJ)->id_pergunta_opcao;               
     }
     
     public function correta($id_pergunta){        
        $sql = "SELECT id_pergunta_opcao "
                . "FROM pergunta_opcao "
                . "WHERE id_pergunta = :id_pergunta"
                . " AND correta" ;          
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id_pergunta", $id_pergunta);
        $stmt->execute();        
        return $stmt->fetch(\PDO::FETCH_OBJ)->id_pergunta_opcao;               
     }
     
     public function proximaOrdemAula($capitulo_id,$curso_id){        
        $sql = "SELECT ordem_aula "
                . "FROM aula "
                . "WHERE capitulo_id = :capitulo_id "
                . "and curso_id = :curso_id "
                . "ORDER BY ordem_aula DESC "
                . "LIMIT 1" ;          
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":capitulo_id", $capitulo_id);
        $stmt->bindValue(":curso_id", $curso_id);
        $stmt->execute();        
        return $stmt->fetch(\PDO::FETCH_OBJ)->ordem_aula + 1;               
     }
     
     
     
}
