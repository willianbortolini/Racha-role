<?php if ($_SERVER["HTTP_HOST"] !== 'localhost') {
    echo "<h1>Acesso negado</h1>";
    exit;
}?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cria CRUD</title>
    <!-- Adicione o Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Cria crud</h1>
        <form id="generateForm" action="process_form.php" method="post">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nome:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="tableName" class="col-sm-2 col-form-label">Nome da tabela:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="tableName" name="tableName" required>
                </div>
            </div>
            <fieldset class="border p-2 mt-4">
                <div id="fields">
                <h2>Campo 1</h2>
                    <div class="field-group">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fieldName1">Nome do campo na tabela:</label>
                                <input type="text" class="form-control" name="fields[0][name]" id="fieldName1" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="fieldType1">Tipo do campo na tabela:</label>
                                <input placeholder="ENUM['ligado','desligado'], VARCHAR(255), DECIMAL(12,4), FLOAT, TEXT" title="ENUM['ligado','desligado'], VARCHAR(255), DECIMAL(12,4), FLOAT, TEXT" type="text" class="form-control" name="fields[0][type]" id="fieldType1" required>
                            </div>


                            <div class="form-group col-md-4">
                                <label for="fieldAttributes1">Atributos:</label>
                                <input placeholder="NOT NULL DEFAULT 'desligado', DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,AUTO_INCREMENT PRIMARY KEY" title="NOT NULL DEFAULT 'desligado', DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,AUTO_INCREMENT PRIMARY KEY" type="text" class="form-control" name="fields[0][attributes]" id="fieldAttributes1" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fieldLabel1">Texto que representa o campo:</label>
                                <input type="text" class="form-control" name="fields[0][label]" id="fieldLabel1" required>
                            </div>


                            <div class="form-group col-md-2 mt-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="fields[0][ShowInTable]" id="fieldShowInTable1" value="true" required>
                                    <label class="form-check-label" for="fieldShowInTable1">Mostra na tabela?</label>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="generateInput1">Tipo do input no editar:</label>
                                <select class="form-control" name="fields[0][generateInput]" id="generateInput1" required>
                                    <option value=""></option>
                                    <option value="text">text</option>
                                    <option value="img">img</option>
                                    <option value="select">select</option>
                                    <option value="textArea">textArea</option>
                                    <option value="enum">enum</option>
                                </select>
                            </div>

                            <div class="form-group col-md-5">
                                <label for="fieldvalidation1">Validações extras:</label>
                                <input placeholder="['isMinimo(5)', 'isCPF()', 'isCNPJ()', 'isUnico()', 'isSenhaValida()', 'isEmail()', 'isData()', 'isMaximo(10)', 'isNumero()']" title="['isMinimo(5)', 'isCPF()', 'isCNPJ()', 'isUnico()', 'isSenhaValida()', 'isEmail()', 'isData()', 'isMaximo(10)', 'isNumero()']" type="text" class="form-control" name="fields[0][validation]" id="fieldvalidation1">
                            </div>
                        </div>
                        <fieldset class="border p-2 row m-2 mt-3">
                            <legend class="w-auto">Chave estrangeira</legend>
                            <div class="form-group col-md-3">
                                <label for="fieldForeignTable1">Tabela</label>
                                <input type="text" class="form-control" name="fields[0][foreign][table]" id="fieldForeignTable1" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fieldForeignField1">Coluna id</label>
                                <input type="text" class="form-control" name="fields[0][foreign][field]" id="fieldForeignField1" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="fieldForeignNome1">Coluna Nome</label>
                                <input type="text" class="form-control" name="fields[0][foreign][nome]" id="fieldForeignNome1" required>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-3" onclick="addField()">Adicionar campo</button>
            </fieldset><br>
            <button type="submit" class="btn btn-success">Executar</button>
        </form>
    </div>

    <!-- Adicione o Bootstrap JavaScript (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let fieldCount = 1;

        function addField() {
            fieldCount++;
            const fieldGroup = document.createElement('div');
            fieldGroup.className = 'field-group mt-4';
            fieldGroup.innerHTML = `
            <h2>Campo ${fieldCount}</h2>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="fieldName${fieldCount}">Nome do campo na tabela:</label>
                <input type="text" class="form-control" name="fields[${fieldCount - 1}][name]" id="fieldName${fieldCount}" required>
            </div>
            <div class="form-group col-md-4">
                <label for="fieldType${fieldCount}">Tipo do campo na tabela:</label>
                <input placeholder="ENUM['ligado','desligado'], VARCHAR(255), DECIMAL(12,4), FLOAT, TEXT" title="ENUM['ligado','desligado'], VARCHAR(255), DECIMAL(12,4), FLOAT, TEXT" type="text" class="form-control" name="fields[${fieldCount - 1}][type]" id="fieldType${fieldCount}" required>
            </div>
            <div class="form-group col-md-4">
                <label for="fieldAttributes${fieldCount}">Atributos:</label>
                <input placeholder="NOT NULL DEFAULT 'desligado', DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,AUTO_INCREMENT PRIMARY KEY" title="NOT NULL DEFAULT 'desligado', DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,AUTO_INCREMENT PRIMARY KEY" type="text" class="form-control" name="fields[${fieldCount - 1}][attributes]" id="fieldAttributes${fieldCount}" required>
            </div>
            <div class="form-group col-md-3">
                <label for="fieldLabel${fieldCount}">Texto que representa o campo:</label>
                <input type="text" class="form-control" name="fields[${fieldCount - 1}][label]" id="fieldLabel${fieldCount}" required>
            </div>
            <div class="form-group col-md-2 mt-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="fields[${fieldCount - 1}][ShowInTable]" id="fieldShowInTable${fieldCount}" value="true" required>
                    <label class="form-check-label" for="fieldShowInTable${fieldCount}">Mostra na tabela?</label>
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="generateInput${fieldCount}">Tipo do input no editar:</label>
                <select class="form-control" name="fields[${fieldCount - 1}][generateInput]" id="generateInput${fieldCount}" required>
                    <option value=""></option>
                    <option value="text">text</option>
                    <option value="img">img</option>
                    <option value="select">select</option>
                    <option value="textArea">textArea</option>
                    <option value="enum">enum</option>
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="fieldvalidation${fieldCount}">Validações extras:</label>
                <input placeholder="['isMinimo(5)', 'isCPF()', 'isCNPJ()', 'isUnico()', 'isSenhaValida()', 'isEmail()', 'isData()', 'isMaximo(10)', 'isNumero()']"
                       title="['isMinimo(5)', 'isCPF()', 'isCNPJ()', 'isUnico()', 'isSenhaValida()', 'isEmail()', 'isData()', 'isMaximo(10)', 'isNumero()']"
                       type="text" class="form-control" name="fields[${fieldCount - 1}][validation]" id="fieldvalidation${fieldCount}">
            </div>
        </div>
        <fieldset class="border p-2 row m-2 mt-3">
            <legend class="w-auto">Chave estrangeira</legend>
            <div class="form-group col-md-3">
                <label for="fieldForeignTable${fieldCount}">Tabela</label>
                <input type="text" class="form-control" name="fields[${fieldCount - 1}][foreign][table]" id="fieldForeignTable${fieldCount}" required>
            </div>
            <div class="form-group col-md-3">
                <label for="fieldForeignField${fieldCount}">Coluna id</label>
                <input type="text" class="form-control" name="fields[${fieldCount - 1}][foreign][field]" id="fieldForeignField${fieldCount}" required>
            </div>
            <div class="form-group col-md-3">
                <label for="fieldForeignNome${fieldCount}">Coluna Nome</label>
                <input type="text" class="form-control" name="fields[${fieldCount - 1}][foreign][nome]" id="fieldForeignNome${fieldCount}" required>
            </div>
        </fieldset>
    `;
            document.getElementById('fields').appendChild(fieldGroup);
        }
    </script>
</body>

</html>