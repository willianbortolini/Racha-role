
<h1>
    <?php echo (isset($participantes_despesas->participantes_despesas_id)) ? 'Editar Participantes Despesas' : 'Adicionar Participantes Despesas'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Participantes_despesas/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="despesas_id">ID da Despesa</label>
        <select class="form-select" aria-label="Default select example" name="despesas_id">
            <?php foreach ($despesas as $item) {
                echo "<option value='$item->despesas_id'". ($item->despesas_id == $participantes_despesas->despesas_id ? "selected" : "") . ">$item->descricao</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="users_id">ID do Usuário</label>
        <select class="form-select" aria-label="Default select example" name="users_id">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $participantes_despesas->users_id ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="valor">Valor</label>
        <input type="number" class="form-control" id="valor" name="valor"
        value="<?php echo (isset($participantes_despesas->valor)) ? $participantes_despesas->valor : ''; ?>" required>
    </div>


    <input type="hidden" name="participantes_despesas_id" value="<?php echo (isset($participantes_despesas->participantes_despesas_id)) ? $participantes_despesas->participantes_despesas_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Participantes_despesas" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

