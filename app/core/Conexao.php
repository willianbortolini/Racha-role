<?php
namespace app\core;

use Exception;
use PDOException;

class Conexao{
    private static $conexao = null;
    public static function getConexao(){
        try{
            if(!self::$conexao){
                if (DOCKER_CONTAINER === true){
                    self::$conexao = new \PDO("mysql:dbname=".BANCO.";host=db;port=3306", USUARIO, SENHA);
                }else{
                    self::$conexao = new \PDO("mysql:dbname=".BANCO.";host=".SERVIDOR,USUARIO,SENHA);
                }
                self::$conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$conexao->exec("SET NAMES " . CHARSET);
            }
            return self::$conexao;
            
        }catch (PDOException $e){
            throw new Exception("Erro ao tentar conectar com o banco");
        }
    }
}