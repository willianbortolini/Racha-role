<?php

namespace app\models\service;

use app\models\validacao\ComposicaoValidacao;
use app\models\dao\ComposicaoDao;
use app\util\UtilService;
use app\models\service\Service;

class ComposicaoService
{
    public static function salvar($composicao, $campo, $tabela)
    {
        $validacao = ComposicaoValidacao::salvar($composicao);

        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            
            if (isset($_POST["remove_ajuda_imagem"]) && $_POST["remove_ajuda_imagem"] === "1") {
                $existe_imagem = service::get($tabela, $campo, $composicao->composicao_id);
                if (isset($existe_imagem->ajuda_imagem) && $existe_imagem->ajuda_imagem != '') {
                    UtilService::deletarImagens($existe_imagem->ajuda_imagem);
                }
                $composicao->ajuda_imagem = '';
            } else {
                if (isset($_FILES["ajuda_imagem"]["name"]) && $_FILES["ajuda_imagem"]["error"] === UPLOAD_ERR_OK) {
                    
                    $existe_imagem = service::get($tabela, $campo, $composicao->composicao_id);                    
                    
                    if (isset($existe_imagem->ajuda_imagem) && $existe_imagem->ajuda_imagem != '') {                        
                        UtilService::deletarImagens($existe_imagem->ajuda_imagem);
                    }
                    
                    $composicao->ajuda_imagem = UtilService::upload("ajuda_imagem", $config_upload);
                   
                    if (!$composicao->ajuda_imagem) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($composicao, $campo, $validacao->listaErros(), $tabela);

    }  

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }

    public static function composicao($produto_id)
    {
        $dao = new ComposicaoDao();
        return $dao->composicao($produto_id);
    }

    public static function composicoesDeUmaComposicao($composicao_id)
    {
        $dao = new ComposicaoDao();
        return $dao->composicoesDeUmaComposicao($composicao_id);
    }
}