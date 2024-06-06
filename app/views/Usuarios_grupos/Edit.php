
<h1>
    <?php echo (isset($usuarios_grupos->usuarios_grupos_id)) ? 'Editar Usuários Grupos' : 'Adicionar Usuários Grupos'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Usuarios_grupos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="users_id">ID do Usuário</label>
        <select class="form-select" aria-label="Default select example" name="users_id">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $usuarios_grupos->users_id ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="grupos_id">ID do Grupo</label>
        <select class="form-select" aria-label="Default select example" name="grupos_id">
            <?php foreach ($grupos as $item) {
                echo "<option value='$item->grupos_id'". ($item->grupos_id == $usuarios_grupos->grupos_id ? "selected" : "") . ">$item->nome</option>";
            } ?>
        </select>
    </div>


    <input type="hidden" name="usuarios_grupos_id" value="<?php echo (isset($usuarios_grupos->usuarios_grupos_id)) ? $usuarios_grupos->usuarios_grupos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Usuarios_grupos" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

