<style>
.exclusao-ativa img { opacity: 0.3;} 
</style>
<h1>
    <?php echo (isset($grupos->grupos_id)) ? 'Editar Grupos' : 'Adicionar Grupos'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Grupos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome"
        value="<?php echo (isset($grupos->nome)) ? $grupos->nome : ''; ?>" required>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-12 mb-2">
           <?php if (isset($grupos->foto) && $grupos->foto != '') { ?>
                <label class="container-imagem" for="foto">
                    <img id="preview"  width="250" height="250"
                        src="<?php echo (isset($grupos->foto)) ? (URL_IMAGEM . $grupos->foto) : ''; ?>">
                </label>
                <div class="image-buttons mt-1 mb-1">
                   <button type="button" class="btn btn-primary btn-edit" data-target="foto">Editar</button>
                   <button type="button" class="btn btn-danger btn-delete ms-2" data-target="remove_foto">Excluir</button>
                   <input type="checkbox" class="form-check-input visually-hidden" id="remove_foto" name="remove_foto"
                       value="1">
                </div>
            <?php } else { ?>
                <label class="container-imagem" for="foto">
                    <svg class="bd-placeholder-img " width="250" height="250" role="img" focusable="false">
                        <rect width="100%" height="100%" fill="#868e96"></rect>
                        <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                    </svg>
                </label>
            <?php } ?>
            <input type="file" class="form-control-file visually-hidden" id="foto" name="foto">
        </div>
    </div>


    <input type="hidden" name="grupos_id" value="<?php echo (isset($grupos->grupos_id)) ? $grupos->grupos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Grupos" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>