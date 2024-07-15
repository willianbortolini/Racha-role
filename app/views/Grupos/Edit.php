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
        padding: 10px 0 20px 0px;
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
        border-radius: 0px;
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



    #copyMessage {
        display: none;
    }
</style>
<div id="step1" class="container mt-4">
    <h1>
        <?php echo (isset($grupos->grupos_id)) ? 'Editar Grupos' : 'Adicionar Grupos'; ?>
    </h1>

    <form action="<?php echo URL_BASE . "Grupos/save" ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="form-group col-2">
                <?php if (isset($grupos->foto) && $grupos->foto != '') { ?>
                    <label class="container-imagem" for="foto">
                        <img class="imagemCircular" id="preview"
                            src="<?php echo (isset($grupos->foto)) ? (URL_IMAGEM_150 . $grupos->foto) : ''; ?>">
                    </label>
                <?php } else { ?>
                    <label class="container-imagem" for="foto">
                        <div class="imagemCircular"></div>
                    </label>
                <?php } ?>
                <input type="file" class="form-control-file" id="foto" name="foto">
            </div>
            <input class="input-field  col-8 mb-5 ml-2" type="text" class="form-control" id="nome" name="nome"
                value="<?php echo (isset($grupos->nome)) ? $grupos->nome : ''; ?>" required>
        </div>
        <input type="hidden" name="grupos_id"
            value="<?php echo (isset($grupos->grupos_id)) ? $grupos->grupos_id : NULL; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="footer-bar">
            <div class="footer-bar2">
                <a href="<?php echo URL_BASE . "Grupos/home" ?>" class="btn btn-outline-secondary">Voltar</a>
                <?php if (isset($grupos->grupos_id)) { ?>
                    <button id="go2" type="button" class="btn btn-outline-secondary">Adicionar amigos</button>
                <?php } ?>
                <button type="submit" class="btn btn-outline-secondary">Salvar</button>
            </div>
        </div>

    </form>
    <?php if (isset($grupos->grupos_id)) { ?>
        <h5>Membros do grupo</h5>
        <?php if (isset($grupos->grupos_id)) { ?>
            <ul class="list-group">
                <?php foreach ($membroGrupo as $usuario) { ?>
                    <li class="list-group-item"
                        onclick="location.href='<?php echo URL_BASE . 'despesas/detalhe/' . $usuario->users_uid ?>'">

                        <?php if (!empty($usuario->foto_perfil)) { ?>
                            <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                                <img src="<?= URL_IMAGEM_150 . $usuario->foto_perfil ?>" alt="Profile Image" class="rounded-circle"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </div>
                        <?php } ?>
                        <div class="name" style="display: inline-block; vertical-align: middle;">
                            <?= (empty($usuario->username)) ? $usuario->email : $usuario->username ?></br>
                        </div>

                    </li>
                <?php } ?>
            </ul>
            </table>
        <?php } ?>
    <?php } ?>
