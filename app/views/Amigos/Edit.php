
<h1>
    <?php echo (isset($amigos->amigos_id)) ? 'Editar Amigos' : 'Adicionar Amigos'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Amigos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="amigo">E-mail ou telefone do amigo</label>
        <input type="text" class="form-control" id="amigo" name="amigo" 
             value="<?php echo (isset($convites->amigo)) ? $convites->amigo : ''; ?>" required>
    </div>

    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

