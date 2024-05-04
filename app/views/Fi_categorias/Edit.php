
<h1>
    <?php echo (isset($fi_categorias->fi_categorias_id)) ? 'Editar Categorias de transações financeiras' : 'Adicionar Categorias de transações financeiras'; ?>
</h1>
<form action="<?php echo URL_BASE   . "Fi_categorias/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="fi_categorias_nome">Nome</label>
        <input type="text" class="form-control" id="fi_categorias_nome" name="fi_categorias_nome"
        value="<?php echo (isset($fi_categorias->fi_categorias_nome)) ? $fi_categorias->fi_categorias_nome : ''; ?>" required>
    </div>


    <input type="hidden" name="fi_categorias_id" value="<?php echo (isset($fi_categorias->fi_categorias_id)) ? $fi_categorias->fi_categorias_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Fi_categorias" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

