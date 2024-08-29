<style>
    .list-group-item {
        cursor: pointer;
        padding: 15px 0px;
        border: none;
        transition: background-color 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-container {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .btn-container .btn {
        margin-top: 5px;
        white-space: nowrap;
    }

    .list-group-item .pix {
        font-weight: 400;
        color: #6f6f6f;
        font-size: medium;
    }

    .footer-bar .btn {
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 60px;
        font-size: 14px;

    }

    .fundo-tabela {
        height: 100px;
    }
</style>
<div class="mt-2 d-flex justify-content-between">
    <a href="<?php echo URL_BASE . 'amigos/create' ?>" class="btn btn-outline-secondary">
        <i class="fa fa-plus"></i> Adicionar amigo
    </a>
</div>

<div class="card mt-2">
    <div class="card-body">
        <h5 class="card-title">No total</h5>
        <?php if ($saldo > 0) { ?>
            <p class="card-text">Devem a você <span class="deveAvoce">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
            </p>
        <?php } else { ?>
            <p class="card-text">Você deve <span class="voceDeve">R$ <?= number_format($saldo * -1, 2, ',', '.') ?></span>
            </p>
        <?php } ?>
    </div>
</div>

<div class="inf">
    <ul class="list-group">
        <?php foreach ($minhasDespesas as $despesa) { ?>
            <li class="list-group-item"
                onclick="location.href='<?php echo URL_BASE . 'despesas/detalhe/' . $despesa->users_uid ?>'">
                <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                    <img src="<?= (!empty($despesa->foto_perfil)) ? URL_IMAGEM_150 . $despesa->foto_perfil : URL_BASE . "assets/img/avatares/avatar" . $despesa->avatar . ".jpg" ?>"
                        alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                </div>
                <div class="name" style="display: inline-block; vertical-align: middle;">
                    <?= (empty($despesa->username)) ? $despesa->email : $despesa->username ?>
                    </br>
                    <?php echo (isset($despesa->pix)) ? "<span class='pix'>pix: " . $despesa->pix . " </span> " : "" ?>
                </div>
                <?php if ($despesa->valor > 0) { ?>
                    <div class="valor">
                        <span class="description deveAvoce">deve a você</span>
                        <span class="amount deveAvoce">R$ <?= number_format($despesa->valor, 2, ',', '.') ?></span>
                    </div>

                <?php } else { ?>
                    <div class="valor">
                        <span class="description voceDeve">você deve</span>
                        <span class="amount voceDeve">R$ <?= number_format($despesa->valor * -1, 2, ',', '.') ?></span>
                    </div>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>

    <ul class="list-group">
        <?php foreach ($todosAmigos as $amigo) { ?>
            <?php if ($amigo->users_uid != $_SESSION['uid']) { ?>
                <li class="list-group-item"
                    onclick="location.href='<?php echo URL_BASE . 'despesas/detalhe/' . $amigo->users_uid ?>'">
                    <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                        <img src="<?= (!empty($amigo->foto_perfil)) ? URL_IMAGEM_150 . $amigo->foto_perfil : URL_BASE . "assets/img/avatares/avatar" . $amigo->avatar . ".jpg" ?>"
                            alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    </div>
                    <div class="name" style="display: inline-block; vertical-align: middle;">
                        <?= (empty($amigo->username)) ? $amigo->email : $amigo->username ?></br>
                        <?php echo (isset($amigo->pix)) ? "<span class='pix'>pix: " . $amigo->pix . " </span> " : "" ?>
                    </div>

                </li>
            <?php } ?>
        <?php } ?>
    </ul>
    <div class="fundo-tabela"></div>
    <div class="footer-bar">
        <div class="footer-bar2">
            <a href="<?php echo URL_BASE . 'amigos/home' ?>"
                class="btn <?php echo ($btnAtivo == "amigos") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
                <i class="fa fa-user-friends"></i>
                <span>Amigos</span>
            </a>
            <a href="<?php echo URL_BASE . 'Grupos/home' ?>"
                class="btn <?php echo ($btnAtivo == "grupos") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
                <i class="fa fa-users"></i>
                <span>Grupos</span>
            </a>

            <a href="<?php echo URL_BASE . 'Despesas/create' ?>" class="btn btn-outline-secondary">
                <i class="fa fa-plus"></i>
                <span>Adicionar</span>
            </a>
            <a href="<?php echo URL_BASE . 'pagamentos/create' ?>"
                class="btn <?php echo ($btnAtivo == "pagamentos") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
                <i class="fa fa-money-bill"></i>
                <span>Pagar</span>
            </a>
            <a href="<?php echo URL_BASE . 'users/edit/' . $_SESSION['id'] ?>"
                class="btn <?php echo ($btnAtivo == "perfil") ? 'btn-secondary' : 'btn-outline-secondary' ?>">
                <i class="fa fa-user"></i>
                <span>Perfil</span>
            </a>
        </div>
    </div>
</div>

<script>
    <?php if (isset($newAuthToken)) { ?>
        localStorage.setItem('authTokenRachaRole', '<?php echo $newAuthToken; ?>');
    <?php } ?>   
   
    try {
        const response = await fetch('https://v6.exchangerate-api.com/v6/ccf43821c8928b0a0486dd6b/latest/BRL');
        const data = await response.json();
        const rates = data.conversion_rates;

        localStorage.setItem('conversionRateUSD', rates.USD);
        localStorage.setItem('conversionRateARS', rates.ARS);

    } catch (error) {
        console.error('Error fetching exchange rates:', error);
    }
</script>