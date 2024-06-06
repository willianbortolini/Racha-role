<?php
namespace app\Commands;

if ($_SERVER["HTTP_HOST"] !== 'localhost') {
    echo "<h1>Acesso negado</h1>";
    exit;
}


use LDAP\Result;

class GenerateController
{
    public function __construct()
    {
    }


    function generateMigration($tableName, $fields)
    {
        $sql = "CREATE TABLE $tableName (\n";

        $fieldDefinitions = [];
        $joins = [];
        $selectFields = ["t.*"];
        foreach ($fields as $field) {
            if ($field['type'] == 'img') {
                $fieldSql = "    {$field['name']} VARCHAR(255) {$field['attributes']}";
            } else if ($field['type'] == 'enum') {
                $values = "'" . implode("', '", $field['values']) . "'";
                $fieldSql = "    {$field['name']} ENUM($values) {$field['attributes']}";
            } else {
                $fieldSql = "    {$field['name']} {$field['type']} {$field['attributes']}";
            }
            $fieldDefinitions[] = $fieldSql;
        }

        $sql .= implode(",\n", $fieldDefinitions);

        // Adiciona chaves estrangeiras no final da criação da tabela
        $precisaDeView = false;
        foreach ($fields as $field) {
            if (isset($field['foreign'])) {
                $sql .= ",\n    FOREIGN KEY ({$field['name']}) REFERENCES {$field['foreign']['table']}({$field['foreign']['field']})";
                $joins[] = "JOIN {$field['foreign']['table']} f_{$field['name']} ON t.{$field['name']} = f_{$field['name']}.{$field['foreign']['field']}";
                $selectFields[] = "f_{$field['name']}.{$field['foreign']['nome']} AS {$field['name']}_nome";
                $precisaDeView = true;
            }
        }

        $sql .= "\n);";

        file_put_contents(__DIR__ . '/../migrations/' . date('Y_m_d_His') . "_create_{$tableName}_table.sql", $sql);

        if ($precisaDeView) {
            // Adicionar a criação de uma VIEW que traz os valores da tabela estrangeira
            $viewSql = "CREATE VIEW vw_{$tableName} AS\n";
            $viewSql .= "SELECT " . implode(", ", $selectFields) . "\n";
            $viewSql .= "FROM $tableName t\n";
            if (!empty($joins)) {
                $viewSql .= implode("\n", $joins) . "\n";
            }

            file_put_contents(__DIR__ . '/../migrations/' . date('Y_m_d_His') . "_create_vw_{$tableName}_view.sql", $viewSql);
        }
    }

