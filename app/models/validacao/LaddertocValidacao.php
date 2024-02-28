<?php
namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class LaddertocValidacao{
    public static function salvar($maquina){
        $validacao = new Validacao();
        $validacao->setData("nome", $maquina->nome);
        $validacao->setData("codigo", $maquina->codigo);
        $validacao->setData("id_empresa", $maquina->id_empresa);
        $validacao->setData("erro", $maquina->erro);
        
        
        //fazendo a validação
        $validacao->getData("nome")->isVazio();
        //$validacao->getData("codigo")->isVazio();
        //$validacao->getData("id_empresa")->isVazio();
        
        
        if($maquina->erro == "1"){
            $validacao->getData("erro")->isUnico(1,"Não existe máquina com esse código.");
        }
        
        if($maquina->erro == "2"){
            $validacao->getData("erro")->isUnico(2,"Essa máquia esta cadastrada em outra empresa");
        }
        
        return $validacao;
        
    }
}

