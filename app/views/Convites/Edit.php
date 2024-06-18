
<h1>
    <?php echo (isset($convites->convites_id)) ? 'Editar Convites' : 'Adicionar Convites'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Convites/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="usuario_id">ID do Usuário</label>
        <select class="form-select" aria-label="Default select example" name="usuario_id">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $convites->usuario_id ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="convidado_id">ID do Amigo</label>
        <select class="form-select" aria-label="Default select example" name="convidado_id">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $convites->convidado_id ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" id="email" name="email"
        value="<?php echo (isset($convites->email)) ? $convites->email : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone"
        value="<?php echo (isset($convites->telefone)) ? $convites->telefone : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="status">Status</label>
        <select class="form-select" aria-label="Default select example" name="status">
            <?php foreach ($status as $item) {
                 echo "<option value='$item'". (isset($convites->status) && $item == $convites->status ? "selected" : "") . ">$item</option>";
            } ?>
        </select>
    </div>


    <input type="hidden" name="convites_id" value="<?php echo (isset($convites->convites_id)) ? $convites->convites_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Convites" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

