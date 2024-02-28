<?php

namespace app\Commands;

use LDAP\Result;

class GenerateController
{
    public function __construct()
    {

    }

    public function generate($name, $modelName, $tableName, $fields)
    {
        $modelName = lcfirst($modelName);
        $ModelName = ucfirst($modelName);

        // Check if the controller already exists
        /*$controllerFileName = ucfirst($modelName) . 'Controller.php';
        if (file_exists(__DIR__ . '/../../controllers/' . $controllerFileName)) {
            return "Controller '$modelName' already exists.";
        }*/

        // Loop para gerar os inputs HTML dinamicamente e substituir os marcadores no template
        $inputCode = '';
        $showCode = '';
        $salvaImagemService = '';
        $fieldDoController = '';
        $validacaoField = '';
        $excluiImagem = '';
        $temImg = false;
        $titulos = "";
        foreach ($fields as $input) {
            $fieldName = $input['name']; 
            $inputType = $input['type']; 
            $labelText = $input['label'];      
            if ($inputType == 'img'){
                $temImg = true;

                //exclui imagem controller
                $excluiImagem .= "                \$existe_imagem = service::get(\$this->tabela, \$this->campo, \$id);\n";
                $excluiImagem .= "                if (isset(\$existe_imagem->$fieldName) && \$existe_imagem->$fieldName != '') {\n";
                $excluiImagem .= "                    UtilService::deletarImagens(\$existe_imagem->$fieldName);\n";
                $excluiImagem .= "                }\n";

                //salva imagem service
                $salvaImagemService .= "global \$config_upload;\n";
                $salvaImagemService .= "if (\$validacao->qtdeErro() <= 0) {\n";          
                $salvaImagemService .= "        if (isset(\$_POST[\"remove_$fieldName\"]) && \$_POST[\"remove_$fieldName\"] === \"1\") {\n";
                $salvaImagemService .= "            \$existe_imagem = service::get(\$tabela, \$campo, \${{modelName}}->{{tableName}}_id);\n";
                $salvaImagemService .= "            if (isset(\$existe_imagem->$fieldName) && \$existe_imagem->$fieldName != '') {\n";
                $salvaImagemService .= "                UtilService::deletarImagens(\$existe_imagem->$fieldName);\n";
                $salvaImagemService .= "            }\n";
                $salvaImagemService .= "            \${{modelName}}->$fieldName = '';\n";                    
                $salvaImagemService .= "        } else {\n";
                $salvaImagemService .= "            if (isset(\$_FILES[\"$fieldName\"][\"name\"]) && \$_FILES[\"$fieldName\"][\"error\"] === UPLOAD_ERR_OK) {\n";
                $salvaImagemService .= "                \$existe_imagem = service::get(\$tabela, \$campo, \${{modelName}}->{{tableName}}_id);\n";
                $salvaImagemService .= "                if (isset(\$existe_imagem->$fieldName) && \$existe_imagem->$fieldName != '') {\n";
                $salvaImagemService .= "                    UtilService::deletarImagens(\$existe_imagem->$fieldName);\n";
                $salvaImagemService .= "                }\n";
                $salvaImagemService .= "                \${{modelName}}->$fieldName = UtilService::uploadImagem(\"$fieldName\", \$config_upload);\n";        
                $salvaImagemService .= "                if (!\${{modelName}}->$fieldName) {\n";
                $salvaImagemService .= "                    return false;\n";
                $salvaImagemService .= "                }\n";
                $salvaImagemService .= "            }\n";
                $salvaImagemService .= "        }\n";            
                $salvaImagemService .= "}\n";

            }else{
                $fieldDoController .= "                if (isset(\$_POST[\"$fieldName\"]))\n";
                $fieldDoController .= "                   \${{modelName}}->{$fieldName} = \$_POST[\"$fieldName\"];\n";
           
                //validação
                $validacaoField .= "        \$validacao->setData(\"$fieldName\", \${{modelName}}->$fieldName, \"$labelText\");\n";
            }
            // Cria o input conforme o tipo
            
            $titulos .= "                        <th>$labelText</th>\n";

            if ($inputType === 'textarea') {
                $inputCode .= "    <div class=\"form-group mb-2\">\n";
                $inputCode .= "        <label for=\"{$fieldName}\">{$labelText}</label>\n";
                $inputCode .= "        <textarea class=\"form-control\" id=\"{$fieldName}\" name=\"{$fieldName}\" rows=\"5\"\n";
                $inputCode .= "        required><?php echo (isset(\${{tableName}}->{$fieldName})) ? \${{tableName}}->{$fieldName} : ''; ?></textarea>\n";
                $inputCode .= "    </div>\n\n";
                
                $showCode .= "                            <td>\n";
                $showCode .= "                                <?php echo \$item->{$fieldName}; ?>\n";
                $showCode .= "                            </td>\n";
            } elseif ($inputType === 'select') { 
                $inputCode .= "    <div class=\"form-group mb-2\">\n";
                $inputCode .= "        <label for=\"{$fieldName}_id\">{$labelText}</label>\n";
                $inputCode .= "        <select class=\"form-select\" aria-label=\"Default select example\" name=\"{$fieldName}_id\">\n";
                $inputCode .= "            <?php foreach (\${$fieldName} as \$item) {\n";
                $inputCode .= "                echo \"<option value='\$item->{$fieldName}_id'\". (\$item->{$fieldName}_id == \${{tableName}}->{$fieldName}_id ? \"selected\" : \"\") . \">\$item->{$fieldName}_name</option>\";\n";
                $inputCode .= "            } ?>\n";
                $inputCode .= "        </select>\n";
                $inputCode .= "    </div>\n\n"; 
                
                $showCode .= "                            <td>\n";
                $showCode .= "                                <?php echo \$item->{$fieldName}_name; ?>\n";
                $showCode .= "                            </td>\n";
            } elseif ($inputType === 'img') { 
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

                $showCode .= "                            <td>\n";
                $showCode .= "                                <?php if (isset(\$item->{$fieldName})) { ?>\n";
                $showCode .= "                                    <img class=\"img-thumbnail\" width=\"200\" src=\"<?php echo (URL_IMAGEM_150 . \$item->{$fieldName}) ?>\">\n";
                $showCode .= "                                <?php } ?>\n";
                $showCode .= "                            </td>\n";
              
            } else {
                // Para os demais tipos, como text, number, datetime-local, etc.   
                $inputCode .= "    <div class=\"form-group mb-2\">\n";
                $inputCode .= "        <label for=\"{$fieldName}\">{$labelText}</label>\n";
                $inputCode .= "        <input type=\"{$inputType}\" class=\"form-control\" id=\"{$fieldName}\" name=\"{$fieldName}\"\n";
                $inputCode .= "        value=\"<?php echo (isset(\${{tableName}}->{$fieldName})) ? \${{tableName}}->{$fieldName} : ''; ?>\" required>\n";
                $inputCode .= "    </div>\n\n";

                $showCode .= "                            <td>\n";
                $showCode .= "                                <?php echo \$item->{$fieldName}; ?>\n";
                $showCode .= "                            </td>\n";
            }

        }       

        //se algum field é de imagem
        $cssImg = "";
        $jsImg = "";
        if ($temImg) {
            $cssImg = "<style>\n.exclusao-ativa img { opacity: 0.3;} \n</style>";
            $jsImg .= "<script src=\"<?php echo URL_BASE ?>assets/js/inputImg.js\"></script>";
        }       

        //controller
        // Replace placeholders in the controller template with actual values
        $template = file_get_contents(__DIR__ . '/ControllerTemplate.txt');
        $template = str_replace('{{excluiImagem}}', $excluiImagem, $template);
        $template = str_replace('{{fieldDoController}}', $fieldDoController, $template);
        $template = str_replace('{{ModelName}}', $ModelName, $template);
        $template = str_replace('{{modelName}}', $modelName, $template);
        $template = str_replace('{{tableName}}', $tableName, $template);
        // Create the controller file
        $controllerFileName = ucfirst($ModelName) . 'Controller.php';
        file_put_contents(__DIR__ . '/../controllers/' . $controllerFileName, $template);

        //Validacao
        // Replace placeholders in the controller template with actual values
        $template = file_get_contents(__DIR__ . '/ValidacaoTemplate.txt');
        $template = str_replace('{{validacaoField}}', $validacaoField, $template);
        $template = str_replace('{{ModelName}}', $ModelName, $template);
        $template = str_replace('{{modelName}}', $modelName, $template);
        $template = str_replace('{{tableName}}', $tableName, $template);
        // Create the controller file
        $validacaoFileName = ucfirst($ModelName) . 'Validacao.php';
        file_put_contents(__DIR__ . '/../models/validacao/' . $validacaoFileName, $template);    
        
        //Dao
        // Replace placeholders in the controller template with actual values
        $template = file_get_contents(__DIR__ . '/DaoTemplate.txt');
        $template = str_replace('{{ModelName}}', $ModelName, $template);
        // Create the controller file
        $daoFileName = ucfirst($ModelName) . 'Dao.php';
        file_put_contents(__DIR__ . '/../models/dao/' . $daoFileName, $template);  

        //--service
        // Replace placeholders in the service template with actual values 
        $template = file_get_contents(__DIR__ . '/ServiceTemplate.txt');
        $template = str_replace('{{salvaImagemService}}', $salvaImagemService, $template);
        $template = str_replace('{{ModelName}}', $ModelName, $template);
        $template = str_replace('{{modelName}}', $modelName, $template);
        $template = str_replace('{{tableName}}', $tableName, $template);

        // Create the service file
        $serviceFileName = ucfirst($modelName) . 'Service.php';
        file_put_contents(__DIR__ . '/../models/service/' . $serviceFileName, $template);        

        //--views
        // Create the directory for the model views
        $viewsDir = __DIR__ . '/../views/' . $ModelName;
        if (!is_dir($viewsDir)) {
            mkdir($viewsDir);
        }
        // View Edit generation
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
        // View Show generation        
        $viewShow = file_get_contents(__DIR__ . '/ViewShowTemplate.txt');
        $viewShow = str_replace('{{titulos}}', $titulos, $viewShow);
        $viewShow = str_replace('{{td}} ', $showCode, $viewShow);
        $viewShow = str_replace('{{ModelName}}', $ModelName, $viewShow);
        $viewShow = str_replace('{{modelName}}', $modelName, $viewShow);
        $viewShow = str_replace('{{tableName}}', $tableName, $viewShow);        
        $viewShow = str_replace('{{name}}', $name, $viewShow);
        $viewShowPath = $viewsDir . '/Show.php';
        file_put_contents($viewShowPath, $viewShow);

        return $serviceFileName;
    }
}