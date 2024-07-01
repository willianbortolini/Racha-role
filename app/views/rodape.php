<div class="footer-bar">
    <a href="<?php echo URL_BASE . 'amigos/home' ?>" class="btn <?php echo ($btnAtivo == "amigos")? 'btn-secondary': 'btn-outline-secondary' ?>">
        <i class="fa fa-user-friends"></i>
        <span>Amigos</span>
    </a>
    <a href="<?php echo URL_BASE . 'Grupos' ?>" class="btn <?php echo ($btnAtivo == "grupos")? 'btn-secondary': 'btn-outline-secondary' ?>">
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