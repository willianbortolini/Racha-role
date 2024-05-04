<style>
    .conta {
        position: relative;
        display: inline-block;
        /* Ajusta ao tamanho da imagem maior */
    }

    .imagem-maior {
        width: 100%;
        /* Ajusta a largura do contêiner */
        display: block;
        /* Remove o espaço abaixo da imagem */
    }

    .imagem-menor {
        display: none;
    }

    .folha {
        width: 250;
        margin: auto;
    }
</style>
<h1>
    <?php echo (isset($usuarios->usuarios_id)) ? 'Editar Usuario' : 'Adicionar Usuario'; ?>
</h1>

<form action="<?php echo URL_BASE . "User/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="row">
        <div class="row">
            <div class="form-group mb-2 col-md-6 col-12">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email"
                    value="<?php echo (isset($usuarios->email)) ? $usuarios->email : ''; ?>" required>
            </div>
            <div class="form-group mb-2 col-md-2 col-12">
                <label for="usuarios_markup">Markup sugerido</label>
                <input type="number" step=0.1 class="form-control" id="usuarios_markup" name="usuarios_markup"
                    value="<?php echo (isset($usuarios->usuarios_markup)) ? $usuarios->usuarios_markup : ''; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group mb-2 col-md-4 col-12">
                <label for="usuario">Usuário</label>
                <input type="text" class="form-control" id="usuario" name="usuario"
                    value="<?php echo (isset($usuarios->usuario)) ? $usuarios->usuario : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-4 col-12">
                <label for="nome_completo">nome completo</label>
                <input type="text" class="form-control" id="nome_completo" name="nome_completo"
                    value="<?php echo (isset($usuarios->nome_completo)) ? $usuarios->nome_completo : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-4 col-12">
                <label for="nome_fantasia">nome fantasia</label>
                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia"
                    value="<?php echo (isset($usuarios->nome_fantasia)) ? $usuarios->nome_fantasia : ''; ?>">
            </div>
        </div>
        <?php if (!isset($usuarios->usuarios_id)) { ?>
            <div class="row">
                <div class="form-group col-md-6 col-12">
                    <label for="senha">senha</label>
                    <input type="text" class="form-control" id="senha" name="senha"
                        value="<?php echo (isset($usuarios->senha)) ? $usuarios->senha : ''; ?>" required>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="form-group mb-2  col-md-6 col-12">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf"
                    value="<?php echo (isset($usuarios->cpf)) ? $usuarios->cpf : ''; ?>">
            </div>

            <div class="form-group mb-2  col-md-6 col-12">
                <label for="cnpj">cnpj</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj"
                    value="<?php echo (isset($usuarios->cnpj)) ? $usuarios->cnpj : ''; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group mb-2  col-md-6 col-12">
                <label for="fone">fone</label>
                <input type="text" class="form-control" id="fone" name="fone"
                    value="<?php echo (isset($usuarios->fone)) ? $usuarios->fone : ''; ?>">
            </div>

            <div class="form-group mb-2  col-md-6 col-12">
                <label for="celular">celular</label>
                <input type="text" class="form-control" id="celular" name="celular"
                    value="<?php echo (isset($usuarios->celular)) ? $usuarios->celular : ''; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group mb-2 col-md-4 col-12">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep"
                    value="<?php echo (isset($usuarios->cep)) ? $usuarios->cep : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-3 col-12">
                <label for="numero">numero</label>
                <input type="number" class="form-control" id="numero" name="numero"
                    value="<?php echo (isset($usuarios->numero)) ? $usuarios->numero : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-5 col-12">
                <label for="rua">rua</label>
                <input type="text" class="form-control" id="rua" name="rua"
                    value="<?php echo (isset($usuarios->rua)) ? $usuarios->rua : ''; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group mb-2 col-md-3 col-12">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado" name="estado">
                    <option value="">Selecione o Estado</option>
                    <option value="AC" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'AC') ? 'selected' : ''; ?>>Acre</option>
                    <option value="AL" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'AL') ? 'selected' : ''; ?>>Alagoas</option>
                    <option value="AP" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'AP') ? 'selected' : ''; ?>>Amapá</option>
                    <option value="AM" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'AM') ? 'selected' : ''; ?>>Amazonas</option>
                    <option value="BA" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'BA') ? 'selected' : ''; ?>>Bahia</option>
                    <option value="CE" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'CE') ? 'selected' : ''; ?>>Ceará</option>
                    <option value="DF" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'DF') ? 'selected' : ''; ?>>Distrito Federal</option>
                    <option value="ES" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'ES') ? 'selected' : ''; ?>>Espírito Santo</option>
                    <option value="GO" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'GO') ? 'selected' : ''; ?>>Goiás</option>
                    <option value="MA" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'MA') ? 'selected' : ''; ?>>Maranhão</option>
                    <option value="MT" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'MT') ? 'selected' : ''; ?>>Mato Grosso</option>
                    <option value="MS" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'MS') ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                    <option value="MG" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'MG') ? 'selected' : ''; ?>>Minas Gerais</option>
                    <option value="PA" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'PA') ? 'selected' : ''; ?>>Pará</option>
                    <option value="PB" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'PB') ? 'selected' : ''; ?>>Paraíba</option>
                    <option value="PR" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'PR') ? 'selected' : ''; ?>>Paraná</option>
                    <option value="PE" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'PE') ? 'selected' : ''; ?>>Pernambuco</option>
                    <option value="PI" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'PI') ? 'selected' : ''; ?>>Piauí</option>
                    <option value="RJ" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro</option>
                    <option value="RN" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'RN') ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                    <option value="RS" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'RS') ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                    <option value="RO" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'RO') ? 'selected' : ''; ?>>Rondônia</option>
                    <option value="RR" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'RR') ? 'selected' : ''; ?>>Roraima</option>
                    <option value="SC" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'SC') ? 'selected' : ''; ?>>Santa Catarina</option>
                    <option value="SP" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'SP') ? 'selected' : ''; ?>>São Paulo</option>
                    <option value="SE" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'SE') ? 'selected' : ''; ?>>Sergipe</option>
                    <option value="TO" <?php echo (isset($usuarios->estado) && $usuarios->estado == 'TO') ? 'selected' : ''; ?>>Tocantins</option>
                </select>
            </div>

            <div class="form-group mb-2 col-md-3 col-12">
                <label for="cidade">cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade"
                    value="<?php echo (isset($usuarios->cidade)) ? $usuarios->cidade : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-3 col-12">
                <label for="complemento">complemento</label>
                <input type="text" class="form-control" id="complemento" name="complemento"
                    value="<?php echo (isset($usuarios->complemento)) ? $usuarios->complemento : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-3 col-12">
                <label for="bairro">bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro"
                    value="<?php echo (isset($usuarios->bairro)) ? $usuarios->bairro : ''; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group mb-2 col-md-6 col-12">
                <label for="ie">ie</label>
                <input type="text" class="form-control" id="ie" name="ie"
                    value="<?php echo (isset($usuarios->ie)) ? $usuarios->ie : ''; ?>">
            </div>

            <div class="form-group mb-2 col-md-6 col-12">
                <label for="rg">rg</label>
                <input type="text" class="form-control" id="rg" name="rg"
                    value="<?php echo (isset($usuarios->rg)) ? $usuarios->rg : ''; ?>">
            </div>
        </div>
        <?php if (isset($_SESSION['he_administrador'])) { ?>

            <div class="form-group mb-2 col-12 col-md-2 ">
                <input type="hidden" name="he_cliente" value="off">
                <input type="checkbox" class="form-check-input" id="he_cliente" value="on" <?php echo (isset($usuarios->he_cliente) && $usuarios->he_cliente == 1) ? 'checked' : ''; ?> name="he_cliente">
                <label for="he_cliente">Cliente</label>
            </div>

            <div class="form-group mb-2 col-12 col-md-2 ">
                <input type="hidden" name="he_colaborador" value="off">
                <input type="checkbox" class="form-check-input" id="he_colaborador" value="on" <?php echo (isset($usuarios->he_colaborador) && $usuarios->he_colaborador == 1) ? 'checked' : ''; ?>
                    name="he_colaborador">
                <label for="he_colaborador">Colaborador</label>
            </div>
            <div class="form-group mb-2 col-12 col-md-2 ">
                <input type="hidden" name="he_fornecedor" value="off">
                <input type="checkbox" class="form-check-input" id="he_fornecedor" value="on" <?php echo (isset($usuarios->he_fornecedor) && $usuarios->he_fornecedor == 1) ? 'checked' : ''; ?>
                    name="he_fornecedor">
                <label for="he_fornecedor">Fornecedor</label>
            </div>
            <div class="form-group mb-2 col-12 col-md-2 ">
                <input type="hidden" name="he_representante" value="off">
                <input type="checkbox" class="form-check-input" id="he_representante" value="on" <?php echo (isset($usuarios->he_representante) && $usuarios->he_representante == 1) ? 'checked' : ''; ?>
                    name="he_representante">
                <label for="he_representante">Representante</label>
            </div>
            <div class="form-group mb-2 col-12 col-md-2 ">
                <input type="hidden" name="he_gerente" value="off">
                <input type="checkbox" class="form-check-input" id="he_gerente" value="on" <?php echo (isset($usuarios->he_gerente) && $usuarios->he_gerente == 1) ? 'checked' : ''; ?> name="he_gerente">
                <label for="he_gerente">Gerente</label>
            </div>
        <?php } ?>


        <input type="hidden" name="usuarios_id"
            value="<?php echo (isset($usuarios->usuarios_id)) ? $usuarios->usuarios_id : NULL; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="row">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
            <div class="col-auto">
                <a href="<?php echo (isset($heMeuPerfil) && ($heMeuPerfil == true)) ? URL_BASE : URL_BASE . "user/representantes"; ?>"
                    class="btn btn-primary">Voltar</a>
            </div>
            <?php if ((isset($usuarios->usuarios_id)) && ((isset($_SESSION['he_representante'])) or (isset($_SESSION['he_administrador'])))) { ?>
                <div class="col-auto">
                    <a href="<?php echo (isset($usuarios->usuarios_id)) ? URL_BASE . "User/editarOrcamento/" . $usuarios->usuarios_id : '' ?>"
                        class="btn btn-primary">Editar Orçamento</a>
                </div>
            <?php } ?>
            <?php if ((isset($usuarios->usuarios_id)) &&  (isset($_SESSION['he_administrador']))) { ?>
                <div class="col-auto">
                    <a href="<?php echo (isset($usuarios->usuarios_id)) ? URL_BASE . "Usuario_acesso/usuario/" . $usuarios->usuarios_id : '' ?>"
                        class="btn btn-primary">Acessos</a>
                </div>
            <?php } ?>
        </div>
    </div>
</form>

<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>