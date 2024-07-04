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
        font-weight: 500;
        font-size: 0.9rem;
        font-size: medium;
    }
</style>
<div class="mt-2">
    <a href="<?php echo URL_BASE . 'amigos/create' ?>" class="btn btn-outline-info"> <i class="fa fa-plus"></i>
        Adicionar amigo</a>
</div>
<hr>

<h5>No total, 
    <?php if ($saldo > 0) { ?>
        devem a você <span class="deveAvoce">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
    <?php } else { ?>
        você deve <span class="deveAvoce">R$ <?= number_format($saldo*-1, 2, ',', '.') ?></span>
    <?php } ?>
</h5>
<ul class="list-group">
    <?php foreach ($minhasDespesas as $despesa) { ?>
        <li class="list-group-item"
            onclick="location.href='<?php echo URL_BASE . 'pagamentos/detalhes/' . $despesa->users_id ?>'">
            <div class="profile-image" style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                <?php if (!empty($despesa->foto_perfil)) { ?>
                    <img src="<?= URL_IMAGEM_150 . $despesa->foto_perfil ?>" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;">
                <?php } else { ?>
                    <div style="width: 50px; height: 50px; background-color: #ccc; border-radius: 50%;"></div>
                <?php } ?>
            </div>
            <div class="name" style="display: inline-block; vertical-align: middle;">
                <?= $despesa->username ?></br>
                <span class="pix">PIX:079.920.529-00</span>
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

<div class="footer-bar">
    <a href="<?php echo URL_BASE . 'amigos/home' ?>" class="btn <?php echo ($btnAtivo == "amigos")? 'btn-secondary': 'btn-outline-secondary' ?>">
        <i class="fa fa-user-friends"></i>
        <span>Amigos</span>
    </a>
    <a href="<?php echo URL_BASE . 'Grupos/home' ?>" class="btn <?php echo ($btnAtivo == "grupos")? 'btn-secondary': 'btn-outline-secondary' ?>">
        <i class="fa fa-users"></i>
        <span>Grupos</span>
    </a>

    <a href="<?php echo URL_BASE . 'Despesas/create' ?>" class="btn btn-outline-primary">
        <i class="fa fa-plus"></i>
        <span>Adicionar</span>
    </a>
    <a href="<?php echo URL_BASE . 'pagamentos/create' ?>" class="btn <?php echo ($btnAtivo == "pagamentos")? 'btn-secondary': 'btn-outline-secondary' ?>">
        <i class="fa fa-money-bill"></i>
        <span>Pagar</span>
    </a>
    <a href="<?php echo URL_BASE . 'users/edit/' . $_SESSION['id'] ?>" class="btn <?php echo ($btnAtivo == "perfil")? 'btn-secondary': 'btn-outline-secondary' ?>">
        <i class="fa fa-user"></i>
        <span>Perfil</span>
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<script>
    /* document.querySelectorAll('.list-group-item').forEach(item => {
         item.addEventListener('click', function(e) {
             if (!e.target.closest('.btn')) {
                 window.location.href = this.getAttribute('onclick').replace('location.href=', '').replace(/'/g, '');
             }
         });
     });*/
</script>