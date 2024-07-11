<style>
    .footer-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        padding: 10px 0;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
        flex-direction: column;
    }

    .footer-bar2 {
        display: flex;
        width: 100%;
    }

    .footer-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #ffffff;
        padding: 10px 0;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-around;
        align-items: center;
        z-index: 1000;
    }

    .footer-bar .btn {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: auto;
        height: 60px;
        font-size: 14px;

    }

    .footer-bar .btn.active {
        background-color: #007bff;
        /* Active color */
    }

    .footer-bar .btn i {
        margin-bottom: 5px;
        font-size: 20px;
    }

    .fixed-bottom-btn {
        width: 70px;
        height: 70px;
        font-size: 20px;
    }

    @media (min-width: 768px) {
        .footer-bar .btn {
            width: auto;
            height: auto;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .footer-bar .btn i {
            margin-bottom: 0;
        }

        .fixed-bottom-btn {
            width: auto;
            height: auto;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 20px;
        }
    }

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

    .form-control-file,
    .form-control-range {
        display: none;
        width: 100%;
    }

    .imagemCircular {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        background-color: #ccc;
        border-radius: 50%;
    }

    .input-container {
        position: relative;
        margin: 20px;
    }

    .input-field {
        border: none;
        border-bottom: 2px solid gray;
        outline: none;
        font-size: 16px;
        padding: 5px 0;
        width: 100%;
    }

    .input-field:focus {
        border-bottom: 2px solid blue;
    }

    .input-field::placeholder {
        color: gray;
    }

    .input-field:focus::placeholder {
        color: transparent;
    }

    .form-check {
        display: flex;
        margin-bottom: 6px;
        align-items: center;
        justify-content: space-between;
    }

    /* Esconder o checkbox original */
    input[type="checkbox"] {
        display: none;
    }

    /* Estilizar o label que vai atuar como checkbox */
    .custom-checkbox {
        display: inline-block;
        width: 30px;
        height: 30px;
        background-color: #f0f0f0;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        margin-right: 10px;
    }

    /* Estilizar o estado marcado do checkbox */
    input[type="checkbox"]:checked+.custom-checkbox {
        background-color: #007bff;
    }

    /* Estilizar a marca de seleção */
    input[type="checkbox"]:checked+.custom-checkbox::after {
        content: '';
        position: absolute;
        top: 7px;
        left: 12px;
        width: 6px;
        height: 12px;
        border: solid #a5d1ff;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .form-check-label {
        display: flex;
        align-items: center;
    }

    .hidden {
        display: none;
    }
</style>
<h1>
    <?php echo (isset($users->users_id)) ? 'Editar Usuários' : 'Adicionar Usuários'; ?>
</h1>

<form action="<?php echo URL_BASE . "Users/save" ?>" method="POST" enctype="multipart/form-data">
    <div class="col">
        <div class="row">
            <div class="form-group col-2">
                <?php if (isset($users->foto_perfil) && $users->foto_perfil != '') { ?>
                    <label class="container-imagem" for="foto">
                        <img class="imagemCircular" id="preview"
                            src="<?php echo (isset($users->foto_perfil)) ? (URL_IMAGEM . $users->foto_perfil) : ''; ?>">
                    </label>
                <?php } else { ?>
                    <label class="container-imagem" for="foto">
                        <div class="imagemCircular"></div>
                    </label>
                <?php } ?>
                <input type="file" class="form-control-file" id="foto" name="foto">
            </div>


            <div class="form-group  col-8 mb-5 ml-2">
                <label for="username">Nome</label>
                <input type="text" class="input-field" id="username" name="username"
                    value="<?php echo (isset($users->username)) ? $users->username : ''; ?>" required>
            </div>

        </div>
        <div class="form-group mb-2">
            <label for="email">E-mail</label>
            <input type="email" class="input-field" id="email" name="email"
                value="<?php echo (isset($users->email)) ? $users->email : ''; ?>" required>
        </div>


        <div class="form-group mb-2">
            <label for="telefone">Telefone</label>
            <input type="text" class="input-field" id="telefone" name="telefone"
                value="<?php echo (isset($users->telefone)) ? $users->telefone : ''; ?>" required>
        </div>

        <div class="form-group mb-2">
            <label for="pix">Pix</label>
            <input type="text" class="input-field" id="pix" name="pix"
                value="<?php echo (isset($users->pix)) ? $users->pix : ''; ?>" required>
        </div>


    </div>
    <input type="hidden" name="users_id" value="<?php echo (isset($users->users_id)) ? $users->users_id : NULL; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="col-auto mt-4">
        <a href="<?php echo URL_BASE . 'Politicaprivacidade' ?>" class="btn btn-primary" target="_blank">Política de
            privacidade</a>
    </div>
    <div class="col-auto mt-4">
        <a href="<?php echo URL_BASE . "login/esqueci" ?>" class="btn btn-primary">Esqueci minha senha</a>
    </div>
    <?php if ($users->ativo == 1) { ?>
        <div class="col-auto mt-4">
            <a href="<?php echo URL_BASE . "users/desativar" ?>" class="btn btn-primary">desativar perfil</a>
        </div>
    <?php } else { ?>
        <div class="col-auto mt-4">
            <a href="<?php echo URL_BASE . "users/ativar" ?>" class="btn btn-primary">reativar perfil</a>
        </div>
    <?php } ?>

    <a class="nav-link text-wrapper-4  mt-4 text-danger" href="<?php echo URL_BASE . 'login/logoff' ?>">SAIR</a>
   
    <div class="footer-bar">
        <div class="footer-bar2">
            <a href="<?php echo URL_BASE ?>" class="btn btn-primary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </div>
</form>
<script src="<?php echo URL_BASE ?>assets/js/inputImg.js"></script>