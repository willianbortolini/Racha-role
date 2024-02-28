
<h1>
    <?php echo (isset($matriculas->matriculas_id)) ? 'Editar matriculas' : 'Adicionar matriculas'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Matriculas/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="usuarios_id">Usuario</label>
        <input type="number" class="form-control" id="usuarios_id" name="usuarios_id"
        value="<?php echo (isset($matriculas->usuarios_id)) ? $matriculas->usuarios_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="cursos_id">Curso</label>
        <input type="number" class="form-control" id="cursos_id" name="cursos_id"
        value="<?php echo (isset($matriculas->cursos_id)) ? $matriculas->cursos_id : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="recebimentos_id">Recebimento</label>
        <input type="number" class="form-control" id="recebimentos_id" name="recebimentos_id"
        value="<?php echo (isset($matriculas->recebimentos_id)) ? $matriculas->recebimentos_id : ''; ?>" required>
    </div>


    <input type="hidden" name="matriculas_id" value="<?php echo (isset($matriculas->matriculas_id)) ? $matriculas->matriculas_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Matriculas" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

