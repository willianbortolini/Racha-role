<?php

namespace app\models\service;

use app\models\validacao\Usuarios_gruposValidacao;
use app\models\dao\Usuarios_gruposDao;
use app\core\Flash;

class Usuarios_gruposService
{
    const TABELA = "usuarios_grupos";
    const CAMPO = "usuarios_grupos_id";

    public static function salvar($Usuarios_grupos, $participantes)
    {        
        $transaction = false;
        if (!Service::inTransaction()) {
            Service::begin_tran();
            $transaction = true;
        }
        
        try {
            foreach ($participantes as $usuario) {
                if (!self::estaNoGrupo($usuario, $Usuarios_grupos->grupos_id)) {
                    $usuarios = new \stdClass();
                    $usuarios->usuarios_grupos_id = 0;
                    $usuarios->grupos_id = $Usuarios_grupos->grupos_id;
                    $usuarios->users_id = $usuario;
                    $validacao = Usuarios_gruposValidacao::salvar($usuarios);
                    Service::salvar($usuarios, self::CAMPO, $validacao->listaErros(), self::TABELA);
                }
            }
            if ($transaction) {
                Service::commit();
            }
            return 1;
        } catch (\Exception $e) {
            Flash::setMsg('Erro ao adicionar os usuários.', -1);
            service::rollback();
            return 0;
        }
    }

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function membrosDoGrupo($grupos_id)
    {
        $dao = new Usuarios_gruposDao();
        return $dao->membrosDoGrupo($grupos_id);
    }

    public static function estaNoGrupo($users_id, $grupos_id)
    {
        $dao = new Usuarios_gruposDao();
        return $dao->estaNoGrupo($users_id, $grupos_id);
    }
}
