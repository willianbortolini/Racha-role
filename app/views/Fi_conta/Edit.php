
<h1>
    <?php echo (isset($fi_conta->fi_conta_id)) ? 'Editar Conta' : 'Adicionar Conta'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Fi_conta/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="fi_conta_nome">Nome</label>
        <input type="text" class="form-control" id="fi_conta_nome" name="fi_conta_nome"
        value="<?php echo (isset($fi_conta->fi_conta_nome)) ? $fi_conta->fi_conta_nome : ''; ?>" required>
    </div>
    
    <input type="hidden" name="fi_conta_id" value="<?php echo (isset($fi_conta->fi_conta_id)) ? $fi_conta->fi_conta_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Fi_conta" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

