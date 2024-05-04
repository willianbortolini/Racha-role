
<h1>
    <?php echo (isset($tabela_preco_item->tabela_preco_item_id)) ? 'Editar Tabela preco item' : 'Adicionar Tabela preco item'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Tabela_preco_item/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="tabela_preco_id">Tabela Preço</label>
        <input type="number" class="form-control" id="tabela_preco_id" name="tabela_preco_id"
        value="<?php echo (isset($tabela_preco_item->tabela_preco_id)) ? $tabela_preco_item->tabela_preco_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="largura">Largura</label>
        <input type="number" class="form-control" id="largura" name="largura"
        value="<?php echo (isset($tabela_preco_item->largura)) ? $tabela_preco_item->largura : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="altura">Altura</label>
        <input type="number" class="form-control" id="altura" name="altura"
        value="<?php echo (isset($tabela_preco_item->altura)) ? $tabela_preco_item->altura : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="valor">Valor</label>
        <input type="number" class="form-control" id="valor" name="valor" step="0.01"
        value="<?php echo (isset($tabela_preco_item->valor)) ? $tabela_preco_item->valor : ''; ?>" required>
    </div>


    <input type="hidden" name="tabela_preco_item_id" value="<?php echo (isset($tabela_preco_item->tabela_preco_item_id)) ? $tabela_preco_item->tabela_preco_item_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Tabela_preco_item" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

