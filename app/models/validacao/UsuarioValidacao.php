<?php
namespace app\models\validacao;
use app\models\service\Service;
use app\core\Validacao;

class UsuarioValidacao{
    public static function salvar($usuario){  
                
        $validacao = new Validacao();
        
        $validacao->setData("email", $usuario->email);
        $validacao->setData("senha", $usuario->senha);
        $validacao->setData("confirmacao", $usuario->confirmacao);
        $validacao->setData("cookies", $usuario->cookies);
        $validacao->setData("politica", $usuario->politica);

        $emailRepetido = Service::get("usuarios", "email", $usuario->email);
        
        //fazendo a validação
        $validacao->getData("email")->isVazio();
        $validacao->getData("email")->isEmail();

        $validacao->getData("senha")->isVazio()->isMinimo(5);
        $validacao->getData("senha")->isSenhaValida();

        $validacao->getData("cookies")->isVazio("Você precisa aceitar os cookies");
        $validacao->getData("politica")->isVazio("você precisa aceitar a política de privacidade");
       
        if($emailRepetido){
                $validacao->getData("email")->isUnico(1, "Ja existe um usuario com esse e-mail");
            }
        
       
        if($usuario->senha != $usuario->confirmacao){
            $validacao->getData("senha")->isUnico(1, "O valor do campo senha e confirmação precisam ser identicos");  
             
        }
        
        return $validacao;        
    }
    
     public static function editar($usuario){ 
         
        $validacao = new Validacao(); 
        
        $validacao->setData("email", $usuario->email);
        $validacao->setData("usuario", $usuario->usuario);
        $validacao->setData("cpf", $usuario->cpf);
        $validacao->setData("data_nascimento", $usuario->data_nascimento);
        $validacao->setData("telefone", $usuario->telefone);
        $validacao->setData("profissao", $usuario->profissao);
        $validacao->setData("bairro", $usuario->bairro);
        $validacao->setData("cidade", $usuario->cidade);
        $validacao->setData("endereco", $usuario->endereco);
        $validacao->setData("estado", $usuario->estado);
        $validacao->setData("cep", $usuario->cep);
        $validacao->setData("complemento", $usuario->complemento);
        $validacao->setData("numero", $usuario->numero);
        
        $validacao->getData("email")->isVazio();
        $validacao->getData("email")->isEmail();

        return $validacao;          
     }
     
     public static function recuperaSenha($usuario){  
                
        $validacao = new Validacao();        
        $validacao->setData("senha", $usuario->senha);
        $validacao->setData("confirmacao", $usuario->confirmacao);
        
        //fazendo a validação        
        $validacao->getData("senha")->isVazio()->isMinimo(5);
        $validacao->getData("confirmacao")->isVazio()->isMinimo(5);          
       
        if($usuario->senha != $usuario->confirmacao){
            $validacao->getData("senha")->isUnico(1, "O valor do campo senha e confirmação precisam ser identicos");               
        }
        
        return $validacao;        
    }
}

