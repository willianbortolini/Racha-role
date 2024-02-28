<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <!-- Incluindo o Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .formulario-container {
            margin-top: 50px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="ml-1 mr-2">
        <?php
        $this->verMsg();
        $this->verErro();
        ?>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 formulario-container">
                <h2 class="text-center mb-4">Cadastro de Usuário</h2>

                <form action="<?PHP echo URL_BASE . 'usuario/salvar' ?>" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo (isset($usuarios->email)) ? $usuarios->email : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha"  required>
                    </div>

                    <div class="form-group">
                        <label for="confirmacao">Confirmação de Senha:</label>
                        <input type="password" class="form-control" id="confirmacao" name="confirmacao"  required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="politica" name="politica" checked required>
                        <label class="form-check-label" for="politica">Aceito as <a
                                href="<?PHP echo URL_BASE . 'politicaprivacidade' ?>" target="_blank">políticas de
                                privacidade</a>.</label>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="cookies" name="cookies" checked required>
                        <label class="form-check-label" for="cookies">Concordo com o uso de cookies para personalizar
                            minha experiência.</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluindo o Bootstrap JS e jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>