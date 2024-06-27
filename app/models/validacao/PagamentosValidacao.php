<?php
namespace app\models\validacao;
use app\core\Validacao;

class PagamentosValidacao {
    public static function salvar($pagamentos) {
        $validacao = new Validacao();    
        $validacao->setData("pagador", $pagamentos->pagador, "ID do Usuário");
        $validacao->setData("recebedor", $pagamentos->recebedor, "ID do pagador");
        $validacao->setData("valor", $pagamentos->valor, "Valor");
        $validacao->setData("data", $pagamentos->data, "Data");
    
        // Fazendo a validação
        $validacao->getData("pagador")->isVazio();
        $validacao->getData("recebedor")->isVazio();
        $validacao->getData("valor")->isVazio();
        $validacao->getData("data")->isVazio();
   
        return $validacao;
    }
}
