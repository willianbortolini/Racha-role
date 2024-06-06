
<h1>
    <?php echo (isset($saldos->saldos_id)) ? 'Editar Saldos' : 'Adicionar Saldos'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Saldos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="devedor_id">ID do Devedor</label>
        <select class="form-select" aria-label="Default select example" name="devedor_id">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $saldos->devedor_id ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="credor_id">ID do Credor</label>
        <select class="form-select" aria-label="Default select example" name="credor_id">
            <?php foreach ($users as $item) {
                echo "<option value='$item->users_id'". ($item->users_id == $saldos->credor_id ? "selected" : "") . ">$item->username</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="valor">Valor</label>
        <input type="number" class="form-control" id="valor" name="valor"
        value="<?php echo (isset($saldos->valor)) ? $saldos->valor : ''; ?>" required>
    </div>


    <input type="hidden" name="saldos_id" value="<?php echo (isset($saldos->saldos_id)) ? $saldos->saldos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Saldos" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