    public function generateControler($modelName, $tableName, $fields)
    {
        $this->generateMigration($tableName, $fields);
        $modelName = lcfirst($modelName);
        $ModelName = ucfirst($modelName);

        // Loop para gerar os inputs HTML dinamicamente e substituir os marcadores no template
        $fieldDoController = '';
        $excluiImagem = '';
        $fieldCreate = '';
        $listaDeColunasDaTabela = '';
        $fieldsRetornoDaLista = '';
        $countColunasDaTabela = 0;
        $chavesEstrangeiras = [];
        foreach ($fields as $input) {
            $fieldName = $input['name'];
            $inputType = $input['type'];

            if ($inputType == 'img') {
                //exclui imagem controller
                $excluiImagem .= "                \$existe_imagem = service::get(\$this->tabela, \$this->campo, \$id);\n";
                $excluiImagem .= "                if (isset(\$existe_imagem->$fieldName) && \$existe_imagem->$fieldName != '') {\n";
                $excluiImagem .= "                    UtilService::deletarImagens(\$existe_imagem->$fieldName);\n";
                $excluiImagem .= "                }\n";
            } else if ((isset($input['generateInput'])) && ($input['generateInput'] == 'check')) {
                $fieldDoController .= "                if (isset(\$_POST['$fieldName']))\n";
                $fieldDoController .= "                     \${{modelName}}->$fieldName = (\$_POST['$fieldName'] == 'on') ? 1 : 0;\n";
            } else {
                if (($input['name'] != 'created_at') && ($input['name'] != 'updated_at') and ($input['name'] != $tableName . '_id')) {
                    $fieldDoController .= "                if (isset(\$_POST[\"$fieldName\"]))\n";
                    $fieldDoController .= "                   \${{modelName}}->{$fieldName} = \$_POST[\"$fieldName\"];\n";
                }
            }

            if ((isset($input['ShowInTable'])) && ($input['ShowInTable'] == true)) {
                $listaDeColunasDaTabela .= "         $countColunasDaTabela => '" . $input['name'] . "',\n";
                if ($inputType == 'img') {
                    $fieldsRetornoDaLista .= '            $registro[] = \'<img src="\' . URL_IMAGEM_150 . $coluna->' . $input['name'] . ' .\'" class="img-thumbnail" alt="Miniatura">\';' . "\n";
                } else {
                    $fieldsRetornoDaLista .= '            $registro[] = $coluna->' . $input['name'] . ';' . "\n";
                }
                $countColunasDaTabela += 1;
            }

            //adiciona os fields do enum para o create e edit
            if ($inputType == 'enum') {
                $fieldCreate .= '        $dados["' . $fieldName . '"] = service::getEnumValues($this->tabela, "' . $fieldName . '");' . "\n";
            }


            // Adiciona chaves estrangeiras no create e edit
            if (isset($input['foreign'])) {
                if (!in_array($input['foreign']['table'], $chavesEstrangeiras)) {
                    $fieldCreate .= '        $dados["' . $input['foreign']['table'] . '"] = service::lista("' . $input['foreign']['table'] . '");' . "\n";
                    $chavesEstrangeiras[] = $input['foreign']['table'];
                }
            }
        }
        $fieldCreate = rtrim($fieldCreate, "\n");
        $listaDeColunasDaTabela = rtrim($listaDeColunasDaTabela, ",\n");
        $fieldsRetornoDaLista = rtrim($fieldsRetornoDaLista, ",\n");

       
        //controller
        // Replace placeholders in the controller template with actual values
        $template = file_get_contents(__DIR__ . '/ControllerTemplate.txt');
        $template = str_replace('{{excluiImagem}}', $excluiImagem, $template);
        $template = str_replace('{{fieldDoController}}', $fieldDoController, $template);
        $template = str_replace('{{fieldCreate}}', $fieldCreate, $template);
        if (count($chavesEstrangeiras) > 0) {
            $template = str_replace('{{constanteView}}', 'private $view = "vw_' . $tableName . '";', $template);
            $template = str_replace('{{tabelaOuView}}', 'view', $template);
        } else {
            $template = str_replace('{{constanteView}}', '', $template);
            $template = str_replace('{{tabelaOuView}}', 'tabela', $template);
        }
        $template = str_replace('{{listaDeColunasDaTabela}}', $listaDeColunasDaTabela, $template);
        $template = str_replace('{{fieldsRetornoDaLista}}', $fieldsRetornoDaLista, $template);
        $template = str_replace('{{ModelName}}', $ModelName, $template);
        $template = str_replace('{{modelName}}', $modelName, $template);
        $template = str_replace('{{tableName}}', $tableName, $template);
        // Create the controller file
        $controllerFileName = ucfirst($ModelName) . 'Controller.php';
        file_put_contents(__DIR__ . '/../controllers/' . $controllerFileName, $template);
    }

    public function generateService($modelName, $tableName, $fields)
    {
        $salvaImagemService = '';
        foreach ($fields as $input) {
            $fieldName = $input['name'];
            $inputType = $input['type'];

            if ($inputType == 'img') {
                //salva imagem service
                $salvaImagemService .= "global \$config_upload;\n";
                $salvaImagemService .= "        if (\$validacao->qtdeErro() <= 0) {\n";
                $salvaImagemService .= "            if (isset(\$_POST[\"remove_$fieldName\"]) && \$_POST[\"remove_$fieldName\"] === \"1\") {\n";
                $salvaImagemService .= "                \$existe_imagem = service::get(self::TABELA, self::CAMPO, \${{modelName}}->{{tableName}}_id);\n";
                $salvaImagemService .= "                if (isset(\$existe_imagem->$fieldName) && \$existe_imagem->$fieldName != '') {\n";
                $salvaImagemService .= "                    UtilService::deletarImagens(\$existe_imagem->$fieldName);\n";
                $salvaImagemService .= "                }\n";
                $salvaImagemService .= "                \${{modelName}}->$fieldName = '';\n";
                $salvaImagemService .= "            } else {\n";
                $salvaImagemService .= "                if (isset(\$_FILES[\"$fieldName\"][\"name\"]) && \$_FILES[\"$fieldName\"][\"error\"] === UPLOAD_ERR_OK) {\n";
                $salvaImagemService .= "                    \$existe_imagem = service::get(self::TABELA, self::CAMPO, \${{modelName}}->{{tableName}}_id);\n";
                $salvaImagemService .= "                    if (isset(\$existe_imagem->$fieldName) && \$existe_imagem->$fieldName != '') {\n";
                $salvaImagemService .= "                      UtilService::deletarImagens(\$existe_imagem->$fieldName);\n";
                $salvaImagemService .= "                    }\n";
                $salvaImagemService .= "                    \${{modelName}}->$fieldName = UtilService::uploadImagem(\"$fieldName\", \$config_upload);\n";
                $salvaImagemService .= "                    if (!\${{modelName}}->$fieldName) {\n";
                $salvaImagemService .= "                        return false;\n";
                $salvaImagemService .= "                    }\n";
                $salvaImagemService .= "                }\n";
                $salvaImagemService .= "            }\n";
                $salvaImagemService .= "        }\n";
            }
        }

        //--service
        // Replace placeholders in the service template with actual values 
        $template = file_get_contents(__DIR__ . '/ServiceTemplate.txt');
        $template = str_replace('{{salvaImagemService}}', $salvaImagemService, $template);
        $template = str_replace('{{ModelName}}', $modelName, $template);
        $template = str_replace('{{modelName}}', $modelName, $template);
        $template = str_replace('{{tableName}}', $tableName, $template);

        // Create the service file
        $serviceFileName = ucfirst($modelName) . 'Service.php';
        file_put_contents(__DIR__ . '/../models/service/' . $serviceFileName, $template);
    }

