
<h1>
    <?php echo (isset($usuario_acesso->usuario_acesso_id)) ? 'Editar Acessos dos usuarios' : 'Adicionar Acessos dos usuarios'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Usuario_acesso/save" ?>" method="POST" >

    <div class="form-group mb-2">
        <label for="usuarios_id">usuario</label>
        <input type="number" class="form-control" id="usuarios_id" name="usuarios_id"
        value="<?php echo (isset($usuario_acesso->usuarios_id)) ? $usuario_acesso->usuarios_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="acesso">acesso</label>
        <input type="number" class="form-control" id="acesso" name="acesso"
        value="<?php echo (isset($usuario_acesso->acesso)) ? $usuario_acesso->acesso : ''; ?>" required>
    </div>


    <input type="hidden" name="usuario_acesso_id" value="<?php echo (isset($usuario_acesso->usuario_acesso_id)) ? $usuario_acesso->usuario_acesso_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Usuario_acesso" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

