
<h1>
    <?php echo (isset($statusPedido->statusPedido_id)) ? 'Editar Status pedido' : 'Adicionar Status pedido'; ?>
</h1>

<form action="<?php echo URL_BASE   . "StatusPedido/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="statusPedido_nome">status</label>
        <input type="text" class="form-control" id="statusPedido_nome" name="statusPedido_nome"
        value="<?php echo (isset($statusPedido->statusPedido_nome)) ? $statusPedido->statusPedido_nome : ''; ?>" required>
    </div>


    <input type="hidden" name="statusPedido_id" value="<?php echo (isset($statusPedido->statusPedido_id)) ? $statusPedido->statusPedido_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "StatusPedido" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

