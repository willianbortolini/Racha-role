
<h1>
    <?php echo (isset($ordem_producao->ordem_producao_id)) ? 'Editar Ordem de producao' : 'Adicionar Ordem de producao'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Ordem_producao/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="ordem_producao_id">Usuário</label>
        <input type="number" class="form-control" id="ordem_producao_id" name="ordem_producao_id"
        value="<?php echo (isset($ordem_producao->ordem_producao_id)) ? $ordem_producao->ordem_producao_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="pedidos_id_id">Pedido</label>
        <select class="form-select" aria-label="Default select example" name="pedidos_id_id">
            <?php foreach ($pedidos_id as $item) {
                echo "<option value='$item->pedidos_id_id'". ($item->pedidos_id_id == $ordem_producao->pedidos_id_id ? "selected" : "") . ">$item->pedidos_id_name</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="empresa_id">Empresa</label>
        <select class="form-select" aria-label="Default select example" name="empresa_id">
            <?php foreach ($empresa as $item) {
                echo "<option value='$item->empresa_id'". ($item->empresa_id == $ordem_producao->empresa_id ? "selected" : "") . ">$item->empresa_name</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="data_criacao">Data criação</label>
        <input type="date" class="form-control" id="data_criacao" name="data_criacao"
        value="<?php echo (isset($ordem_producao->data_criacao)) ? $ordem_producao->data_criacao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="data_inicio">Data início</label>
        <input type="date" class="form-control" id="data_inicio" name="data_inicio"
        value="<?php echo (isset($ordem_producao->data_inicio)) ? $ordem_producao->data_inicio : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="data_finalizacao">Data término</label>
        <input type="date" class="form-control" id="data_finalizacao" name="data_finalizacao"
        value="<?php echo (isset($ordem_producao->data_finalizacao)) ? $ordem_producao->data_finalizacao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="operador_id">Operador</label>
        <select class="form-select" aria-label="Default select example" name="operador_id">
            <?php foreach ($operador as $item) {
                echo "<option value='$item->operador_id'". ($item->operador_id == $ordem_producao->operador_id ? "selected" : "") . ">$item->operador_name</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="cliente_id">Cliente</label>
        <select class="form-select" aria-label="Default select example" name="cliente_id">
            <?php foreach ($cliente as $item) {
                echo "<option value='$item->cliente_id'". ($item->cliente_id == $ordem_producao->cliente_id ? "selected" : "") . ">$item->cliente_name</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="data_confirmacao_pedido">Data confirmação do pedido</label>
        <input type="date" class="form-control" id="data_confirmacao_pedido" name="data_confirmacao_pedido"
        value="<?php echo (isset($ordem_producao->data_confirmacao_pedido)) ? $ordem_producao->data_confirmacao_pedido : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="data_limite_producao">Data limite produção</label>
        <input type="date" class="form-control" id="data_limite_producao" name="data_limite_producao"
        value="<?php echo (isset($ordem_producao->data_limite_producao)) ? $ordem_producao->data_limite_producao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="data_limite_instalcao">Data limite instalação</label>
        <input type="date" class="form-control" id="data_limite_instalcao" name="data_limite_instalcao"
        value="<?php echo (isset($ordem_producao->data_limite_instalcao)) ? $ordem_producao->data_limite_instalcao : ''; ?>" required>
    </div>


    <input type="hidden" name="ordem_producao_id" value="<?php echo (isset($ordem_producao->ordem_producao_id)) ? $ordem_producao->ordem_producao_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Ordem_producao" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

