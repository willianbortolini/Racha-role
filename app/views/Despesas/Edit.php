<style>
    .form-check {
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-check input[type="checkbox"] {
        margin-right: 0.5rem;
    }

    .hidden {
        display: none;
    }

    .filter-input {
        margin-bottom: 1rem;
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
</style>


<form action="<?php echo URL_BASE . "Despesas/save" ?>" method="POST" enctype="multipart/form-data">

    <div id="step1" class="container mt-4">
        <h5 class="mt-4">
            Selecione o grupo ou os usuários com quem você quer dividir a conta
        </h5>
        <div class=" d-flex justify-content-end">
            <button type="button" class="btn btn-primary mb-2" id="step1-complete">Feito</button>
        </div>
        <input type="text" class="form-control filter-input" placeholder="Filtrar grupos ou amigos" id="filter-input">

        <div class="form-group mb-2">
            <label for="grupos_id">Grupos</label>
            <div id="grupos_id">
                <?php foreach ($grupos as $item): ?>
                    <div class="form-check">
                        <label class="form-check-label" for="grupo-<?php echo $item->grupos_id; ?>">
                            <input class="form-check-input grupo-checkbox" type="checkbox" name="grupos_id"
                                value="<?php echo $item->grupos_id; ?>" id="grupo-<?php echo $item->grupos_id; ?>" <?php echo ((!isset($item->grupos_id)) && ($item->grupos_id == $despesas->grupos_id)) ? 'checked' : ''; ?>>
                            <span class="custom-checkbox"></span>
                            <?php echo $item->nome; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group mb-2">
            <label for="participantes">Amigos</label>
            <div id="participantes">
                <?php foreach ($users as $item): ?>
                    <div class="form-check">
                        <label class="form-check-label" for="user-<?php echo $item->users_id; ?>">
                            <input class="form-check-input" type="checkbox" name="participantes[]"
                                value="<?php echo $item->users_id; ?>" id="user-<?php echo $item->users_id; ?>">
                            <span class="custom-checkbox"></span>
                            <?php echo $item->username; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <div id="step2" class="hidden">
        <h5 class="mt-4">
            Com você e todos<span id="dividido"></span>
        </h5>
        <div class="form-group mb-2">
            <label for="descricao">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao"
                value="<?php echo (isset($despesas->descricao)) ? $despesas->descricao : ''; ?>" required>
        </div>

        <div class="form-group mb-2">
            <label for="valor">Valor</label>
            <input type="number" class="form-control" id="valor" name="valor"
                value="<?php echo (isset($despesas->valor)) ? $despesas->valor : ''; ?>" required>
        </div>

        <div class="form-group mb-2">
            <label for="data">Data</label>
            <input type="date" class="form-control" id="data" name="data"
                value="<?php echo (isset($despesas->data)) ? $despesas->data : ''; ?>" required>
        </div>

        <div class="form-group mb-2">
            <label for="users_id">Pago por</label>
            <select class="form-select" aria-label="Default select example" name="users_id">
                <?php foreach ($users as $item) {
                    if (isset($despesas->users_id)) {
                        echo "<option value='$item->users_id'" . ($item->users_id == $despesas->users_id ? "selected" : "") . ">$item->username</option>";
                    } else {
                        echo "<option value='$item->users_id'" . ($item->users_id == $_SESSION['id'] ? "selected" : "") . ">$item->username</option>";
                    }
                } ?>
            </select>
        </div>

        <input type="hidden" name="despesas_id"
            value="<?php echo (isset($despesas->despesas_id)) ? $despesas->despesas_id : NULL; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="row">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
        <button type="button" class="btn btn-primary" id="step1-return">Voltar</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set default date to today if not already set
        var dateInput = document.getElementById('data');
        if (!dateInput.value) {
            var today = new Date();
            var day = String(today.getDate()).padStart(2, '0');
            var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            var year = today.getFullYear();
            dateInput.value = year + '-' + month + '-' + day;
        }

        document.querySelectorAll('.grupo-checkbox').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var groupId = this.value;
                if (this.checked) {
                    // Uncheck all other checkboxes
                    document.querySelectorAll('.grupo-checkbox').forEach(function (otherCheckbox) {
                        if (otherCheckbox !== checkbox) {
                            otherCheckbox.checked = false;
                        }
                    });

                    // Clear all user checkboxes
                    var userCheckboxes = document.querySelectorAll('#participantes .form-check-input');
                    userCheckboxes.forEach(function (userCheckbox) {
                        userCheckbox.checked = false;
                    });

                    var url = '<?php echo URL_BASE ?>usuarios_grupos/usuariosDoGrupo/' + groupId;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            var usersIds = data.map(user => user.users_id);
                            var checkboxes = document.querySelectorAll('#participantes .form-check-input');
                            checkboxes.forEach(checkbox => {
                                if (usersIds.includes(parseInt(checkbox.value))) {
                                    checkbox.checked = true;
                                }
                            });
                            vaiParaDadosDaDespesa()
                            document.getElementById('dividido').textContent = ' do grupo ' + getSelectedItems();
                        })
                        .catch(error => console.error('Error fetching data:', error));
                } else {
                    var checkboxes = document.querySelectorAll('#participantes .form-check-input');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                }
            });
        });

        // Trigger change event for initially selected groups
        document.querySelectorAll('.grupo-checkbox:checked').forEach(function (checkbox) {
            checkbox.dispatchEvent(new Event('change'));
        });

        // Step 1 complete button
        document.getElementById('step1-complete').addEventListener('click', function () {
            var selectedUsers = document.querySelectorAll('#participantes .form-check-input:checked');
            if (selectedUsers.length < 1) {
                alert('Por favor, selecione pelo menos uma pessoa para dividir a conta.');
                return;
            }
            vaiParaDadosDaDespesa()
        });

        // Step 1 complete button
        document.getElementById('step1-return').addEventListener('click', function () {
            vaiParaSelecaoDeUsuarios()
        });

        function vaiParaDadosDaDespesa() {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
        }

        function vaiParaSelecaoDeUsuarios() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
        }

        // Filter functionality
        document.getElementById('filter-input').addEventListener('input', function () {
            var filterValue = this.value.toLowerCase();
            var groups = document.querySelectorAll('#grupos_id .form-check');
            var friends = document.querySelectorAll('#participantes .form-check');

            groups.forEach(function (group) {
                var label = group.querySelector('label').innerText.toLowerCase();
                group.style.display = label.includes(filterValue) ? '' : 'none';
            });

            friends.forEach(function (friend) {
                var label = friend.querySelector('label').innerText.toLowerCase();
                friend.style.display = label.includes(filterValue) ? '' : 'none';
            });
        });

        function getSelectedItems() {
            const selectedGroups = [];
            const selectedFriends = [];

            // Percorrer checkboxes dos grupos
            document.querySelectorAll('.grupo-checkbox').forEach(checkbox => {
                if (checkbox.checked) {
                    const label = checkbox.closest('label');
                    if (label) {
                        selectedGroups.push(label.textContent.trim());
                    }
                }
            });

            // Percorrer checkboxes dos amigos
            document.querySelectorAll('input[name="participantes[]"]').forEach(checkbox => {
                if (checkbox.checked) {
                    const label = checkbox.closest('label');
                    if (label) {
                        selectedFriends.push(label.textContent.trim());
                    }
                }
            });

            // Montar a string conforme a lógica especificada
            let resultString = '';

            if (selectedGroups.length > 0) {
                resultString = selectedGroups.join(', ');
            } else if (selectedFriends.length > 0) {
                resultString = selectedFriends.join(', ');
            }

            return resultString;
        }

    });
</script>