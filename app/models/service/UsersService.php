<?php

namespace app\models\service;

use app\models\validacao\UsersValidacao;
use app\models\dao\UsersDao;
use app\util\UtilService;

class UsersService
{
    const TABELA = "users"; 
    const CAMPO = "users_id";     

    public static function salvar($Users)
    {
        if($Users->users_id > 0){
            $validacao = UsersValidacao::editar($Users);
        }else{
            $validacao = UsersValidacao::salvar($Users);
        }     
        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_foto_perfil"]) && $_POST["remove_foto_perfil"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->foto_perfil);
                }
                $Users->foto_perfil = '';
            } else {
                if (isset($_FILES["foto_perfil"]["name"]) && $_FILES["foto_perfil"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                    if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                      UtilService::deletarImagens($existe_imagem->foto_perfil);
                    }
                    $Users->foto_perfil = UtilService::uploadImagem("foto_perfil", $config_upload);
                    if (!$Users->foto_perfil) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($Users, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function criar($Users)
    {
        $validacao = UsersValidacao::salvar($Users);
        unset($Users->confirmacao); 
        if(isset($Users->password)){
            $Users->password = password_hash($Users->password,PASSWORD_DEFAULT);
        }

        global $config_upload;
        if ($validacao->qtdeErro() <= 0) {
            if (isset($_POST["remove_foto_perfil"]) && $_POST["remove_foto_perfil"] === "1") {
                $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                    UtilService::deletarImagens($existe_imagem->foto_perfil);
                }
                $Users->foto_perfil = '';
            } else {
                if (isset($_FILES["foto_perfil"]["name"]) && $_FILES["foto_perfil"]["error"] === UPLOAD_ERR_OK) {
                    $existe_imagem = service::get(self::TABELA, self::CAMPO, $Users->users_id);
                    if (isset($existe_imagem->foto_perfil) && $existe_imagem->foto_perfil != '') {
                      UtilService::deletarImagens($existe_imagem->foto_perfil);
                    }
                    $Users->foto_perfil = UtilService::uploadImagem("foto_perfil", $config_upload);
                    if (!$Users->foto_perfil) {
                        return false;
                    }
                }
            }
        }

        return Service::salvar($Users, self::CAMPO, $validacao->listaErros(), self::TABELA);
    }  

    public static function ativo($Users)
    {     
        return Service::salvar($Users, self::CAMPO, [], self::TABELA);
    }  

    public static function excluir($id)
    {
        Service::excluir(self::TABELA, self::CAMPO, $id);
    }

    public static function recuperaSenha($usuario, $campo, $tabela) {        
        $validacao = UsersValidacao::recuperapassword($usuario);         
        unset($usuario->confirmacao); 
        if(isset($usuario->password)){
            $usuario->password = password_hash($usuario->password,PASSWORD_DEFAULT);
        }
         return Service::salvar($usuario, $campo, $validacao->listaErros(), $tabela);
    }

    function crc16($str) {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($str); $i++) {
            $x = (($crc >> 8) ^ ord($str[$i])) & 0xFF;
            $x ^= ($x >> 4);
            $crc = (($crc << 8) & 0xFFFF) ^ ($x << 12) ^ ($x << 5) ^ $x;
        }
        return strtoupper(dechex($crc));
    }
    
    function gerar_codigo_pix($chave_pix, $nome_recebedor, $cidade_recebedor = "CIDADE NÃO INFORMADA", $valor = null) {
        $nome_recebedor = strtoupper($nome_recebedor); // Pix exige nome em maiúsculas
        $cidade_recebedor = strtoupper($cidade_recebedor); // Pix exige cidade em maiúsculas
    
        // Formatando os campos
        $payload = [
            "00" => "01", // Payload Format Indicator
            "26" => "br.gov.bcb.pix", // Merchant Account Information Template
            "01" => $chave_pix, // Chave Pix
            "59" => $nome_recebedor, // Nome do recebedor
            "60" => $cidade_recebedor, // Cidade do recebedor
        ];
    
        if ($valor !== null) {
            $payload["54"] = number_format($valor, 2, '.', ''); // Valor da transação
        }
    
        // Construindo a string do payload
        $payload_str = "000201"; // Payload Format Indicator + Point of Initiation Method
        foreach ($payload as $id => $value) {
            $payload_str .= $id . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
        }
    
        // Adicionando campo de verificação (CRC-16)
        $payload_str .= "6304"; // Campo CRC-16
        $payload_str .= Self::crc16($payload_str); // Valor CRC-16
    
        return $payload_str;
    }
}