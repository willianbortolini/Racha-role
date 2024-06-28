
<h1>
    <?php echo (isset($pagamentos->pagamentos_id)) ? 'Editar Pagamentos' : 'Adicionar Pagamentos'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Pagamentos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="pagador">ID do pagador</label>
        <select class="form-select" aria-label="Default select example" name="pagador">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $pagamentos->pagador ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="recebedor">ID do recebedor</label>
        <select class="form-select" aria-label="Default select example" name="recebedor">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $pagamentos->recebedor ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="valor">Valor</label>
        <input type="number" class="form-control" id="valor" name="valor"
        value="<?php echo (isset($pagamentos->valor)) ? $pagamentos->valor : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="data">Data</label>
        <input type="date" class="form-control" id="data" name="data"
        value="<?php echo (isset($pagamentos->data)) ? $pagamentos->data : ''; ?>" required>
    </div>


    <input type="hidden" name="pagamentos_id" value="<?php echo (isset($pagamentos->pagamentos_id)) ? $pagamentos->pagamentos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Pagamentos" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

