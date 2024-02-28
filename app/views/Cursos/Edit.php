<style>
.exclusao-ativa img { opacity: 0.3;} 
</style>
<h1>
    <?php echo (isset($Cursos->Cursos_id)) ? 'Editar Cursos' : 'Adicionar Cursos'; ?>
</h1>

<form class="dark-form" action="<?php echo URL_BASE   . "Cursos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="nome">Nome do curso</label>
        <input type="text" class="form-control" id="nome" name="nome"
        value="<?php echo (isset($Cursos->nome)) ? $Cursos->nome : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="area">Area</label>
        <input type="text" class="form-control" id="area" name="area"
        value="<?php echo (isset($Cursos->area)) ? $Cursos->area : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" id="descricao" name="descricao"
        value="<?php echo (isset($Cursos->descricao)) ? $Cursos->descricao : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="desconto">Desconto</label>
        <input type="number" class="form-control" id="desconto" name="desconto" step="1"
        value="<?php echo (isset($Cursos->desconto)) ? $Cursos->desconto : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="preco_original">Preço original</label>
        <input type="number" class="form-control" id="preco_original" name="preco_original" step="0.01"
        value="<?php echo (isset($Cursos->preco_original)) ? $Cursos->preco_original : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="preco">Preço</label>
        <input type="number" class="form-control" id="preco" name="preco" step="0.01"
        value="<?php echo (isset($Cursos->preco)) ? $Cursos->preco : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="professor_id">Professor</label>
        <input type="number" class="form-control" id="professor_id" name="professor_id"
        value="<?php echo (isset($Cursos->professor_id)) ? $Cursos->professor_id : ''; ?>" required>
    </div>

    <!--<div class="form-group mb-2">
        <label for="professor_id_id">professor</label>
        <select class="form-select form-control" aria-label="Default select example" name="professor_id_id">
            <?php foreach ($professor_id as $item) {
                echo "<option value='$item->professor_id_id'". ($item->professor_id_id == $Cursos->professor_id_id ? "selected" : "") . ">$item->professor_id_name</option>";
            } ?>
        </select>
    </div>-->

    <div class="row">
        <div class="form-group col-lg-6 col-12 mb-2">
           <?php if (isset($Cursos->url_imagem) && $Cursos->url_imagem != '') { ?>
                <label class="container-imagem" for="url_imagem">
                    <img id="preview"  width="250" height="250"
                        src="<?php echo (isset($Cursos->url_imagem)) ? (URL_IMAGEM . $Cursos->url_imagem) : ''; ?>">
                </label>
                <div class="image-buttons mt-1 mb-1">
                   <button type="button" class="btn btn-primary btn-edit" data-target="url_imagem">Editar</button>
                   <button type="button" class="btn btn-danger btn-delete ms-2" data-target="remove_url_imagem">Excluir</button>
                   <input type="checkbox" class="form-check-input visually-hidden" id="remove_url_imagem" name="remove_url_imagem"
                       value="1">
                </div>
            <?php } else { ?>
                <label class="container-imagem" for="url_imagem">
                    <svg class="bd-placeholder-img " width="250" height="250" role="img" focusable="false">
                        <rect width="100%" height="100%" fill="#868e96"></rect>
                        <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                    </svg>
                </label>
            <?php } ?>
            <input type="file" class="form-control-file visually-hidden" id="url_imagem" name="url_imagem">
        </div>
    </div>


    <input type="hidden" name="Cursos_id" value="<?php echo (isset($Cursos->Cursos_id)) ? $Cursos->Cursos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Cursos" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>