    public function generateDao($ModelName, $tableName, $fields)
    {
        $fieldsDePesquisa = '';
        $primeiro = false;
        foreach ($fields as $input) {
            if ((isset($input['ShowInTable'])) && ($input['ShowInTable'] == true)) {
                if ($primeiro == false) {
                    $fieldsDePesquisa .= '                $sql .= " AND ( ' . $input['name'] . ' LIKE \'" . $valor_pesquisa . "\' ' . "\n";
                } else {
                    $fieldsDePesquisa .= '                      OR ' . $input['name'] . ' LIKE \'" . $valor_pesquisa . "\' ' . "\n";
                }
                $primeiro = true;
            }
        }
        $fieldsDePesquisa .= '                ) ";';
        $template = file_get_contents(__DIR__ . '/DaoTemplate.txt');
        $template = str_replace('{{ModelName}}', $ModelName, $template);
        $template = str_replace('{{tableName}}', $tableName, $template);
        $template = str_replace('{{fieldsDePesquisa}}', $fieldsDePesquisa, $template);
        $daoFileName = ucfirst($ModelName) . 'Dao.php';
        file_put_contents(__DIR__ . '/../models/dao/' . $daoFileName, $template);
    }

    public function generateValidacao($ModelName, $modelName, $tableName, $fields)
    {
        $validacaoField = '';
        $validacaoParametros = '';
        foreach ($fields as $input) {
            if (isset($input['generateInput'])) {
                if ($input['generateInput'] != 'img') {
                    $validacaoField .= "        \$validacao->setData(\"" . $input['name'] . "\", \${{modelName}}->" . $input['name'] . ", \"" . $input['label'] . "\");\n";
                    $validacaoParametros .= '        $validacao->getData("' . $input['name'] . '")->isVazio();' . "\n";
                }
                if (isset($input['validation']) && ($input['validation'] != '')) {
                    foreach ($input['validation'] as $validacao) {
                        if ($input['generateInput'] != 'img') {
                            $validacaoParametros .= '        $validacao->getData("' . $input['name'] . '")->' . $validacao . ';' . "\n";
                        }

                    }
                }
            }
        }

        $template = file_get_contents(__DIR__ . '/ValidacaoTemplate.txt');
        $template = str_replace('{{validacaoField}}', $validacaoField, $template);
        $template = str_replace('{{validacaoParametros}}', $validacaoParametros, $template);
        $template = str_replace('{{ModelName}}', $ModelName, $template);
        $template = str_replace('{{modelName}}', $modelName, $template);
        $template = str_replace('{{tableName}}', $tableName, $template);
        $validacaoFileName = ucfirst($ModelName) . 'Validacao.php';
        file_put_contents(__DIR__ . '/../models/validacao/' . $validacaoFileName, $template);
    }

    public function generateShow($ModelName, $fields, $viewsDir, $name)
    {
        $titulos = '';
        foreach ($fields as $input) {
            if ((isset($input['ShowInTable'])) && ($input['ShowInTable'] == true)) {
                $titulos .= "                        <th>" . $input['label'] . "</th>\n";
            }
        }

        $viewShow = file_get_contents(__DIR__ . '/ViewShowTemplate.txt');
        $viewShow = str_replace('{{titulos}}', $titulos, $viewShow);
        $viewShow = str_replace('{{ModelName}}', $ModelName, $viewShow);
        $viewShow = str_replace('{{name}}', $name, $viewShow);
        $viewShowPath = $viewsDir . '/Show.php';
        file_put_contents($viewShowPath, $viewShow);
    }