</div>
<div id="step2" class="hidden">
    <form action="<?php echo URL_BASE . "Usuarios_grupos/save" ?>" method="POST" enctype="multipart/form-data">

        <input type="text" class="form-control filter-input mt-4" placeholder="Filtrar grupos ou amigos"
            id="filter-input">

        <div class="form-group mb-2">
            <label for="participantes">Amigos</label>
            <div id="participantes">
                <?php
                foreach ($users as $item) {
                    $commonFound = false;
                    foreach ($membroGrupo as $usuario) {
                        if ($item->users_id == $usuario->users_id) {
                            $commonFound = true;
                        }
                    }
                    if (!$commonFound) { ?>
                        <div class="form-check">
                            <label class="form-check-label" for="user-<?php echo $item->users_uid; ?>">
                                <input class="form-check-input" type="checkbox" name="participantes[]"
                                    value="<?php echo $item->users_uid; ?>" id="user-<?php echo $item->users_uid; ?>">
                                <span class="custom-checkbox"></span>
                                <?php if (!empty($usuario->foto_perfil)) { ?>
                                    <img src="<?= URL_IMAGEM_150 . $item->foto_perfil ?>" alt="Profile Image"
                                        class="imagemCircular">
                                <?php } else { ?>
                                    <div class="imagemCircular"></div>
                                <?php } ?>
                                <?= (empty($item->username)) ? $item->email : $item->username ?>
                            </label>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>

        <input type="hidden" name="grupos_id" value="<?php echo $grupos->grupos_id ?>">
        <input type="hidden" name="usuarios_grupos_id"
            value="<?php echo (isset($usuarios_grupos->usuarios_grupos_id)) ? $usuarios_grupos->usuarios_grupos_id : NULL; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="footer-bar">
            <div id="copyMessage" class="alert alert-success mt-3">Link copiado compartilhe com seus amigos para eles
                fazerem parte desse grupo.</div>
            <div class="footer-bar2">
                <button id="go1" type="button" class="btn btn-outline-secondary">Voltar</button>
                <button type="submit" class="btn btn-outline-secondary">Adicionar selecionados</button>

                <button type="button" id="copyButton" class="btn btn-outline-secondary">Copiar link</button>


            </div>
        </div>

    </form>

</div>

<script>
    document.getElementById('copyButton').addEventListener('click', function () {
        // URL to be copied
        var url = '<?php echo URL_BASE . 'login/index/' . $grupos->grupos_id ?>';

        // Create a temporary input element
        var tempInput = document.createElement('input');
        tempInput.style.position = 'absolute';
        tempInput.style.left = '-9999px';
        tempInput.value = url;
        document.body.appendChild(tempInput);

        // Select the text and copy it
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');

        // Remove the temporary input element
        document.body.removeChild(tempInput);

        // Show the message
        var copyMessage = document.getElementById('copyMessage');
        copyMessage.style.display = 'block';

        // Hide the message after 3 seconds
        setTimeout(function () {
            copyMessage.style.display = 'none';
        }, 3000);
    });
    function handleFileInputChange(event) {

        var file = event.target.files[0];
        var reader = new FileReader();
        var previewContainer = event.target.parentNode.querySelector("[for='" + event.target.id + "']");
        reader.onload = function (e) {
            var img = document.createElement("img");
            img.src = e.target.result;
            img.classList.add("imagemCircular");

            previewContainer.innerHTML = "";
            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    }

    var fileInputs = document.querySelectorAll("input[type=file]");

    fileInputs.forEach(function (fileInput) {
        fileInput.addEventListener("change", handleFileInputChange);
    });

    // Adicione um evento de clique aos botões "Editar"
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.target;
            document.getElementById(targetId).click();
        });
    });

    function toggleExclusao(button) {
        const targetId = button.dataset.target;
        const checkbox = document.getElementById(targetId);
        const imageLabel = button.parentElement.previousElementSibling;

        if (checkbox.checked) {
            // Se o checkbox estiver marcado, desmarque-o e remova a classe "exclusao-ativa"
            checkbox.checked = false;
            imageLabel.classList.remove("exclusao-ativa");
            button.innerText = "Excluir";
        } else {
            // Se o checkbox estiver desmarcado, marque-o e adicione a classe "exclusao-ativa"
            checkbox.checked = true;
            imageLabel.classList.add("exclusao-ativa");
            button.innerText = "Cancelar exclusão";
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Adicionar eventos de clique aos botões "Excluir"
        const deleteButtons = document.querySelectorAll(".btn-delete");
        deleteButtons.forEach(button => {
            button.addEventListener("click", function () {
                toggleExclusao(this);
            });
        });


    });

    document.getElementById('go2').addEventListener('click', function () {
        vaiParaStep2()
    });

    document.getElementById('go1').addEventListener('click', function () {
        vaiParaStep1()
    });

    function vaiParaStep2() {
        document.getElementById('step1').classList.remove('visible');
        document.getElementById('step1').classList.add('hidden');
        setTimeout(function () {
            document.getElementById('step2').classList.remove('hidden');
            document.getElementById('step2').classList.add('visible');
        }, 10);
    }

    function vaiParaStep1() {
        document.getElementById('step2').classList.remove('visible');
        document.getElementById('step2').classList.add('hidden');
        setTimeout(function () {
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('step1').classList.add('visible');
        }, 10);
    }

</script>