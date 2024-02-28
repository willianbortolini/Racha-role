<?php

namespace app\models\service;

use app\models\service\Service;
use app\models\validacao\UsuarioValidacao;
use app\util\UtilService;
use app\models\dao\EscolaDao;

class EscolaService {
    public static function meusCursos($usuario) {
        $dao = new EscolaDao();
        $infos = $dao->meusCursos($usuario);
        return $infos;        
    } 
    
    public static function compraCurso($curso) { 
        $usuario = new \stdClass();        
        $usuario->curso_id = $curso;
        $usuario->id_usuario = $_SESSION[SESSION_LOGIN]->id_usuario;  
        $usuario->data_matricula = dataHoraSP();
        $erros = [];        
        return service::salvar($usuario, "cliente_curso_id", $erros, "cliente_curso");        
    }
    
        
    public static function verificaCursando($usuario, $curso) {
        $dao = new EscolaDao();
        return $dao->verificaCursando($usuario, $curso);       
    }
    
    public static function aulas_assistidas() {
        $dao = new EscolaDao();
        return $dao->aulas_assistidas();       
    }
    
    
    public static function verificaCursandoAula($usuario, $aula) {
        $dao = new EscolaDao();
        return $dao->verificaCursandoAula($usuario, $aula);       
    } 
    
    public static function getAulaAssistida($usuario, $aula, $curso) {
        $dao = new EscolaDao();
        return $dao->getAulaAssistida($usuario, $aula, $curso);     
    }     
    
    public static function proxima_aula($ordemAula,$curso) {
        $dao = new EscolaDao();
        return $dao->proxima_aula($ordemAula,$curso);    
    }
    
    public static function aulaAnterior($ordemAula,$curso) {
        $dao = new EscolaDao();
        return $dao->aulaAnterior($ordemAula,$curso);    
    }
    
    public static function todosCursos($id_usuario) {
        $dao = new EscolaDao();
        return $dao->todosCursos($id_usuario);    
    }
    
    public static function aulasCapitulo($curso) {
        $dao = new EscolaDao();
        return $dao->aulasCapitulo($curso);    
    }
    
    public static function duracaoCurso($curso) {
        $dao = new EscolaDao();
        return $dao->duracaoCurso($curso);    
    }
    
    public static function centConcluido($curso){
        $dao = new EscolaDao();
        return $dao->centConcluido($curso);    
    }
    
    public static function ultimaAulaAssistida($curso){
        $dao = new EscolaDao();
        return $dao->ultimaAulaAssistida($curso);    
    }
    
    public static function comentario(){
        $dao = new EscolaDao();
        return $dao->comentario();    
    }
    
    public static function comentarioAula($aula){
        $dao = new EscolaDao();        
        return $dao->comentarioAula($aula);    
    }
    
    public static function ultimosCadastrados(){
        $dao = new EscolaDao();
        return $dao->ultimosCadastrados();    
    }
    
    public static function acessosRecentes(){
        $dao = new EscolaDao();
        return $dao->acessosRecentes();    
    }
    
    public static function comentariosResponder(){
        $dao = new EscolaDao();
        return $dao->comentariosResponder();    
    }
    
    public static function jaRespondeu($id_pergunta){
        $dao = new EscolaDao();
        return $dao->jaRespondeu($id_pergunta);    
    }
    
    public static function correta($id_pergunta){
        $dao = new EscolaDao();
        return $dao->correta($id_pergunta);    
    }
    
    public static function proximaOrdemAula($capitulo_id,$curso_id){
        $dao = new EscolaDao();
        return $dao->proximaOrdemAula($capitulo_id,$curso_id);    
    }
    
    

}
