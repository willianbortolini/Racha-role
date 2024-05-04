<?php

namespace app\models\service;

use app\models\validacao\ReservaValidacao;
use app\models\dao\ReservaDao;
use app\util\UtilService;
use app\models\service\Movimentacao_estoqueService;

class ReservaService
{
    const TABELA = "reserva";
    const CAMPO = "reserva_id";
    public static function salvar($reserva)
    {      
        $validacao = ReservaValidacao::salvar($reserva);
        $reserva_id = Service::salvar($reserva, SELF::CAMPO, $validacao->listaErros(), self::TABELA);

        $movimentacao_estoque = new \stdClass();
        $movimentacao_estoque->movimentacao_estoque_id = 0;
        $movimentacao_estoque->produtos_id = $reserva->produtos_id;
        $movimentacao_estoque->quantidade = $reserva->quantidade;
        $movimentacao_estoque->tipo_movimentacao = MOVIMENTACAO_RESERVA;
        $movimentacao_estoque->descricao = "Reserva de estoque documento: ". $reserva->documento;
        $movimentacao_estoque->usuarios_id = $_SESSION['id'];
        $movimentacao_estoque->reserva_id = $reserva_id;
        Movimentacao_estoqueService::salvar($movimentacao_estoque);

        return $reserva_id;
    }

    public static function pesquisa($pesquisa)
    {
        $dao = new ReservaDao;       
        return $dao->pesquisa($pesquisa);
    }

    public static function excluir( $id)
    {        
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function liberarReservasDeDocumento($tipo_documento, $documento)
    {   
        $dao = new ReservaDao;        
        return $dao->liberarReservasDeDocumento($tipo_documento, $documento);           
    }

    public static function excluirOP($OP_id)
    {
        $dao = new ReservaDao;
        $dao->excluiOP($OP_id);
    }
}