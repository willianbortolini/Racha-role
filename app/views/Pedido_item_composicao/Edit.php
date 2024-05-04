
<h1>
    <?php echo (isset($pedido_item_composicao->pedido_item_composicao_id)) ? 'Editar Pedido item composição' : 'Adicionar Pedido item composição'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Pedido_item_composicao/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="pedido_item_id">pedido_item_id</label>
        <input type="number" class="form-control" id="pedido_item_id" name="pedido_item_id"
        value="<?php echo (isset($pedido_item_composicao->pedido_item_id)) ? $pedido_item_composicao->pedido_item_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="composicao_id">composicao_id</label>
        <input type="number" class="form-control" id="composicao_id" name="composicao_id"
        value="<?php echo (isset($pedido_item_composicao->composicao_id)) ? $pedido_item_composicao->composicao_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="pedido_item_composicao_valor">valor no select</label>
        <input type="number" class="form-control" id="pedido_item_composicao_valor" name="pedido_item_composicao_valor"
        value="<?php echo (isset($pedido_item_composicao->pedido_item_composicao_valor)) ? $pedido_item_composicao->pedido_item_composicao_valor : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="pedido_item_composicao_valorMonetario ">valor financeiro</label>
        <input type="number" class="form-control" id="pedido_item_composicao_valorMonetario " name="pedido_item_composicao_valorMonetario "
        value="<?php echo (isset($pedido_item_composicao->pedido_item_composicao_valorMonetario )) ? $pedido_item_composicao->pedido_item_composicao_valorMonetario  : ''; ?>" required>
    </div>


    <input type="hidden" name="pedido_item_composicao_id" value="<?php echo (isset($pedido_item_composicao->pedido_item_composicao_id)) ? $pedido_item_composicao->pedido_item_composicao_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Pedido_item_composicao" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

