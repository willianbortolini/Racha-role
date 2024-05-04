<h1>
    Movimentação manual de estoque
</h1>

<form action="<?php echo URL_BASE . "Movimentacao_estoque/saveMovimentacaoManual" ?>" method="POST"
    enctype="multipart/form-data">
    <div class="row">
        <div class="form-group mb-2 col-md-4 col-12">
            <label for="produtos_id">Produto</label>
            <select class="form-select" aria-label="Default select example" name="produtos_id" required>
                <?php foreach ($produtos as $produto) {
                    echo "<option value='$produto->produtos_id'" . ($produto->produtos_id == $movimentacao_estoque->produtos_id ? "selected" : "") . ">$produto->produtos_nome</option>";
                } ?>
            </select>
        </div>

        <div class="form-group mb-2 col-md-1 col-12">
            <label for="quantidade">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" step="0.01"
                value="<?php echo (isset($movimentacao_estoque->quantidade)) ? $movimentacao_estoque->quantidade : ''; ?>"
                required>
        </div>

        <div class="form-group mb-2 col-md-2 col-12">
            <label for="tipo_movimentacao">Tipo de movimentação</label>
            <select class="form-select" aria-label="Default select example" name="tipo_movimentacao" required>
                <option value='<?php echo MOVIMENTACAO_ENTRADA ?>'>Entrada manual</option>
                <option value='<?php echo MOVIMENTACAO_SAIDA ?>'>Saída manual</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group mb-2 col-md-7 col-12">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao"
                value="<?php echo (isset($movimentacao_estoque->descricao)) ? $movimentacao_estoque->descricao : ''; ?>"
                required>
        </div>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </div>
</form>