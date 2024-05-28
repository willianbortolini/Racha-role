<?php
namespace app\models\validacao;

use app\core\Validacao;

class LoginValidacao{
    public static function salvar($login){
        $validacao = new Validacao();
        
        $validacao->setData("login", $login->login);
        $validacao->setData("password", $login->password);
        //$validacao->setData("recaptcha", $login->recaptcha);

        //fazendo a validação
        $validacao->getData("login")->isVazio();
        $validacao->getData("password")->isVazio();
        //$validacao->getData("recaptcha")->Captcha($login->recaptcha);        
        return $validacao;
        
    }
    
     public static function loginSemRecaptcha($login){
        $validacao = new Validacao();
        
        $validacao->setData("login", $login->login);
        $validacao->setData("password", $login->password);

        //fazendo a validação
        $validacao->getData("login")->isVazio();
        $validacao->getData("password")->isVazio();       
        return $validacao;
        
    }

    public static function login($login){
        $validacao = new Validacao();        
        $validacao->setData("email", $login->email);
        $validacao->setData("password", $login->password);

        //fazendo a validação
        $validacao->getData("email")->isVazio();
        $validacao->getData("password")->isVazio();       
        return $validacao;
        
    }
}