    public function generateEdit($ModelName, $modelName, $tableName, $fields, $viewsDir, $name)
    {
        $inputCode = '';
        $temImg = false;
        $titulos = "";
        foreach ($fields as $input) {
            if ((isset($input['generateInput'])) && ($input['generateInput'] == true)) {
                $fieldName = $input['name'];
                $inputType = $input['generateInput'];
                $labelText = $input['label'];

                $titulos .= "                        <th>$labelText</th>\n";

                if ($inputType === 'textarea') {
                    $inputCode .= "    <div class=\"form-group mb-2\">\n";
                    $inputCode .= "        <label for=\"{$fieldName}\">{$labelText}</label>\n";
                    $inputCode .= "        <textarea class=\"form-control\" id=\"{$fieldName}\" name=\"{$fieldName}\" rows=\"5\"\n";
                    $inputCode .= "        required><?php echo (isset(\${{tableName}}->{$fieldName})) ? \${{tableName}}->{$fieldName} : ''; ?></textarea>\n";
                    $inputCode .= "    </div>\n\n";
                } elseif ($inputType === 'select') {
                    $inputCode .= "    <div class=\"form-group mb-2\">\n";
                    $inputCode .= "        <label for=\"{$fieldName}\">{$labelText}</label>\n";
                    $inputCode .= "        <select class=\"form-select\" aria-label=\"Default select example\" name=\"{$fieldName}\">\n";
                    $inputCode .= "            <?php foreach (\${$input['foreign']['table']} as \$item) {\n";
                    $inputCode .= "                echo \"<option value='\$item->{$input['foreign']['field']}'\". (\$item->{$input['foreign']['field']} == \${{tableName}}->{$fieldName} ? \"selected\" : \"\") . \">\$item->{$input['foreign']['nome']}</option>\";\n";
                    $inputCode .= "            } ?>\n";
                    $inputCode .= "        </select>\n";
                    $inputCode .= "    </div>\n\n";
                } elseif ($inputType === 'check') {
                    $inputCode .= '<div class="form-group mb-2 col-12 col-md-2 ">' . "\n";
                    $inputCode .= '    <input type="hidden" name="' . $fieldName . '" value="off">' . "\n";
                    $inputCode .= '    <input type="checkbox" class="form-check-input" id="' . $fieldName . '" value="on" <?php echo (isset($' . $tableName . '->' . $fieldName . ') && $' . $tableName . '->' . $fieldName . ' == 1) ? "checked" : ""; ?> name="' . $fieldName . '">' . "\n";
                    $inputCode .= '    <label for="' . $fieldName . '">' . $labelText . '</label>' . "\n";
                    $inputCode .= '</div>';
                } elseif ($inputType === 'enum') {
                    $inputCode .= "    <div class=\"form-group mb-2\">\n";
                    $inputCode .= "        <label for=\"{$fieldName}\">{$labelText}</label>\n";
                    $inputCode .= "        <select class=\"form-select\" aria-label=\"Default select example\" name=\"{$fieldName}\">\n";
                    $inputCode .= "            <?php foreach (\${$fieldName} as \$item) {\n";
                    $inputCode .= "                 echo \"<option value='\$item'\". (isset(\${{tableName}}->{$fieldName}) && \$item == \${{tableName}}->{$fieldName} ? \"selected\" : \"\") . \">\$item</option>\";\n";
                    $inputCode .= "            } ?>\n";
                    $inputCode .= "        </select>\n";
                    $inputCode .= "    </div>\n\n";
                } elseif ($inputType === 'img') {
                    $temImg = true;
                    $inputCode .= "    <div class=\"row\">\n";
                    $inputCode .= "        <div class=\"form-group col-lg-6 col-12 mb-2\">\n";
                    $inputCode .= "           <?php if (isset(\${{tableName}}->{$fieldName}) && \${{tableName}}->{$fieldName} != '') { ?>\n";
                    $inputCode .= "                <label class=\"container-imagem\" for=\"{$fieldName}\">\n";
                    $inputCode .= "                    <img id=\"preview\"  width=\"250\" height=\"250\"\n";
                    $inputCode .= "                        src=\"<?php echo (isset(\${{tableName}}->{$fieldName})) ? (URL_IMAGEM . \${{tableName}}->{$fieldName}) : ''; ?>\">\n";
                    $inputCode .= "                </label>\n";
                    $inputCode .= "                <div class=\"image-buttons mt-1 mb-1\">\n";
                    $inputCode .= "                   <button type=\"button\" class=\"btn btn-primary btn-edit\" data-target=\"{$fieldName}\">Editar</button>\n";
                    $inputCode .= "                   <button type=\"button\" class=\"btn btn-danger btn-delete ms-2\" data-target=\"remove_{$fieldName}\">Excluir</button>\n";
                    $inputCode .= "                   <input type=\"checkbox\" class=\"form-check-input visually-hidden\" id=\"remove_{$fieldName}\" name=\"remove_{$fieldName}\"\n";
                    $inputCode .= "                       value=\"1\">\n";
                    $inputCode .= "                </div>\n";
                    $inputCode .= "            <?php } else { ?>\n";
                    $inputCode .= "                <label class=\"container-imagem\" for=\"{$fieldName}\">\n";
                    $inputCode .= "                    <svg class=\"bd-placeholder-img \" width=\"250\" height=\"250\" role=\"img\" focusable=\"false\">\n";
                    $inputCode .= "                        <rect width=\"100%\" height=\"100%\" fill=\"#868e96\"></rect>\n";
                    $inputCode .= "                        <text x=\"10%\" y=\"50%\" fill=\"#dee2e6\" dy=\".3em\">Carregue uma imagem</text>\n";
                    $inputCode .= "                    </svg>\n";
                    $inputCode .= "                </label>\n";
                    $inputCode .= "            <?php } ?>\n";
                    $inputCode .= "            <input type=\"file\" class=\"form-control-file visually-hidden\" id=\"{$fieldName}\" name=\"{$fieldName}\">\n";
                    $inputCode .= "        </div>\n";
                    $inputCode .= "    </div>\n\n";
                } else {
                    // Para os demais tipos, como text, number, datetime-local, etc.   
                    $inputCode .= "    <div class=\"form-group mb-2\">\n";
                    $inputCode .= "        <label for=\"{$fieldName}\">{$labelText}</label>\n";
                    $inputCode .= "        <input type=\"{$inputType}\" class=\"form-control\" id=\"{$fieldName}\" name=\"{$fieldName}\"\n";
                    $inputCode .= "        value=\"<?php echo (isset(\${{tableName}}->{$fieldName})) ? \${{tableName}}->{$fieldName} : ''; ?>\" required>\n";
                    $inputCode .= "    </div>\n\n";
                }
            }
        }

        //se algum field é de imagem
        $cssImg = "";
        $jsImg = "";
        if ($temImg) {
            $cssImg = "<style>\n.exclusao-ativa img { opacity: 0.3;} \n</style>";
            $jsImg .= "<script src=\"<?php echo URL_BASE ?>assets/js/inputImg.js\"></script>";
        }

        $viewEdit = file_get_contents(__DIR__ . '/ViewEditTemplate.txt');
        $viewEdit = str_replace('{{cssImg}}', $cssImg, $viewEdit);
        $viewEdit = str_replace('{{jsImg}}', $jsImg, $viewEdit);
        $viewEdit = str_replace('{{field}}', $inputCode, $viewEdit);
        $viewEdit = str_replace('{{ModelName}}', $ModelName, $viewEdit);
        $viewEdit = str_replace('{{modelName}}', $modelName, $viewEdit);
        $viewEdit = str_replace('{{tableName}}', $tableName, $viewEdit);
        $viewEdit = str_replace('{{name}}', $name, $viewEdit);

        $viewEditPath = $viewsDir . '/Edit.php';
        file_put_contents($viewEditPath, $viewEdit);
    }

    public function generate($params)
    {
        $name = $params['name'];
        $tableName = $params['tableName'];
        $fields = $params['fields'];
        $modelName = lcfirst($tableName);
        $ModelName = ucfirst($tableName);

        $this->generateMigration($tableName, $fields);
        $this->generateControler($ModelName, $tableName, $fields);
        $this->generateService($ModelName, $tableName, $fields);
        $this->generateDao($ModelName, $tableName, $fields);
        $this->generateValidacao($ModelName, $modelName, $tableName, $fields);

        // Create the directory for the model views
        $viewsDir = __DIR__ . '/../views/' . $ModelName;
        if (!is_dir($viewsDir)) {
            mkdir($viewsDir);
        }
        $this->generateShow($ModelName, $fields, $viewsDir, $name);
        $this->generateEdit($ModelName, $modelName, $tableName, $fields, $viewsDir, $name);
        echo 'fim';
    }
}
