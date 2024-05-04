
<h1>
    <?php echo (isset($posicao_op->posicao_op_id)) ? 'Editar Posições da linha da OP' : 'Adicionar Posições da linha da OP'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Posicao_op/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2 col-12 col-md-6">
        <input type="checkbox" class="form-check-input" id="ativo" name="ativo"
            <?php echo (isset($posicao_op->ativo) && $posicao_op->ativo == '1') ? 'checked' : ''; ?>>
        <label for="composicao_nome">Posição ativa</label>
    </div>

    <div class="form-group mb-2">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao"
        value="<?php echo (isset($posicao_op->descricao)) ? $posicao_op->descricao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="ordem">Ordem de exibição</label>
        <input type="number" class="form-control" id="ordem" name="ordem"
        value="<?php echo (isset($posicao_op->ordem)) ? $posicao_op->ordem : ''; ?>" required>
    </div>


    <input type="hidden" name="posicao_op_id" value="<?php echo (isset($posicao_op->posicao_op_id)) ? $posicao_op->posicao_op_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Posicao_op" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>

