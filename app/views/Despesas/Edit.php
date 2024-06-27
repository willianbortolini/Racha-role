<style>
    .form-check {
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-check input[type="checkbox"] {
        margin-right: 0.5rem;
    }
</style>
<h1>
    <?php echo (isset($despesas->despesas_id)) ? 'Editar Despesas' : 'Adicionar Despesas'; ?>
</h1>

<form action="<?php echo URL_BASE . "Despesas/save" ?>" method="POST" enctype="multipart/form-data">

    <div class="container mt-4">
        <div class="form-group mb-2">
            <label for="grupos_id">Grupos</label>
            <select class="form-select" aria-label="Default select example" name="grupos_id" id="grupos_id">
                <?php foreach ($grupos as $item) {
                    echo "<option value='$item->grupos_id'" . ($item->grupos_id == $despesas->grupos_id ? "selected" : "") . ">$item->nome</option>";
                } ?>
            </select>
        </div>

        <div class="form-group mb-2">
            <label for="participantes">Participantes</label>
            <div id="participantes">
                <?php foreach ($users as $item): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="participantes[]"
                            value="<?php echo $item->users_id; ?>" id="user-<?php echo $item->users_id; ?>">
                        <label class="form-check-label" for="user-<?php echo $item->users_id; ?>">
                            <?php echo $item->username; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
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
                if (isset($despesas->users_id)){
                    echo "<option value='$item->users_id'" . ($item->users_id == $despesas->users_id ? "selected" : "") . ">$item->username</option>";
                }else{
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
        <div class="col-auto">
            <a href="<?php echo URL_BASE . "Despesas" ?>" class="btn btn-primary">Voltar</a>
        </div>
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
        document.getElementById('grupos_id').addEventListener('change', function () {
            var groupId = this.value;
            var url = '<?php echo URL_BASE ?>usuarios_grupos/usuariosDoGrupo/' + groupId;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    var usersIds = data.map(user => user.users_id);
                    var checkboxes = document.querySelectorAll('#participantes .form-check-input');
                    console.log(usersIds);
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = usersIds.includes(parseInt(checkbox.value));
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    });
</script>