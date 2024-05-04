
<h1>
    <?php echo (isset($reserva->reserva_id)) ? 'Editar Reservas de estoque' : 'Adicionar Reservas de estoque'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Reserva/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="produtos_id">Produto</label>
        <input type="number" class="form-control" id="produtos_id" name="produtos_id"
        value="<?php echo (isset($reserva->produtos_id)) ? $reserva->produtos_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="quantidade">Quantidade</label>
        <input type="number" class="form-control" id="quantidade" name="quantidade"
        value="<?php echo (isset($reserva->quantidade)) ? $reserva->quantidade : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="tipo">Tipo de Reserva</label>
        <input type="number" class="form-control" id="tipo" name="tipo"
        value="<?php echo (isset($reserva->tipo)) ? $reserva->tipo : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="reservado">Reservado</label>
        <input type="number" class="form-control" id="reservado" name="reservado"
        value="<?php echo (isset($reserva->reservado)) ? $reserva->reservado : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="documento">Documento</label>
        <input type="text" class="form-control" id="documento" name="documento"
        value="<?php echo (isset($reserva->documento)) ? $reserva->documento : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao"
        value="<?php echo (isset($reserva->descricao)) ? $reserva->descricao : ''; ?>" required>
    </div>


    <input type="hidden" name="reserva_id" value="<?php echo (isset($reserva->reserva_id)) ? $reserva->reserva_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Reserva" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

