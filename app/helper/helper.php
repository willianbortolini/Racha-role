<?php

function i($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    exit;
}

function tira_mascara($valor)
{
    return preg_replace("/\D+/", "", $valor);
}

function objToArray($objeto)
{
    return is_array($objeto) ? $objeto : (array) $objeto;
}

function validaEmail($email)
{
    $conta = "/[a-zA-Z0-9\._-]+@";
    $domino = "[a-zA-Z0-9\._-]+.";
    $extensao = "([a-zA-Z]{2,4})$/";
    $pattern = $conta . $domino . $extensao;
    if (preg_match($pattern, $email))
        return true;
    else
        return false;
}

function validaSenha($senha) {
    if (!preg_match('/[a-z]/', $senha)) {
        return false;
    }
    if (!preg_match('/[0-9]/', $senha)) {
        return false;
    }
    if (!preg_match('/[A-Z]/', $senha)) {
        return false;
    }
    return true;
}

function validaCPF($cpf)
{
    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }

        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function validaCNPJ($cnpj)
{
    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

    // Valida tamanho
    if (strlen($cnpj) != 14)
        return false;

    // Verifica se todos os digitos são iguais
    if (preg_match('/(\d)\1{13}/', $cnpj))
        return false;

    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
        return false;

    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
}

///
function upload($arq, $config_upload)
{
    
    set_time_limit(0);
    $nome_arquivo = $_FILES[$arq]["name"];
    
    $tamanho_arquivo = $_FILES[$arq]["size"];
    $arquivo_temporario = $_FILES[$arq]["tmp_name"];
    //i($nome_arquivo.$tamanho_arquivo);
    $erro = 0;
    $msg = "";
    $retorno = array();
    if (!empty($nome_arquivo)) {
        $ext = strrchr($nome_arquivo, ".");
        $nome_final = ($config_upload["renomeia"]) ? uniqid() . $ext : $nome_arquivo;
        $caminho = $config_upload["caminho_absoluto"] . $nome_final;


        if (($config_upload["verifica_tamanho"]) && ($tamanho_arquivo > $config_upload["tamanho"])) {
            $msg = "O arquivo é maior que o permitido";
            $erro = -1;
        }

        if (($config_upload["verifica_extensao"]) && (!in_array($ext, $config_upload["extensoes"]))) {
            $msg = "O arquivo não é permitido para upload";
            $erro = -1;
        }

        if ($erro != -1) {
            if (move_uploaded_file($arquivo_temporario, $caminho)) {
                $msg = "Arquivo enviado com sucesso";
                $erro = 0;
            } else {
                $msg = "erro ao fazer o upload";
                $erro = -1;
            }
        }
    } else {
        $msg = "Arquivo vazio";
        $erro = -1;
    }
    $retorno = (object) array("erro" => $erro, "msg" => $msg, "nome" => $nome_final);
    return $retorno;
}

function uploadImagem2($arq, $config_upload)
{
   
    set_time_limit(0);
    $nome_arquivo = $_FILES[$arq]["name"];
    
    $tamanho_arquivo = $_FILES[$arq]["size"];
    $arquivo_temporario = $_FILES[$arq]["tmp_name"];
    $erro = 0;
    $msg = "";
    $retorno = array();
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


                // Verifica se o arquivo é uma imagem
                          

                    // Cria uma nova imagem a partir do arquivo
                    $imagem = imagecreatefromstring(file_get_contents($caminho));
                    imagealphablending($imagem, true);
                    imagesavealpha($imagem, true);

                    // Redimensiona a imagem original para 1800px de largura ou altura (mantendo proporções)
                    $largura_original = imagesx($imagem);
                    $altura_original = imagesy($imagem);
                    $proporcao_original = $largura_original / $altura_original;

                    $largura_maxima = 1800;
                    $altura_maxima = 1800;

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
                        imagedestroy($imagem);

                        $caminho = $config_upload["caminho_absoluto"] . $nome_final;
                        imagepng($imagem_redimensionada, $caminho);
                        imagedestroy($imagem_redimensionada);
                    }

                    // Cria miniatura de 500px de largura ou altura (mantendo proporções)
                    $largura_maxima_miniatura_500 = 500;
                    $altura_maxima_miniatura_500 = 500;

                    if ($largura_original > $largura_maxima_miniatura_500 || $altura_original > $altura_maxima_miniatura_500) {
                        if ($largura_original > $altura_original) {
                            $nova_largura_miniatura_500 = $largura_maxima_miniatura_500;
                            $nova_altura_miniatura_500 = round($nova_largura_miniatura_500 / $proporcao_original);
                        } else {
                            $nova_altura_miniatura_500 = $altura_maxima_miniatura_500;
                            $nova_largura_miniatura_500 = round($nova_altura_miniatura_500 * $proporcao_original);
                        }

                        $imagem_miniatura_500 = imagecreatetruecolor($nova_largura_miniatura_500, $nova_altura_miniatura_500);
                        imagealphablending($imagem_miniatura_500, false);
                        imagesavealpha($imagem_miniatura_500, true);
                        imagecopyresampled($imagem_miniatura_500, $imagem, 0, 0, 0, 0, $nova_largura_miniatura_500, $nova_altura_miniatura_500, $largura_original, $altura_original);

                        $caminho_miniatura_500 = $config_upload["caminho_absoluto"] . "mini_500_" . $nome_final;
                        imagepng($imagem_miniatura_500, $caminho_miniatura_500);
                        imagedestroy($imagem_miniatura_500);
                    }

                    // Cria miniatura de 150px de largura ou altura (mantendo proporções)
                    $largura_maxima_miniatura_150 = 150;
                    $altura_maxima_miniatura_150 = 150;

                    if ($largura_original > $largura_maxima_miniatura_150 || $altura_original > $altura_maxima_miniatura_150) {
                        if ($largura_original > $altura_original) {
                            $nova_largura_miniatura_150 = $largura_maxima_miniatura_150;
                            $nova_altura_miniatura_150 = round($nova_largura_miniatura_150 / $proporcao_original);
                        } else {
                            $nova_altura_miniatura_150 = $altura_maxima_miniatura_150;
                            $nova_largura_miniatura_150 = round($nova_altura_miniatura_150 * $proporcao_original);
                        }

                        $imagem_miniatura_150 = imagecreatetruecolor($nova_largura_miniatura_150, $nova_altura_miniatura_150);
                        imagealphablending($imagem_miniatura_150, false);
                        imagesavealpha($imagem_miniatura_150, true);
                        imagecopyresampled($imagem_miniatura_150, $imagem, 0, 0, 0, 0, $nova_largura_miniatura_150, $nova_altura_miniatura_150, $largura_original, $altura_original);

                        $caminho_miniatura_150 = $config_upload["caminho_absoluto"] . "mini_150_" . $nome_final;
                        imagepng($imagem_miniatura_150, $caminho_miniatura_150);
                        imagedestroy($imagem_miniatura_150);                    
                }
            } else {
                $msg = "Erro ao fazer o upload ";
                $erro = -1;
            }
        }
    } else {
        $msg = "Arquivo vazio";
        $erro = -1;
    }
    $retorno = (object) array("erro" => $erro, "msg" => $msg, "nome" => $nome_final);
    return $retorno;
}

