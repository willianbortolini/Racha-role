HOME
<div class="col-auto mt-2">
    <a href="<?php echo URL_BASE . "Grupos" ?>" class="btn btn-primary">Grupos</a>
</div>

<div class="col-auto mt-2">
    <a href="<?php echo URL_BASE . "users/edit/" . $_SESSION['id'] ?>" class="btn btn-primary">perfil</a>
</div>

<div class="col-auto mt-2">
    <a href="<?php echo URL_BASE . "amigos"?>" class="btn btn-primary">amigos</a>
</div>

<div class="col-auto mt-2">
    <a href="<?php echo URL_BASE . "Despesas/create"?>" class="btn btn-primary">adicionar despesas</a>
</div>

<div class="col-auto mt-2">
    <a href="<?php echo URL_BASE . "Despesas"?>" class="btn btn-primary">ver despesas</a>
</div>

<div class="col-auto mt-2">
    <a href="<?php echo URL_BASE . "Despesas"?>" class="btn btn-primary">minas despesas</a>
</div>

<h2 class="mb-4">Lista de débitos</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>PARA</th>
            <th>VALOR</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($minhasDespesas as $despesa){ ?>
            <tr>
                <td><?= $despesa->devendo_para_nome  ?></td>
                <td><?= number_format($despesa->valor, 2, ',', '.') ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
