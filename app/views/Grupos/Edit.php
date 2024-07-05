<style>
    .list-group-item {
        cursor: pointer;
        padding: 15px;
        border: none;
        transition: background-color 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item:hover {
        background-color: #f1f1f1;
    }

    .list-group-item .name {
        font-weight: bold;
        font-size: 1.2rem;
        flex-grow: 1;
        text-align: left;
    }

    .list-group-item .amount {
        font-size: 1.2rem;
        font-weight: bold;
        text-align: right;
    }

    .list-group-item .description {
        font-size: 0.9rem;
        text-align: right;
    }

    .list-group-item .valor {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center the items horizontally */
        justify-content: center;
        /* Center the items vertically */
        margin-right: 10px;
    }

    .deveAvoce {
        color: #00a5a5;
    }

    .voceDeve {
        color: #f79b0c;
    }

    .list-group-item .btn-quitar {
        font-weight: 600 !important;
    }

    .exclusao-ativa img {
        opacity: 0.3;
    }
</style>
<h1>
    <?php echo (isset($grupos->grupos_id)) ? 'Editar Grupos' : 'Adicionar Grupos'; ?>
</h1>

<form action="<?php echo URL_BASE . "Grupos/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="form-group mb-2">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome"
            value="<?php echo (isset($grupos->nome)) ? $grupos->nome : ''; ?>" required>
    </div>

    <div class="row">
        <div class="form-group col-lg-6 col-12 mb-2">
            <?php if (isset($grupos->foto) && $grupos->foto != '') { ?>
                <label class="container-imagem" for="foto">
                    <img id="preview" width="250" height="250"
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

    <input type="hidden" name="grupos_id"
        value="<?php echo (isset($grupos->grupos_id)) ? $grupos->grupos_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Grupos/home" ?>" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</form>
<?php if (isset($grupos->grupos_id)) { ?>
    <h5>Membros do grupo</h5>
   
    <form action="<?php echo URL_BASE . "Usuarios_grupos/save" ?>" method="POST" enctype="multipart/form-data">

        <div class="form-group mb-2">
            <label for="users_id">Amigo</label>
            <select class="form-select" aria-label="Default select example" name="users_id">
                <?php foreach ($users as $item) {
                    echo "<option value='$item->users_id'" . ($item->users_id == $usuarios_grupos->users_id ? "selected" : "") . ">$item->username</option>";
                } ?>
            </select>
        </div>

        <input type="hidden" name="grupos_id" value="<?php echo $grupos->grupos_id ?>">
        <input type="hidden" name="usuarios_grupos_id"
            value="<?php echo (isset($usuarios_grupos->usuarios_grupos_id)) ? $usuarios_grupos->usuarios_grupos_id : NULL; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="row">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Adicionar amigo ao grupo</button>
            </div>
        </div>
    </form>

    <?php if (isset($grupos->grupos_id)) { ?>
        <ul class="list-group">
            <?php foreach ($membroGrupo as $usuario) { ?>
                <li class="list-group-item"
                    onclick="location.href='<?php echo URL_BASE . 'pagamentos/detalhes/' . $usuario->users_id ?>'">
                    <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                        <?php if (!empty($usuario->foto_perfil)) { ?>
                            <img src="<?= URL_IMAGEM_150 . $usuario->foto_perfil ?>" alt="Profile Image"
                                style="width: 50px; height: 50px; border-radius: 50%;">
                        <?php } else { ?>
                            <div style="width: 50px; height: 50px; background-color: #ccc; border-radius: 50%;"></div>
                        <?php } ?>
                    </div>
                    <div class="name" style="display: inline-block; vertical-align: middle;">
                        <?= $usuario->username ?></br>
                        <span class="pix">PIX:079.920.529-00</span>
                    </div>

                </li>
            <?php } ?>
        </ul>
        </table>
    <?php } ?>
<?php } ?>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>