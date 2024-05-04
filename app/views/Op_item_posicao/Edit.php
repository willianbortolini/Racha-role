
<h1>
    <?php echo (isset($op_item_posicao->op_item_posicao_id)) ? 'Editar op item posicao' : 'Adicionar op item posicao'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Op_item_posicao/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="posicao_op_id">posicao op id</label>
        <input type="number" class="form-control" id="posicao_op_id" name="posicao_op_id"
        value="<?php echo (isset($op_item_posicao->posicao_op_id)) ? $op_item_posicao->posicao_op_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="ordem_producao_item_id">ordem_producao item id</label>
        <input type="number" class="form-control" id="ordem_producao_item_id" name="ordem_producao_item_id"
        value="<?php echo (isset($op_item_posicao->ordem_producao_item_id)) ? $op_item_posicao->ordem_producao_item_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="conteudo_op_item">conteudo op item</label>
        <input type="text" class="form-control" id="conteudo_op_item" name="conteudo_op_item"
        value="<?php echo (isset($op_item_posicao->conteudo_op_item)) ? $op_item_posicao->conteudo_op_item : ''; ?>" required>
    </div>


    <input type="hidden" name="op_item_posicao_id" value="<?php echo (isset($op_item_posicao->op_item_posicao_id)) ? $op_item_posicao->op_item_posicao_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Op_item_posicao" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

