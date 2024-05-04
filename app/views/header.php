<header class="p-2 border-bottom" style="background-color: #e6e6e6;">
  <div class="container">
    <div class="row">
      <?php if (isset($_SESSION['he_administrador'])) { ?>
        <div class="col-auto align-items-center">
          <a href="#" id="menuToggle" data-bs-target="#sidebar" data-bs-toggle="collapse"
            class="border rounded-3 p-1 text-black">
            <i id="menuIcon" class="bi bi-lg p-1 bi-chevron-left"></i>
          </a>
        </div>
      <?php } ?>
      <div class="col-auto align-items-center">
        <?php if (isset($_SESSION['he_master'])) { ?>
          <a href="<?php echo URL_BASE ?>">
            <h3>HOME</h3>
          </a>
        <?php } else { ?>
          <a href="<?php echo URL_BASE ?>">
            <img src="<?php echo URL_BASE . "assets/img/logo_indaflex.png" ?>">
          </a>
        <?php } ?>
      </div>
      <div class="col-auto align-items-center ms-auto">
        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i width="32" height="32" class="bi bi-person-circle fs-2"></i>
          </a>
          <ul class="dropdown-menu text-small">
            <?php if (isset($_SESSION['id'])) { ?>
              <li>
                <a class="dropdown-item" href="<?php echo URL_BASE . "User/edit/" . $_SESSION['id'] ?>">Perfil</a>
              </li>

              <?php if (isset($_SESSION['he_master'])) { ?>
                <li>
                  <a class="dropdown-item" href="<?php echo URL_BASE . "fi_categorias" ?>">Categorias</a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?php echo URL_BASE . "fi_conta" ?>">Contas</a>
                </li>
              <?php } ?>
              <hr class="dropdown-divider">
              <li><a class="dropdown-item" href="<?php echo URL_BASE . "login/logoff" ?>">Sair</a></li>
            <?php } else { ?>
              <li><a class="dropdown-item" href="<?php echo URL_BASE . "login" ?>">Entrar</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>

  </div>
</header>

<div class="ml-1 mr-2">
  <?php
  $this->verMsg();
  $this->verErro();
  ?>
</div>

<script>
  const menuToggle = document.getElementById('menuToggle');
  const menuIcon = document.getElementById('menuIcon');

  menuToggle.addEventListener('click', function () {
    const isCollapsed = menuToggle.getAttribute('aria-expanded') === 'false';
    if (isCollapsed) {
      menuIcon.classList.remove('bi-chevron-left');
      menuIcon.classList.add('bi-chevron-right');
    } else {
      menuIcon.classList.remove('bi-chevron-right');
      menuIcon.classList.add('bi-chevron-left');
    }
  });
  
</script>