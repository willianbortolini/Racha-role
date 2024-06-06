
<h1>
    <?php echo (isset($despesas->despesas_id)) ? 'Editar Despesas' : 'Adicionar Despesas'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Despesas/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao"
        value="<?php echo (isset($despesas->descricao)) ? $despesas->descricao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="valor">Valor</label>
        <input type="number" class="form-control" id="valor" name="valor"
        value="<?php echo (isset($despesas->valor)) ? $despesas->valor : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="data">Data</label>
        <input type="date" class="form-control" id="data" name="data"
        value="<?php echo (isset($despesas->data)) ? $despesas->data : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="users_id">ID do Usuário</label>
        <select class="form-select" aria-label="Default select example" name="users_id">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $despesas->users_id ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="grupos_id">ID do Grupo</label>
        <select class="form-select" aria-label="Default select example" name="grupos_id">
            <?php foreach ($grupos as $item) {
                echo "<option value='$item->grupos_id'". ($item->grupos_id == $despesas->grupos_id ? "selected" : "") . ">$item->nome</option>";
            } ?>
        </select>
    </div>


    <input type="hidden" name="despesas_id" value="<?php echo (isset($despesas->despesas_id)) ? $despesas->despesas_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Despesas" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

