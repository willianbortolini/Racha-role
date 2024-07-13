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

    .date-picker-wrapper {
        position: relative;
        display: inline-block;
    }

    .calendar-icon {
        font-size: 50px;
        margin: 5px;
        cursor: pointer;
    }

    input[type="date"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
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

    .form-check {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .input-valor {
        padding: 5px;
        width: 50px;
        margin-left: 10px;
    }
</style>


<form id="despesas-form" action="<?php echo URL_BASE . "Despesas/save" ?>" method="POST" enctype="multipart/form-data">

    <div id="step1" class="container mt-4">
                <div class="input-container">
            <input type="text" id="descricao" name="descricao" class="input-field" placeholder="Adicione uma descrição"
                value="<?php echo (isset($despesas->descricao)) ? $despesas->descricao : ''; ?>" required>
        </div>

        <div class="input-container mt-4">
            <input type="number" id="valor-total" inputmode="decimal" name="valor" class="input-field" placeholder="0,00"
                value="<?php echo (isset($despesas->valor)) ? $despesas->valor : ''; ?>" required>
        </div>

        <input type="hidden" name="despesas_id"
            value="<?php echo (isset($despesas->despesas_id)) ? $despesas->despesas_id : NULL; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div class="footer-bar">
            <div class="footer-bar2">
                <a href="<?php echo URL_BASE . "amigos/home" ?>" class="btn btn-primary">voltar</a>

                <button type="button" class="btn btn-primary mb-2" id="step1-complete">Selecionar participantes</button>
                <div class="date-picker-wrapper">
                    <span class="calendar-icon">&#128197;</span>
                    <input type="date" id="data" name="data"
                        value="<?php echo (isset($despesas->data)) ? $despesas->data : ''; ?>" required>
                </div>
            </div>
        </div>

    </div>

    <div id="step2" class="hidden">


        <div class="form-group mb-2 w-100">
            <label for="users_id" class="form-label mt-4">Pago por</label>
            <select class="form-select col-12 input-field" aria-label=".form-select-lg example" name="users_id"
                id="users_id">
                <?php foreach ($users as $item) {
                    if (isset($despesas->users_id)) {
                        echo "<option value='$item->users_id'" . ($item->users_id == $despesas->users_uid ? "selected" : "") . ">" . ((empty($item->username)) ? $item->email : $item->username) . "</option>";
                    } else {
                        echo "<option value='$item->users_id'" . ($item->users_id == $_SESSION['id'] ? "selected" : "") . ">" . ((empty($item->username)) ? $item->email : $item->username) . "</option>";
                    }
                } ?>
            </select>
        </div>

        como dividir <br>
        <button type="button" id="dividir-igualmente" class="btn btn-primary mt-3">Igualmente</button>
        <button type="button" id="habilitar-inputs" class="btn btn-secondary mt-3">Valor</button>

        <input type="text" class="form-control filter-input mt-4" placeholder="Filtrar grupos ou amigos"
            id="filter-input">

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
                            <?= (empty($item->username)) ? $item->email : $item->username ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="footer-bar">
            <div id="total-display" class="total-display mb-4" id="total-display" style="display: none;">
                Valor Total: R$ 0.00 | Adicionado: R$ 0.00
            </div>
            <div class="footer-bar2">
                <button type="button" class="btn btn-primary mb-2" id="step1-return">
                    Voltar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</form>



<script>
    document.addEventListener('DOMContentLoaded', function () {

        

        const participantesDiv = document.getElementById('participantes');
        const valorTotalInput = document.getElementById('valor-total');
        const descricaolInput = document.getElementById('descricao');
        const habilitarInputsButton = document.getElementById('habilitar-inputs');
        const totalDisplay = document.getElementById('total-display');
        const dividirIgualmenteButton = document.getElementById('dividir-igualmente');
        const form = document.getElementById('despesas-form');
        let inputsHabilitados = false;

        setTimeout(() => {
            descricaolInput.focus();
            descricaolInput.click();
        }, 500);

        participantesDiv.addEventListener('change', function (event) {
            if (event.target.classList.contains('form-check-input')) {
                if (inputsHabilitados) {
                    if (event.target.checked) {
                        adicionarInputSemValorEMoverParaCima(event.target);
                    } else {
                        removerInputEMoverParaBaixo(event.target);
                    }
                } else {
                    moveSelectedToTop();
                }
            }
        });

        dividirIgualmenteButton.addEventListener('click', function () {
            divideEqually();
        });

        function adicionarInputSemValorEMoverParaCima(checkbox) {
            const formCheckDiv = checkbox.closest('.form-check');
            const existingInput = formCheckDiv.querySelector('.input-valor');
            if (!existingInput) {
                const valorInput = document.createElement('input');
                valorInput.type = 'number';
                valorInput.name = 'valorporparticipante[]';
                valorInput.className = 'input-valor';
                valorInput.placeholder = '0,00';
                valorInput.value = '';
                valorInput.addEventListener('input', updateTotalDisplay);
                formCheckDiv.appendChild(valorInput);
            }

            participantesDiv.removeChild(formCheckDiv);
            participantesDiv.insertBefore(formCheckDiv, participantesDiv.firstChild);

        }

        function removerInputEMoverParaBaixo(checkbox) {
            const formCheckDiv = checkbox.closest('.form-check');
            const valorInput = formCheckDiv.querySelector('.input-valor');
            if (valorInput) {
                formCheckDiv.removeChild(valorInput);
            }

            participantesDiv.removeChild(formCheckDiv);
            participantesDiv.appendChild(formCheckDiv);
            updateTotalDisplay()
        }

        function divideEqually() {
            const checkboxes = Array.from(participantesDiv.getElementsByClassName('form-check-input'));
            const selectedCheckboxes = checkboxes.filter(checkbox => checkbox.checked);

            const valorTotal = parseFloat(valorTotalInput.value);
            if (isNaN(valorTotal)) {
                alert('Por favor, insira um valor total válido.');
                return;
            }

            const valorDividido = parseFloat((valorTotal / selectedCheckboxes.length).toFixed(2));

            selectedCheckboxes.forEach(checkbox => {
                const formCheckDiv = checkbox.closest('.form-check');
                const valorInput = formCheckDiv.querySelector('.input-valor');
                valorInput.value = valorDividido.toFixed(2);
                valorInput.disabled = true; // Desabilita os inputs
            });
            totalDisplay.style.display = 'none';
            habilitarInputsButton.classList.remove('btn-primary')
            dividirIgualmenteButton.classList.remove('btn-secondary')
            habilitarInputsButton.classList.add('btn-secondary')
            dividirIgualmenteButton.classList.add('btn-primary')
            inputsHabilitados = false;
            updateTotalDisplay();
        }

        form.addEventListener('submit', function (event) {
            const inputs = document.querySelectorAll('.input-valor');
            inputs.forEach(input => {
                input.disabled = false; // Habilitar todos os inputs antes de submeter
            });
        });

        habilitarInputsButton.addEventListener('click', function () {
            const inputs = document.querySelectorAll('.input-valor');
            inputs.forEach(input => {
                input.disabled = false;
                input.value = '';
            });
            inputsHabilitados = true;
            totalDisplay.style.display = 'flex';
            habilitarInputsButton.classList.remove('btn-secondary')
            dividirIgualmenteButton.classList.remove('btn-primary')
            habilitarInputsButton.classList.add('btn-primary')
            dividirIgualmenteButton.classList.add('btn-secondary')
            updateTotalDisplay();
        });

        function moveSelectedToTop() {
            const checkboxes = Array.from(participantesDiv.getElementsByClassName('form-check-input'));
            const selectedCheckboxes = checkboxes.filter(checkbox => checkbox.checked);
            const unselectedCheckboxes = checkboxes.filter(checkbox => !checkbox.checked);

            // Limpar a lista
            participantesDiv.innerHTML = '';

            // Verificar se valor total é um número válido
            const valorTotal = parseFloat(valorTotalInput.value);
            if (isNaN(valorTotal)) {
                alert('Por favor, insira um valor total válido.');
                return;
            }

            // Adicionar os itens selecionados ao topo
            selectedCheckboxes.forEach(checkbox => {
                const formCheckDiv = checkbox.closest('.form-check');
                formCheckDiv.querySelector('.input-valor')?.remove(); // Remove existing input
                const valorDividido = parseFloat((valorTotal / selectedCheckboxes.length).toFixed(2));
                const valorInput = document.createElement('input');
                valorInput.type = 'number';
                valorInput.name = 'valorporparticipante[]';
                valorInput.className = 'input-valor input-field';
                valorInput.placeholder = '0,00'
                valorInput.value = valorDividido.toFixed(2); // Formatar valor com duas casas decimais
                valorInput.disabled = true; // Inicialmente desabilitado
                valorInput.addEventListener('input', updateTotalDisplay);
                formCheckDiv.appendChild(valorInput);
                participantesDiv.appendChild(formCheckDiv);
            });

            // Adicionar os itens não selecionados
            unselectedCheckboxes.forEach(checkbox => {
                const formCheckDiv = checkbox.closest('.form-check');
                formCheckDiv.querySelector('.input-valor')?.remove(); // Remove existing input
                participantesDiv.appendChild(formCheckDiv);
            });
        }

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
                            moveSelectedToTop()
                        })
                        .catch(error => console.error('Error fetching data:', error));
                } else {
                    var checkboxes = document.querySelectorAll('#participantes .form-check-input');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    moveSelectedToTop()
                }
            });
        });

        // Trigger change event for initially selected groups
        document.querySelectorAll('.grupo-checkbox:checked').forEach(function (checkbox) {
            checkbox.dispatchEvent(new Event('change'));
        });

        // Step 1 complete button
        document.getElementById('step1-complete').addEventListener('click', function () {

            if (descricaolInput.value.trim() === '') {
                alert('Adicione uma descrição');
            } else if (valorTotalInput.value.trim() === '') {
                alert('Adicione um valor');
            } else {
                vaiParaDadosDaDespesa()
            }
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

        function updateTotalDisplay() {
            const inputs = document.querySelectorAll('.input-valor');
            let totalAdicionado = 0;

            inputs.forEach(input => {
                let value = parseFloat(input.value);
                if (isNaN(value)) {
                    value = 0;
                }
                totalAdicionado += value;
            });

            const valorTotal = parseFloat(valorTotalInput.value).toFixed(2);
            falta = parseFloat(valorTotal - totalAdicionado).toFixed(2);
            totalDisplay.innerHTML = `R$ ${totalAdicionado.toFixed(2)} de R$ ${valorTotal} <br> falta R$ ${falta} `;
        }

        // Trigger change event for initially selected groups
        document.querySelectorAll('.grupo-checkbox:checked').forEach(function (checkbox) {
            checkbox.dispatchEvent(new Event('change'));
        });

    });
</script>