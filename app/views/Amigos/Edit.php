
<h1>
    <?php echo (isset($amigos->amigos_id)) ? 'Editar Amigos' : 'Adicionar Amigos'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Amigos/convidar" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="amigo_id">E-mail do amigo</label>
        <input type="text" class="form-control" id="email_amigo" name="email_amigo" required>
    </div>

    <input type="hidden" name="amigos_id" value="<?php echo (isset($amigos->amigos_id)) ? $amigos->amigos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Amigos" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

