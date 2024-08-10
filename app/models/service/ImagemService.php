<?php

namespace app\models\service;

use app\core\Flash;
class ImagemService
{

    public static function  uploadImagem150e500($arq, $config_upload)
    {
        set_time_limit(0);
        $nome_arquivo = $_FILES[$arq]["name"];
        $tamanho_arquivo = $_FILES[$arq]["size"];
        $arquivo_temporario = $_FILES[$arq]["tmp_name"];
        $erro = 0;
        $msg = "";

        if (!empty($nome_arquivo)) {
            $ext = strrchr($nome_arquivo, ".");
            $nome_final = ($config_upload["renomeia"]) ? uniqid() . $ext : $nome_arquivo;
            $caminho = $config_upload["caminho_absoluto"] . $nome_final;

            if (($config_upload["verifica_extensao"]) && (in_array(strtolower($ext), $config_upload["extensoes_imagem"]))) {
                $msg = "O arquivo não é permitido para upload";
                $erro = -1;
            } else {
                if (move_uploaded_file($arquivo_temporario, $caminho)) {
                    $msg = "Arquivo enviado com sucesso";
                    $erro = 0;

                    $imagem = imagecreatefromstring(file_get_contents($caminho));
                    $largura_original = imagesx($imagem);
                    $altura_original = imagesy($imagem);
                    $proporcao_original = $largura_original / $altura_original;

                    // Cria miniatura de 500px
                    $caminho_miniatura_500 = $config_upload["caminho_absoluto"] . "mini_500_" . $nome_final;
                    self::redimensionar_e_salvar($imagem, $largura_original, $altura_original, $proporcao_original, 500, 500, $caminho_miniatura_500);

                    // Cria miniatura de 150px
                    $caminho_miniatura_150 = $config_upload["caminho_absoluto"] . "mini_150_" . $nome_final;
                    self::redimensionar_e_salvar($imagem, $largura_original, $altura_original, $proporcao_original, 150, 150, $caminho_miniatura_150);

                    imagedestroy($imagem);
                    unlink($caminho); // Remove a imagem original

                } else {
                    $msg = "Erro ao fazer o upload";
                    $erro = -1;
                }
            }
        } else {
            $msg = "Arquivo vazio";
            $erro = -1;
        }

        if ($erro == 0) {
            Flash::limpaForm();
            return $nome_final;
        } else {
            Flash::limpaMsg();
            Flash::setMsg("Erro: " . $msg, -1);
            return false;
        }
    }

    // Função para redimensionar e salvar a imagem
    private static function redimensionar_e_salvar($imagem, $largura_original, $altura_original, $proporcao_original, $largura_maxima, $altura_maxima, $caminho_destino)
    {
        if ($largura_original > $largura_maxima || $altura_original > $altura_maxima) {
            if ($largura_original > $altura_original) {
                $nova_largura = $largura_maxima;
                $nova_altura = round($nova_largura / $proporcao_original);
            } else {
                $nova_altura = $altura_maxima;
                $nova_largura = round($nova_altura * $proporcao_original);
            }

            $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
            imagealphablending($imagem_redimensionada, false);
            imagesavealpha($imagem_redimensionada, true);
            imagecopyresampled($imagem_redimensionada, $imagem, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);
            imagepng($imagem_redimensionada, $caminho_destino);
            imagedestroy($imagem_redimensionada);
        }
    }

    public static function  deletarImagens($nomeImagem)
    {
        $caminho_absoluto = CAMINHO_ABSOLUTO;

        $nomeImagemOriginal = $caminho_absoluto . $nomeImagem;
        $nomeImagemMidi = $caminho_absoluto . "mini_150_" . $nomeImagem;
        $nomeImagemMini = $caminho_absoluto . "mini_500_" . $nomeImagem;

        try {
            // Verifica se o arquivo original existe e deleta
            if (file_exists($nomeImagemOriginal)) {
                unlink($nomeImagemOriginal);

            }

            // Verifica se o arquivo com prefixo "midi" existe e deleta
            if (file_exists($nomeImagemMidi)) {
                unlink($nomeImagemMidi);
            }

            // Verifica se o arquivo com prefixo "mini" existe e deleta
            if (file_exists($nomeImagemMini)) {
                unlink($nomeImagemMini);
            }

            $msg = "Imagens deletadas com sucesso";
            $erro = 0;
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            $erro = -1;
        }

        if ($erro == 0) {
            Flash::limpaForm();
            return $nomeImagem;
        } else {
            Flash::limpaMsg();
            Flash::setMsg("Erro: " . $msg, -1);
            return false;
        }
    }
}