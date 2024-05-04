
<h1>
    <?php echo (isset($usuario_tipo->usuario_tipo_id)) ? 'Editar usuario_tipo' : 'Adicionar usuario_tipo'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Usuario_tipo/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="usuarios_id">Usuário</label>
        <input type="number" class="form-control" id="usuarios_id" name="usuarios_id"
        value="<?php echo (isset($usuario_tipo->usuarios_id)) ? $usuario_tipo->usuarios_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="usuario_tipo">tipo usuario</label>
        <input type="number" class="form-control" id="usuario_tipo" name="usuario_tipo"
        value="<?php echo (isset($usuario_tipo->usuario_tipo)) ? $usuario_tipo->usuario_tipo : ''; ?>" required>
    </div>


    <input type="hidden" name="usuario_tipo_id" value="<?php echo (isset($usuario_tipo->usuario_tipo_id)) ? $usuario_tipo->usuario_tipo_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Usuario_tipo" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

