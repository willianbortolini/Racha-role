<style>
.exclusao-ativa img { opacity: 0.3;} 
</style>
<h1>
    <?php echo (isset($tickets->tickets_id)) ? 'Editar Tickets' : 'Adicionar Tickets'; ?>
</h1>

<form action="<?php echo URL_BASE   . "Tickets/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="user_id">User ID</label>
        <select class="form-select" aria-label="Default select example" name="user_id">
            <?php foreach ($usuarios as $item) {
                echo "<option value='$item->usuarios_id'". ($item->usuarios_id == $tickets->user_id ? "selected" : "") . ">$item->usuario</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="subject">Subject</label>
        <input type="text" class="form-control" id="subject" name="subject"
        value="<?php echo (isset($tickets->subject)) ? $tickets->subject : ''; ?>" required>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-12 mb-2">
           <?php if (isset($tickets->imagem_perfil) && $tickets->imagem_perfil != '') { ?>
                <label class="container-imagem" for="imagem_perfil">
                    <img id="preview"  width="250" height="250"
                        src="<?php echo (isset($tickets->imagem_perfil)) ? (URL_IMAGEM . $tickets->imagem_perfil) : ''; ?>">
                </label>
                <div class="image-buttons mt-1 mb-1">
                   <button type="button" class="btn btn-primary btn-edit" data-target="imagem_perfil">Editar</button>
                   <button type="button" class="btn btn-danger btn-delete ms-2" data-target="remove_imagem_perfil">Excluir</button>
                   <input type="checkbox" class="form-check-input visually-hidden" id="remove_imagem_perfil" name="remove_imagem_perfil"
                       value="1">
                </div>
            <?php } else { ?>
                <label class="container-imagem" for="imagem_perfil">
                    <svg class="bd-placeholder-img " width="250" height="250" role="img" focusable="false">
                        <rect width="100%" height="100%" fill="#868e96"></rect>
                        <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                    </svg>
                </label>
            <?php } ?>
            <input type="file" class="form-control-file visually-hidden" id="imagem_perfil" name="imagem_perfil">
        </div>
    </div>

    <div class="form-group mb-2">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5"
        required><?php echo (isset($tickets->description)) ? $tickets->description : ''; ?></textarea>
    </div>

    <div class="form-group mb-2">
        <label for="CPF">CPF</label>
        <input type="text" class="form-control" id="CPF" name="CPF"
        value="<?php echo (isset($tickets->CPF)) ? $tickets->CPF : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="status">Status</label>
        <select class="form-select" aria-label="Default select example" name="status">
            <?php foreach ($status as $item) {
                 echo "<option value='$item'". (isset($tickets->status) && $item == $tickets->status ? "selected" : "") . ">$status</option>";
            } ?>
        </select>
    </div>

    <div class="form-group mb-2">
        <label for="priority">Priority</label>
        <select class="form-select" aria-label="Default select example" name="priority">
            <?php foreach ($priority as $item) {
                 echo "<option value='$item'". (isset($tickets->priority) && $item == $tickets->priority ? "selected" : "") . ">$priority</option>";
            } ?>
        </select>
    </div>

    <input type="hidden" name="tickets_id" value="<?php echo (isset($tickets->tickets_id)) ? $tickets->tickets_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE   . "Tickets" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>
