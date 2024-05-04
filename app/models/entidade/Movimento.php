<?php

namespace app\models\entidade;

class Movimento {
    private $id_movimento ; 
    private $id_localizacao ;
    private $id_empresa ;
    private $id_tipo_movimento ;        
    private $id_produto ;        
    private $id_ordem_compra ;        
    private $id_pedido ;        
    private $id_entrada_avulsa ;       
    private $id_saida_avulsa ;       
    private $id_ordem_producao ;
    private $id_transferencia ;  
    private $ent_sai ;
    private $data_movimento ;        
    private $qtde_movimento ;        
    private $valor_movimento ;        
    private $subtotal_movimento ; 
    private $descricao ;
    private $saldoestoque ;
    
    function getId_transferencia() {
        return $this->id_transferencia;
    }

    function setId_transferencia($id_transferencia) {
        $this->id_transferencia = $id_transferencia;
    }

    function getId_movimento() {        
            return $this->id_movimento;        
    }
    
    function getId_empresa() {        
            return $this->id_empresa;        
    }

    function getId_localizacao() {
        return $this->id_localizacao;
    }

    function getId_tipo_movimento() {
        return $this->id_tipo_movimento;
    }

    function getId_produto() {
        return $this->id_produto;
    }

    function getId_ordem_compra() {
        return $this->id_ordem_compra;
    }

    function getId_pedido() {
        return $this->id_pedido;
    }

    function getId_entrada_avulsa() {
        return $this->id_entrada_avulsa;
    }

    function getId_saida_avulsa() {
        return $this->id_saida_avulsa;
    }

    function getId_ordem_producao() {
        return $this->id_ordem_producao;
    }

    function getEnt_sai() {
        return $this->ent_sai;
    }

    function getData_movimento() {
        return $this->data_movimento;
    }

    function getQtde_movimento() {
        return $this->qtde_movimento;
    }

    function getValor_movimento() {
        return $this->valor_movimento;
    }

    function getSubtotal_movimento() {
        return $this->subtotal_movimento;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getSaldoestoque() {
        return $this->saldoestoque;
    }

    function setId_movimento($id_movimento) {
        $this->id_movimento = $id_movimento;
    }

    function setId_localizacao($id_localizacao) {
        $this->id_localizacao = $id_localizacao;
    }

    function setId_tipo_movimento($id_tipo_movimento) {
        $this->id_tipo_movimento = $id_tipo_movimento;
    }
    
    function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }
    

    function setId_produto($id_produto) {
        $this->id_produto = $id_produto;
    }

    function setId_ordem_compra($id_ordem_compra) {
        $this->id_ordem_compra = $id_ordem_compra;
    }

    function setId_pedido($id_pedido) {
        $this->id_pedido = $id_pedido;
    }

    function setId_entrada_avulsa($id_entrada_avulsa) {
        $this->id_entrada_avulsa = $id_entrada_avulsa;
    }

    function setId_saida_avulsa($id_saida_avulsa) {
        $this->id_saida_avulsa = $id_saida_avulsa;
    }

    function setId_ordem_producao($id_ordem_producao) {
        $this->id_ordem_producao = $id_ordem_producao;
    }

    function setEnt_sai($ent_sai) {
        $this->ent_sai = $ent_sai;
    }

    function setData_movimento($data_movimento) {
        $this->data_movimento = $data_movimento;
    }

    function setQtde_movimento($qtde_movimento) {
        $this->qtde_movimento = $qtde_movimento;
    }

    function setValor_movimento($valor_movimento) {
        $this->valor_movimento = $valor_movimento;
    }

    function setSubtotal_movimento($subtotal_movimento) {
        $this->subtotal_movimento = $subtotal_movimento;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSaldoestoque($saldoestoque) {
        $this->saldoestoque = $saldoestoque;
    }

        public function toArray() {
        $array = array();
        foreach ($this as $key => $value){
            if(property_exists($this, $key)){
                $array[$key] = $value;
            }
        }
        return $array;
    }
    
    public function toStd() {
        $std = new \stdClass();
        foreach ($this as $key => $value){
            if(property_exists($this, $key)){
                if(is_object($value)){
                    $std->{$key} = $value->getStdClass();
                }else{
                    $std->{$key} = $value;
                }
            }
        }
        return $std;        
    }

}
