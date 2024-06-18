<?php
namespace app\models\validacao;
use app\models\service\Service;
use app\core\Validacao;

class UsersValidacao{
    public static function salvar($usuario){  
                
        $validacao = new Validacao();
        
        $validacao->setData("email", $usuario->email);
        $validacao->setData("password", $usuario->password);
        $validacao->setData("confirmacao", $usuario->confirmacao);
        $validacao->setData("cookies", $usuario->cookies);
        $validacao->setData("politica", $usuario->politica);

        $emailRepetido = Service::get("users", "email", $usuario->email);
        
        //fazendo a validação
        $validacao->getData("email")->isVazio();
        $validacao->getData("email")->isEmail();

        $validacao->getData("password")->isVazio()->isMinimo(5);
        $validacao->getData("password")->issenhaValida();

        $validacao->getData("cookies")->isVazio("Você precisa aceitar os cookies");
        $validacao->getData("politica")->isVazio("você precisa aceitar a política de privacidade");
       
        if($emailRepetido){
                $validacao->getData("email")->isUnico(1, "Ja existe um usuario com esse e-mail");
            }
        
       
        if($usuario->password != $usuario->confirmacao){
            $validacao->getData("password")->isUnico(1, "O valor do campo password e confirmação precisam ser identicos");  
             
        }
        
        return $validacao;        
    }
    
     public static function editar($usuario){ 
         
        $validacao = new Validacao(); 
        
        $validacao->setData("email", $usuario->email);
        
        $validacao->getData("email")->isVazio();
        $validacao->getData("email")->isEmail();

        return $validacao;          
     }
     
     public static function recuperapassword($usuario){  
                
        $validacao = new Validacao();        
        $validacao->setData("password", $usuario->password);
        $validacao->setData("confirmacao", $usuario->confirmacao);
        
        //fazendo a validação        
        $validacao->getData("password")->isVazio()->isMinimo(5);
        $validacao->getData("confirmacao")->isVazio()->isMinimo(5);          
       
        if($usuario->password != $usuario->confirmacao){
            $validacao->getData("password")->isUnico(1, "O valor do campo password e confirmação precisam ser identicos");               
        }
        
        return $validacao;        
    }
}

