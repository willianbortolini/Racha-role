<?php

namespace app\models\dao;

use app\core\Model;

class UsuarioDao extends Model{
    public function atualizaEstoque($usuario_id, $qtde) {
        $sql = "UPDATE usuario SET estoque_atual = estoque_atual + ('$qtde'), estoque_real = estoque_real + ('$qtde') WHERE usuario_id = '$usuario_id'";
        $this->db->query($sql);
    }
}
