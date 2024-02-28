
<h1>
    <?php echo (isset($inventario->inventario_id)) ? 'Editar inventario' : 'Adicionar inventario'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Inventario/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome"
        value="<?php echo (isset($inventario->nome)) ? $inventario->nome : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="localizacao">Localizacao</label>
        <input type="text" class="form-control" id="localizacao" name="localizacao"
        value="<?php echo (isset($inventario->localizacao)) ? $inventario->localizacao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="responsavel">Responsavel</label>
        <input type="text" class="form-control" id="responsavel" name="responsavel"
        value="<?php echo (isset($inventario->responsavel)) ? $inventario->responsavel : ''; ?>" required>
    </div>


    <input type="hidden" class="form-control" id="usuarios_id" name="usuarios_id"
        value="<?php echo (isset($inventario->usuarios_id)) ? $inventario->usuarios_id : $_SESSION['id']; ?>" required>        
    <input type="hidden" name="inventario_id" value="<?php echo (isset($inventario->inventario_id)) ? $inventario->inventario_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Inventario" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

