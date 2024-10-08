<style>
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

    ul li {
        list-style-type: none;
        padding-left: 0;
    }

    .grupo {
        margin-top: 10px;
        background-color: #f1f1f1;
        padding: 8px;
    }

    .lista {
        padding: 0px;
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


    .list-group-item .btn-quitar {
        font-weight: 600 !important;
    }

    .select-field {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 5px 0;
        cursor: pointer;
        border-bottom: 2px solid gray;
    }

    .select-field:hover {
        border-bottom: 2px solid blue;
    }

    .select-field span {
        font-size: 16px;
        color: black;
    }

    .select-field i {
        font-size: 20px;
        color: gray;
    }
</style>
</head>

<body>
    <div class="container mt-4">
        <h5>
            <?php echo (isset($pagamentos->pagamentos_id)) ? 'Editar Pagamentos' : 'Pagamentos'; ?>
        </h5>

        <form action="<?php echo URL_BASE . "Pagamentos/save" ?>" method="POST" enctype="multipart/form-data"
            onsubmit="return validateForm()">

            <!-- Campo Pagador -->
            <div class="form-group mb-3">
                <label for="pagador">Pagador</label>
                <div class="select-field" id="select-pagador">
                    <span
                        id="pagador-selected"><?php echo (isset($pagador->username) or isset($pagador->email)) ? ((empty($pagador->username)) ? $pagador->email : $pagador->username) : 'Selecione o Pagador'; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <input type="hidden" name="pagador" id="pagador"
                    value="<?= isset($pagador->users_uid) ? $pagador->users_uid : '' ?>" required>
            </div>
            <!-- Campo Recebedor -->
            <div class="form-group mb-3">
                <label for="recebedor">Recebedor</label>
                <div class="select-field" id="select-recebedor">
                    <span
                        id="recebedor-selected"><?php echo (isset($recebedor->username) or isset($recebedor->email)) ? ((empty($recebedor->username)) ? $recebedor->email : $recebedor->username) : 'Selecione o Recebedor'; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <input type="hidden" name="recebedor" id="recebedor"
                    value="<?= isset($recebedor->users_uid) ? $recebedor->users_uid : '' ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="valor">Valor</label>
                <input type="number" class="input-field form-control" id="valor" name="valor" step="0.01"
                    value="<?php echo (isset($valor)) ? $valor : ''; ?>" required>
            </div>

            <div class="form-group mb-3">
                <label for="data">Data</label>
                <input type="date" class="input-field form-control" id="data" name="data"
                    value="<?php echo (isset($pagamentos->data)) ? $pagamentos->data : date('Y-m-d'); ?>" required>
            </div>

            <input type="hidden" name="pagamentos_id"
                value="<?php echo (isset($pagamentos->pagamentos_id)) ? $pagamentos->pagamentos_id : NULL; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="footer-bar">
                <div class="footer-bar2">
                    <button type="button" onclick="window.history.back()"
                        class="btn btn-outline-secondary">Voltar</button>
                    <button type="submit" class="btn btn-outline-secondary">Salvar</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Pagador -->
    <div class="modal fade" id="pagadorModal" tabindex="-1" role="dialog" aria-labelledby="pagadorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pagadorModalLabel">Selecione o Pagador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control filter-input mt-4" placeholder="Filtrar grupos ou amigos"
                        id="filter-input-pagador">
                    <div class="form-group mb-2">
                        <label for="participantes">Amigos</label>
                        <div id="participantes-pagador">
                            <?php foreach ($users as $item) { ?>
                                <div class="form-check user-option" data-user-id="<?php echo $item->users_uid; ?>"
                                    data-user-name="<?= (empty($item->username)) ? $item->email : $item->username ?>">
                                    <label class="form-check-label">
                                        <div class="profile-image"
                                            style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                                            <img src="<?= (!empty($item->foto_perfil)) ? URL_IMAGEM_150 . $item->foto_perfil : URL_BASE . "assets/img/avatares/avatar" . $item->avatar . ".jpg" ?>"
                                                alt="Profile Image" class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                        <?= (empty($item->username)) ? $item->email : $item->username ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Recebedor -->
    <div class="modal fade" id="recebedorModal" tabindex="-1" role="dialog" aria-labelledby="recebedorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recebedorModalLabel">Selecione o Recebedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control filter-input mt-4" placeholder="Filtrar grupos ou amigos"
                        id="filter-input-recebedor">
                    <div class="form-group mb-2">
                        <label for="participantes">Amigos</label>
                        <div id="participantes-recebedor">
                            <?php foreach ($users as $item) { ?>
                                <div class="form-check user-option" data-user-id="<?php echo $item->users_uid; ?>"
                                    data-user-name="<?= (empty($item->username)) ? $item->email : $item->username ?>">
                                    <label class="form-check-label">
                                        <div class="profile-image"
                                            style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                                            <img src="<?= (!empty($item->foto_perfil)) ? URL_IMAGEM_150 . $item->foto_perfil : URL_BASE . "assets/img/avatares/avatar" . $item->avatar . ".jpg" ?>"
                                                alt="Profile Image" class="rounded-circle"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                        <?= (empty($item->username)) ? $item->email : $item->username ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var pagador = document.getElementById('pagador').value;
            var recebedor = document.getElementById('recebedor').value;

            if (pagador === '') {
                alert('Por favor, selecione o pagador.');
                return false;
            }

            if (recebedor === '') {
                alert('Por favor, selecione o recebedor.');
                return false;
            }

            return true;
        }
        $(document).ready(function () {

            // Abre o modal ao clicar no campo Pagador
            $("#select-pagador").on("click", function () {
                $('#pagadorModal').modal('show');
            });

            // Abre o modal ao clicar no campo Recebedor
            $("#select-recebedor").on("click", function () {
                $('#recebedorModal').modal('show');
            });

            // Filtrar participantes no modal Pagador
            $("#filter-input-pagador").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#participantes-pagador .form-check").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Filtrar participantes no modal Recebedor
            $("#filter-input-recebedor").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#participantes-recebedor .form-check").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Selecionar pagador no modal
            $("#participantes-pagador .user-option").on("click", function () {
                var selectedUserId = $(this).data('user-id');
                var selectedUserName = $(this).data('user-name');
                $("#pagador").val(selectedUserId);
                $("#pagador-selected").text(selectedUserName);
                $('#pagadorModal').modal('hide');
            });

            // Selecionar recebedor no modal
            $("#participantes-recebedor .user-option").on("click", function () {
                var selectedUserId = $(this).data('user-id');
                var selectedUserName = $(this).data('user-name');
                $("#recebedor").val(selectedUserId);
                $("#recebedor-selected").text(selectedUserName);
                $('#recebedorModal').modal('hide');
            });
        });
    </script>