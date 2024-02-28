
<h1>
    <?php echo (isset($recebimentos->recebimentos_id)) ? 'Editar Recebimentos' : 'Adicionar Recebimentos'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Recebimentos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="usuarios_id">Usuario</label>
        <input type="number" class="form-control" id="usuarios_id" name="usuarios_id"
        value="<?php echo (isset($recebimentos->usuarios_id)) ? $recebimentos->usuarios_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="cursos_id">Curso</label>
        <input type="number" class="form-control" id="cursos_id" name="cursos_id"
        value="<?php echo (isset($recebimentos->cursos_id)) ? $recebimentos->cursos_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="valor">Valor</label>
        <input type="number" class="form-control" id="valor" name="valor"
        value="<?php echo (isset($recebimentos->valor)) ? $recebimentos->valor : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="metodo">Método</label>
        <input type="number" class="form-control" id="metodo" name="metodo"
        value="<?php echo (isset($recebimentos->metodo)) ? $recebimentos->metodo : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="id_mercado_pago">Id mercado pago</label>
        <input type="text" class="form-control" id="id_mercado_pago" name="id_mercado_pago"
        value="<?php echo (isset($recebimentos->id_mercado_pago)) ? $recebimentos->id_mercado_pago : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email"
        value="<?php echo (isset($recebimentos->email)) ? $recebimentos->email : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="recebimento_data">Data do recebimento</label>
        <input type="date" class="form-control" id="recebimento_data" name="recebimento_data"
        value="<?php echo (isset($recebimentos->recebimento_data)) ? $recebimentos->recebimento_data : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="recebimento_status">Status do recebimento</label>
        <input type="number" class="form-control" id="recebimento_status" name="recebimento_status"
        value="<?php echo (isset($recebimentos->recebimento_status)) ? $recebimentos->recebimento_status : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="recebimento_data_liberacao">Data da liberação do recebimento</label>
        <input type="date" class="form-control" id="recebimento_data_liberacao" name="recebimento_data_liberacao"
        value="<?php echo (isset($recebimentos->recebimento_data_liberacao)) ? $recebimentos->recebimento_data_liberacao : ''; ?>" required>
    </div>


    <input type="hidden" name="recebimentos_id" value="<?php echo (isset($recebimentos->recebimentos_id)) ? $recebimentos->recebimentos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Recebimentos" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

