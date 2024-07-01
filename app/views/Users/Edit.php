<style>
    .exclusao-ativa img {
        opacity: 0.3;
    }
</style>
<h1>
    <?php echo (isset($users->users_id)) ? 'Editar Usuários' : 'Adicionar Usuários'; ?>
</h1>

<form action="<?php echo URL_BASE . "Users/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="username">Nome</label>
        <input type="text" class="form-control" id="username" name="username"
            value="<?php echo (isset($users->username)) ? $users->username : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" id="email" name="email"
            value="<?php echo (isset($users->email)) ? $users->email : ''; ?>" required>
    </div>

    <div class="form-group mb-2">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone"
            value="<?php echo (isset($users->telefone)) ? $users->telefone : ''; ?>" required>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-12 mb-2">
            <?php if (isset($users->foto_perfil) && $users->foto_perfil != '') { ?>
                <label class="container-imagem" for="foto_perfil">
                    <img id="preview" width="250" height="250"
                        src="<?php echo (isset($users->foto_perfil)) ? (URL_IMAGEM . $users->foto_perfil) : ''; ?>">
                </label>
                <div class="image-buttons mt-1 mb-1">
                    <button type="button" class="btn btn-primary btn-edit" data-target="foto_perfil">Editar</button>
                    <button type="button" class="btn btn-danger btn-delete ms-2"
                        data-target="remove_foto_perfil">Excluir</button>
                    <input type="checkbox" class="form-check-input visually-hidden" id="remove_foto_perfil"
                        name="remove_foto_perfil" value="1">
                </div>
            <?php } else { ?>
                <label class="container-imagem" for="foto_perfil">
                    <svg class="bd-placeholder-img " width="250" height="250" role="img" focusable="false">
                        <rect width="100%" height="100%" fill="#868e96"></rect>
                        <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Carregue uma imagem</text>
                    </svg>
                </label>
            <?php } ?>
            <input type="file" class="form-control-file visually-hidden" id="foto_perfil" name="foto_perfil">
        </div>
    </div>

    <input type="hidden" name="users_id" value="<?php echo (isset($users->users_id)) ? $users->users_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="col-auto">
        <a href="<?php echo URL_BASE . 'Politicaprivacidade' ?>" class="btn btn-primary" target="_blank">Política de
            privacidade</a>
    </div>
    <div class="col-auto">
        <a href="<?php echo URL_BASE . "login/esqueci" ?>" class="btn btn-primary">Esqueci minha senha</a>
    </div>
    <?php if ($users->ativo == 1) { ?>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "users/desativar" ?>" class="btn btn-primary">desativar perfil</a>
        </div>
    <?php } else { ?>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "users/ativar" ?>" class="btn btn-primary">reativar perfil</a>
        </div>
    <?php } ?>

    <a class="nav-link text-wrapper-4" href="<?php echo URL_BASE . 'login/logoff' ?>">SAIR</a>
    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>