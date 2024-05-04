<?php
namespace app\models\validacao;
use app\core\Validacao;
use app\models\service\Service;

class UserValidacao {
    public static function salvar($usuario) {
        $validacao = new Validacao();    
        $validacao->setData("email", $usuario->email, "Email");
        $validacao->setData("usuario", $usuario->usuario, "Usuário");
        $validacao->setData("nome_completo", $usuario->nome_completo, "nome completo");
        $validacao->setData("nome_fantasia", $usuario->nome_fantasia, "nome fantasia");
        $validacao->setData("cpf", $usuario->cpf, "CPF");
        $validacao->setData("cnpj", $usuario->cnpj, "cnpj");
        $validacao->setData("fone", $usuario->fone, "fone");
        $validacao->setData("celular", $usuario->celular, "celular");
        $validacao->setData("cep", $usuario->cep, "CEP");
        $validacao->setData("numero", $usuario->numero, "numero");
        $validacao->setData("rua", $usuario->rua, "rua");
        $validacao->setData("estado", $usuario->estado, "estado");
        $validacao->setData("cidade", $usuario->cidade, "cidade");
        $validacao->setData("complemento", $usuario->complemento, "complemento");
        $validacao->setData("bairro", $usuario->bairro, "bairro");
        $validacao->setData("ie", $usuario->ie, "ie");
        $validacao->setData("rg", $usuario->rg, "rg");
    
        // Fazendo a validação
        //$validacao->getData("Usuarios_name")->isVazio();          
        //$validacao->getData("email")->isUnico(Service::get('usuarios','email',$usuario->email), "Já existe um usuário cadastrado com esse email."); 
        
        return $validacao;
    }

    public static function recuperaSenha($usuario){  
                
        $validacao = new Validacao();        
        $validacao->setData("senha", $usuario->senha);
        $validacao->setData("confirmacao", $usuario->confirmacao);
        
        //fazendo a validação        
        $validacao->getData("senha")->isVazio()->isMinimo(5);
        $validacao->getData("senha")->isSenhaValida();      
       
        if($usuario->senha != $usuario->confirmacao){
            $validacao->getData("senha")->isUnico(1, "O valor do campo senha e confirmação precisam ser identicos");               
        }
        
        return $validacao;        
    }
}
