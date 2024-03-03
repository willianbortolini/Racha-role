
<h1>
    <?php echo (isset($inventario_compartilhado->inventario_compartilhado_id)) ? 'Editar inventario_compartilhado' : 'Adicionar inventario_compartilhado'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Inventario_compartilhado/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="inventario_id">Inventario</label>
        <input type="number" class="form-control" id="inventario_id" name="inventario_id"
        value="<?php echo (isset($inventario_compartilhado->inventario_id)) ? $inventario_compartilhado->inventario_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="usuario_id">usuario</label>
        <input type="number" class="form-control" id="usuario_id" name="usuario_id"
        value="<?php echo (isset($inventario_compartilhado->usuario_id)) ? $inventario_compartilhado->usuario_id : ''; ?>" required>
    </div>


    <input type="hidden" name="inventario_compartilhado_id" value="<?php echo (isset($inventario_compartilhado->inventario_compartilhado_id)) ? $inventario_compartilhado->inventario_compartilhado_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Inventario_compartilhado" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

