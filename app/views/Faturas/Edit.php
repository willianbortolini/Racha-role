<h1>
    <?php echo (isset($fi_faturas->fi_faturas_id)) ? 'Editar Faturas' : 'Adicionar Faturas'; ?>
</h1>

<form action="<?php echo URL_BASE . "Faturas/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2 col-md-6 col-12">
        <label for=" fornecedor">Usuários</label>
        <select class="form-select" aria-label="Default select example" name=" fornecedor" id=" fornecedor">
            <?php foreach ($fornecedores as $item) {
                echo "<option usaTabelaPreco= '$item->produtos_usaTabelaPreco' value='$item->usuarios_id'" . ($item->usuarios_id == $fi_faturas->usuarios_id ? "selected" : "") . ">$item->usuario</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2 col-md-6 col-12">
        <label for="data_emissao">Data emissão</label>
        <input type="date" class="form-control" id="data_emissao" name="data_emissao"
            value="<?php echo (isset($fi_faturas->data_emissao)) ? $fi_faturas->data_emissao : ''; ?>" required>
    </div>

    <div class="form-group mb-2 col-md-6 col-12">
        <label for="data_vencimento">Data vencimento</label>
        <input type="date" class="form-control" id="data_vencimento" name="data_vencimento"
            value="<?php echo (isset($fi_faturas->data_vencimento)) ? $fi_faturas->data_vencimento : ''; ?>" required>
    </div>

    <div class="form-group mb-2 col-md-6 col-12">
        <label for="valor_total">Valor total</label>
        <input type="number" class="form-control" id="valor_total" name="valor_total" step=""
            value="<?php echo (isset($fi_faturas->valor_total)) ? $fi_faturas->valor_total : ''; ?>" required>
    </div>

    <div class="form-group mb-2 col-md-6 col-12">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao"
            value="<?php echo (isset($fi_faturas->descricao)) ? $fi_faturas->descricao : ''; ?>" required>
    </div>    

    <input type="hidden" name="fi_faturas_id"
        value="<?php echo (isset($fi_faturas->fi_faturas_id)) ? $fi_faturas->fi_faturas_id : NULL; ?>">
    <input type="hidden" name="empresa" value="<?php echo $_SESSION['id']; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Faturas" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>