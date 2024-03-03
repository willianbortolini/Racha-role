<h1>
    <?php echo (isset($inventario_item->inventario_item_id)) ? 'Editar inventario_item' : 'Adicionar inventario_item'; ?>
</h1>

<form action="<?php echo URL_BASE . "Inventario_item/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="ean13">EAN-13</label>
        <input type="TEXT" class="form-control" id="ean13" name="ean13"
            value="<?php echo (isset($inventario_item->ean13)) ? $inventario_item->ean13 : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="quantidade">Quantidade</label>
        <input type="number" class="form-control" id="quantidade" name="quantidade"
            value="<?php echo (isset($inventario_item->quantidade)) ? $inventario_item->quantidade : ''; ?>" >
    </div>

    <div class="form-group mb-2">
        <label for="rua">Rua</label>
        <input type="number" class="form-control" id="rua" name="rua"
            value="<?php echo (isset($inventario_item->rua)) ? $inventario_item->rua : ''; ?>" >
    </div>

    <div class="form-group mb-2">
        <label for="coluna">Coluna</label>
        <input type="number" class="form-control" id="coluna" name="coluna"
            value="<?php echo (isset($inventario_item->coluna)) ? $inventario_item->coluna : ''; ?>" >
    </div>

    <div class="form-group mb-2">
        <label for="nivel">Nivel</label>
        <input type="number" class="form-control" id="nivel" name="nivel"
            value="<?php echo (isset($inventario_item->nivel)) ? $inventario_item->nivel : ''; ?>" >
    </div>    

    <input type="hidden" name="inventario_id"
        value="<?php echo (isset($inventario_item->inventario_id)) ? $inventario_item->inventario_id : $inventario; ?>">
    <input type="hidden" name="inventario_item_id"
        value="<?php echo (isset($inventario_item->inventario_item_id)) ? $inventario_item->inventario_item_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Inventario_item/index/" . ((isset($inventario_item->inventario_id)) ? $inventario_item->inventario_id : $inventario)?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>