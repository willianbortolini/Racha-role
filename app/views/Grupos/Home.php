<style>
 


    ul li {
        list-style-type: none;
        padding-left: 0;
    }

    .grupo {
        margin-top: 10px;
        background-color: #f1f1f1;
        padding: 8px;
        border-radius: 5px;
    }

    .lista {
        padding: 0px;
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
        width: 70px;
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

    .card-body {
        background-color: #ECCBAC;
    }
</style>
<div class="mt-2">
    <a href="<?php echo URL_BASE . 'grupos/create' ?>" class="btn btn-outline-secondary"> <i class="fa fa-plus"></i>
        Adicionar grupo</a>
</div>

<div class="card mt-2">
    <div class="card-body">
        <h5 class="card-title">No total,</h5>
        <?php if ($saldo > 0) { ?>
            <p class="card-text">Devem a você <span class="deveAvoce">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
            </p>
        <?php } else { ?>
            <p class="card-text">Você deve <span class="deveAvoce">R$ <?= number_format($saldo * -1, 2, ',', '.') ?></span>
            </p>
        <?php } ?>
    </div>
</div>
<ul class="lista">
    <?php $current_group = null;
    foreach ($minhasDespesas as $item) { ?>
        <?php
        // Definir o nome do grupo, substituindo nulos por 'Sem Grupo'
        $group_name = $item->nome_grupo ?? 'Despesa sem grupo';
        $group_id = $item->grupos_id ?? -1;
        ?>
        <?php if ($group_id !== $current_group) { ?>
            <?php if ($current_group !== null) { ?>
            </ul>
            </li>
        <?php } ?>
        <li class="grupo <?php echo ($group_id != -1) ? "grupoClicavel" : ""; ?>" <?php if ($group_id != -1) { ?>
                onclick="location.href='<?php echo URL_BASE . 'grupos/edit/' . $group_id ?>'" <?php } ?>>

            <?php if (!empty($item->foto)) { ?>
                <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                    <img src="<?= URL_IMAGEM_150 . $item->foto ?>" alt="Profile Image" class="rounded-circle"
                        style="width: 50px; height: 50px; object-fit: cover;">
                </div>
            <?php } ?>
            <strong><?php echo htmlspecialchars($group_name); ?></strong>
            <ul>
                <?php $current_group = $group_id; ?>
            <?php } ?>
            <li>
                <?php if ($item->valor != 0) { ?>
                    <?php if ($item->valor > 0) { ?>
                        Você deve
                        <span class="voceDeve"> R$
                            <?php echo moedaBr($item->valor) ?>
                        </span>
                        a
                        <?php echo substr(htmlspecialchars((empty($item->username)) ? $item->email : $item->username), 0, 20); ?>
                        </span>
                    <?php } else { ?>
                        <?php echo substr(htmlspecialchars((empty($item->username)) ? $item->email : $item->username), 0, 20); ?>
                        deve
                        <span class="deveAvoce"> R$
                            <?php echo moedaBr($item->valor * -1) ?>
                        </span>
                        a você
                    <?php } ?>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</li>
</ul>

<ul class="lista">
    <?php $current_group = null;
    foreach ($gruposQuitados as $item) { ?>
        <?php
        // Definir o nome do grupo, substituindo nulos por 'Sem Grupo'
        $group_name = $item->nome_grupo ?? 'Despesa sem grupo';
        $group_id = $item->grupos_id ?? -1;
        ?>
        <?php if ($group_id !== $current_group) { ?>
            <?php if ($current_group !== null) { ?>
            </ul>
            </li>
        <?php } ?>
        <li class="grupo" <?php if ($group_id != -1) { ?>
                onclick="location.href='<?php echo URL_BASE . 'grupos/edit/' . $group_id ?>'" <?php } ?>>

            <?php if (!empty($item->foto)) { ?>
                <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                    <img src="<?= URL_IMAGEM_150 . $item->foto ?>" alt="Profile Image" class="rounded-circle"
                        style="width: 50px; height: 50px; object-fit: cover;">
                </div>
            <?php } ?>
            <strong><?php echo htmlspecialchars($group_name); ?></strong>
            <ul>
                <?php $current_group = $group_id; ?>
            <?php } ?>
            <li>
                Quitado ou sem despesas
            </li>
        <?php } ?>
    </ul>
</li>
</ul>

<div class="footer-bar">
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