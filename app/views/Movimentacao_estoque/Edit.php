
<h1>
    <?php echo (isset($movimentacao_estoque->movimentacao_estoque_id)) ? 'Editar Movimentação de estoque' : 'Adicionar Movimentação de estoque'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Movimentacao_estoque/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="produtos_id">Produto</label>
        <input type="number" class="form-control" id="produtos_id" name="produtos_id"
        value="<?php echo (isset($movimentacao_estoque->produtos_id)) ? $movimentacao_estoque->produtos_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="quantidade">Quantidade</label>
        <input type="number" class="form-control" id="quantidade" name="quantidade"
        value="<?php echo (isset($movimentacao_estoque->quantidade)) ? $movimentacao_estoque->quantidade : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tipo_movimentacao">Tipo de movimentação</label>
        <input type="number" class="form-control" id="tipo_movimentacao" name="tipo_movimentacao"
        value="<?php echo (isset($movimentacao_estoque->tipo_movimentacao)) ? $movimentacao_estoque->tipo_movimentacao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao"
        value="<?php echo (isset($movimentacao_estoque->descricao)) ? $movimentacao_estoque->descricao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="data">Data da movimentação</label>
        <input type="date" class="form-control" id="data" name="data"
        value="<?php echo (isset($movimentacao_estoque->data)) ? $movimentacao_estoque->data : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="usuarios_id">Usuário</label>
        <input type="number" class="form-control" id="usuarios_id" name="usuarios_id"
        value="<?php echo (isset($movimentacao_estoque->usuarios_id)) ? $movimentacao_estoque->usuarios_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="reserva_id">reserva</label>
        <input type="number" class="form-control" id="reserva_id" name="reserva_id"
        value="<?php echo (isset($movimentacao_estoque->reserva_id)) ? $movimentacao_estoque->reserva_id : ''; ?>" required>
    </div>


    <input type="hidden" name="movimentacao_estoque_id" value="<?php echo (isset($movimentacao_estoque->movimentacao_estoque_id)) ? $movimentacao_estoque->movimentacao_estoque_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Movimentacao_estoque" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

