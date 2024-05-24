
<h1>
    <?php echo (isset($->_id)) ? 'Editar ' : 'Adicionar '; ?>
</h1>

<form action="<?php echo URL_BASE   . "/save" ?>" method="POST" enctype="multipart/form-data">


    <input type="hidden" name="_id" value="<?php echo (isset($->_id)) ? $->_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