function uploadImagemGrande($arq, $config_upload)
{
    set_time_limit(0);
    $nome_arquivo = $_FILES[$arq]["name"];
    $arquivo_temporario = $_FILES[$arq]["tmp_name"];
    $erro = 0;
    $msg = "";
    $retorno = array();

    if (!empty($nome_arquivo)) {
        $ext = strrchr($nome_arquivo, ".");
        $nome_final = ($config_upload["renomeia"]) ? uniqid() . $ext : $nome_arquivo;
        $caminho = $config_upload["caminho_absoluto"] . $nome_final;

        if (!($config_upload["verifica_extensao"]) || (in_array(strtolower($ext), $config_upload["extensoes_imagem"]))) {
            if (move_uploaded_file($arquivo_temporario, $caminho)) {
                $msg = "Arquivo enviado com sucesso";
                $erro = 0;

                // Verifica se o arquivo é uma imagem
                if (in_array(exif_imagetype($caminho), $config_upload["extensoes_imagem"])) {
                    // Cria uma nova imagem a partir do arquivo
                    $imagem = imagecreatefromstring(file_get_contents($caminho));
                    imagealphablending($imagem, true);
                    imagesavealpha($imagem, true);

                    // Redimensiona a imagem original para 1800px de largura ou altura (mantendo proporções)
                    $largura_original = imagesx($imagem);
                    $altura_original = imagesy($imagem);
                    $proporcao_original = $largura_original / $altura_original;

                    $largura_maxima = 1800;
                    $altura_maxima = 1800;

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
                        imagedestroy($imagem);

                        $caminho = $config_upload["caminho_absoluto"] . $nome_final;
                        imagepng($imagem_redimensionada, $caminho);
                        imagedestroy($imagem_redimensionada);
                    }
                }
            } else {
                $msg = "Erro ao fazer o upload ";
                $erro = -1;
            }
        } else {
            $msg = "O arquivo não é permitido para upload";
            $erro = -1;
        }
    } else {
        $msg = "Arquivo vazio";
        $erro = -1;
    }
    
    $retorno = (object) array("erro" => $erro, "msg" => $msg, "nome" => $nome_final);
    return $retorno;
}



function deletarImagens($nomeImagem)
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
    } catch (Exception $e) {
        $msg = $e->getMessage();
        $erro = -1;
    }

    $retorno = (object) array("erro" => $erro, "msg" => $msg, "nome" => $nomeImagem);
    return $retorno;
}


function formtfone($telefone, $ddd = null)
{
    $localTraco = -4;
    $ultimos_digitos = substr($telefone, 0, $localTraco);
    $primeiros_digitos = substr($telefone, $localTraco);
    $ultimos_digitos = substr($telefone, 0, $localTraco);
    if ($ddd) {
        $telefone = "(" . $ddd . ")" . $ultimos_digitos . "-" . $primeiros_digitos;
    } else {
        $telefone = $ultimos_digitos . "-" . $primeiros_digitos;
    }
    return $telefone;
}

function getFileDelimiter($file, $checkLines = 2)
{
    $file = new SplFileObject($file);
    $delimiters = array(',', '\t', ';', '|', ':');
    $results = array();
    $i = 0;
    while ($file->valid() && $i <= $checkLines) {
        $line = $file->fgets();
        foreach ($delimiters as $delimiter) {
            $regExp = '/[' . $delimiter . ']/';
            $fields = preg_split($regExp, $line);
            if (count($fields) > 1) {
                if (!empty($results[$delimiter])) {
                    $results[$delimiter]++;
                } else {
                    $results[$delimiter] = 1;
                }
            }
        }
        $i++;
    }
    $results = array_keys($results, max($results));
    return $results[0];
}
