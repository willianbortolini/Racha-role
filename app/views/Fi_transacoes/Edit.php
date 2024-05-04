<style>
    .hidden {
        display: none;
    }

    .custom-radio {
        display: block;
        width: 100%;
        margin-bottom: 10px;
    }

    .custom-radio input {
        display: none;
    }

    .custom-radio label {
        display: block;
        width: 100%;
        padding: 15px;
        text-align: center;
        color: #fff;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
        background-color: #7f8c8d;
        /* Cor cinza padrão quando não selecionado */
    }

    #entrada:checked+label {
        background-color: #2ecc71;
        /* Verde quando selecionado */
    }

    #saida:checked+label {
        background-color: #e74c3c;
        /* Vermelho quando selecionado */
    }
</style>

<form action="<?php echo URL_BASE . "Fi_transacoes/save" ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-6">
            <div class="custom-radio">
                <input class="form-check-input" type="radio" name="tipo" id="saida" value="1" <?php echo ((!isset($fi_transacoes->tipo)) ? "checked" : "") .
                (((isset($fi_transacoes->tipo)) and ($fi_transacoes->tipo == 1)) ? "checked" : "") ?>>
                <label class="form-check-label" for="saida">Saída</label>
            </div>
        </div>
        <div class="col-6">
            <div class="custom-radio">
                <input class="form-check-input" type="radio" name="tipo" id="entrada" value="0" <?php echo (((isset($fi_transacoes->tipo)) and ($fi_transacoes->tipo == 0)) ? "checked" : "") ?>>
                <label class="form-check-label" for="entrada">Entrada</label>
            </div>
        </div>

    </div>

    <div class="form-group mb-2">
        <label for="valor">Valor</label>
        <input type="number" class="form-control" id="valor" name="valor"
            value="<?php echo (isset($fi_transacoes->valor)) ? $fi_transacoes->valor : ''; ?>" required step="0.01">
    </div>    

    <div class="form-group mb-2">
        <label for="fi_categorias_id">Categoria</label>
        <select class="form-select" aria-label="Default select example" name="fi_categorias_id">
            <?php foreach ($fi_categorias as $item) {
                echo "<option value='$item->fi_categorias_id'" . ($item->fi_categorias_id == $fi_transacoes->fi_categorias_id ? "selected" : "") . ">$item->fi_categorias_nome</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">

        <input type="checkbox" id="custo_fixo" name="custo_fixo" <?php echo (isset($fi_transacoes->custo_fixo) && $fi_transacoes->custo_fixo == 1) ? 'checked' : ''; ?>>
        <label for="custo_fixo">Custo Fixo</label>
    </div>

    <div class="form-group mb-2">
        <label for="data">Data</label>
        <input type="date" class="form-control" id="data" name="data"
            value="<?php echo (isset($fi_transacoes->data)) ? $fi_transacoes->data : date('Y-m-d'); ?>" required>
    </div>

    <div class="form-group mb-2 hidden">
        <label for="data_pagamento">data pagamento</label>
        <input type="date" class="form-control" id="data_pagamento" name="data_pagamento"
            value="<?php echo (isset($fi_transacoes->data_pagamento)) ? $fi_transacoes->data_pagamento : date('Y-m-d'); ?>"
            required>
    </div>

    <div class="form-group mb-2">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao"
            value="<?php echo (isset($fi_transacoes->descricao)) ? $fi_transacoes->descricao : ''; ?>">
    </div>

    <div class="form-group mb-2 hidden">
        <label for="numero_parcelas">numero parcelas</label>
        <input type="number" class="form-control" id="numero_parcelas" name="numero_parcelas"
            value="<?php echo (isset($fi_transacoes->numero_parcelas)) ? $fi_transacoes->numero_parcelas : ''; ?>">
    </div>

    <div class="form-group mb-2 hidden">
        <label for="parcela_atual">parcela atual</label>
        <input type="number" class="form-control" id="parcela_atual" name="parcela_atual"
            value="<?php echo (isset($fi_transacoes->parcela_atual)) ? $fi_transacoes->parcela_atual : ''; ?>">
    </div>

    <div class="form-group mb-2">
        <label for="fi_conta_id">Conta</label>
        <select class="form-select" aria-label="Default select example" name="fi_conta_id">
            <?php foreach ($fi_conta as $item) {
                echo "<option value='$item->fi_conta_id'" . ($item->fi_conta_id == $fi_transacoes->fi_conta_id ? "selected" : "") . ">$item->fi_conta_nome</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2 hidden">
        <label for="fi_meio_id">Meio</label>
        <select class="form-select" aria-label="Default select example" name="fi_meio_id">
            <?php foreach ($fi_meio as $item) {
                echo "<option value='$item->fi_meio_id'" . ($item->fi_meio_id == $fi_transacoes->fi_meio_id ? "selected" : "") . ">$item->fi_meio_nome</option>";
            } ?>
        </select>
    </div>


    <?php if (isset($fi_transacoes->usuarios_id)) { ?>
        <input type="hidden" name="usuarios_id"
            value="<?php echo (isset($fi_transacoes->usuarios_id)) ? $fi_transacoes->usuarios_id : ''; ?>">
    <?php } ?>
    <input type="hidden" name="fi_transacoes_id"
        value="<?php echo (isset($fi_transacoes->fi_transacoes_id)) ? $fi_transacoes->fi_transacoes_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Fi_transacoes" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>