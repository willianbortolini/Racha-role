<?php

namespace app\models\service;

use app\models\validacao\Foto_item_pedidoValidacao;
use app\models\dao\Foto_item_pedidoDao;
use app\models\service\Service;
use app\util\UtilService;

class Foto_item_pedidoService
{
    public static function salvar($foto_item_pedido, $campo, $tabela)
    {
        $validacao = Foto_item_pedidoValidacao::salvar($foto_item_pedido);
        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_foto_item_pedido_caminho"]) && $_POST["remove_foto_item_pedido_caminho"] === "1") {
                $existe_imagem = service::get($tabela, $campo, $foto_item_pedido->foto_item_pedido_id);
                if (isset($existe_imagem->foto_item_pedido_caminho) && $existe_imagem->foto_item_pedido_caminho != '') {
                    UtilService::deletarImagens($existe_imagem->foto_item_pedido_caminho);
                }
                $foto_item_pedido->foto_item_pedido_caminho = '';
            } else {
                if (isset($_FILES["foto_item_pedido_caminho"]["name"]) && $_FILES["foto_item_pedido_caminho"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get($tabela, $campo, $foto_item_pedido->foto_item_pedido_id);
                    if (isset($existe_imagem->foto_item_pedido_caminho) && $existe_imagem->foto_item_pedido_caminho != '') {
                        UtilService::deletarImagens($existe_imagem->foto_item_pedido_caminho);
                    }
                    $foto_item_pedido->foto_item_pedido_caminho = UtilService::upload("foto_item_pedido_caminho", $config_upload);
                    if (!$foto_item_pedido->foto_item_pedido_caminho) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($foto_item_pedido, $campo, $validacao->listaErros(), $tabela);

    }

    public static function excluir($tabela, $campo, $id)
    {
        Service::excluir($tabela, $campo, $id);
    }
}
