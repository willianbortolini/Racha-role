<?php
namespace app\models\validacao;

use app\core\Validacao;

class LoginValidacao{
    public static function salvar($login){
        $validacao = new Validacao();
        
        $validacao->setData("login", $login->login);
        $validacao->setData("senha", $login->senha);
        $validacao->setData("recaptcha", $login->recaptcha);

        //fazendo a validação
        $validacao->getData("login")->isVazio();
        $validacao->getData("senha")->isVazio();
        $validacao->getData("recaptcha")->Captcha($login->recaptcha);        
        return $validacao;
        
    }
    
     public static function loginSemRecaptcha($login){
        $validacao = new Validacao();
        
        $validacao->setData("login", $login->login);
        $validacao->setData("senha", $login->senha);

        //fazendo a validação
        $validacao->getData("login")->isVazio();
        $validacao->getData("senha")->isVazio();       
        return $validacao;
        
    }
}

