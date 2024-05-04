
<h1>
    <?php echo (isset($composicao_tipo->composicao_tipo_id)) ? 'Editar Tipo de composição' : 'Adicionar Tipo de composição'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Composicao_tipo/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="composicao_tipo_nome">Nome</label>
        <input type="text" class="form-control" id="composicao_tipo_nome" name="composicao_tipo_nome"
        value="<?php echo (isset($composicao_tipo->composicao_tipo_nome)) ? $composicao_tipo->composicao_tipo_nome : ''; ?>" required>
    </div>


    <input type="hidden" name="composicao_tipo_id" value="<?php echo (isset($composicao_tipo->composicao_tipo_id)) ? $composicao_tipo->composicao_tipo_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Composicao_tipo" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

