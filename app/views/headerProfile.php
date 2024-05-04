<style>
  @media (min-width: 991.98px) {
    .conteudo {
      margin-left: 260px;
    }
  }

  /* Sidebar */
  .sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    /* Height of navbar */
    box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
    width: 240px;
    z-index: 600;
  }

  @media (max-width: 991.98px) {
    .sidebar {
      width: 100%;
    }

  }

  .sidebar .active {
    border-radius: 5px;
    box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
  }

  .sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: 0.5rem;
    overflow-x: hidden;
    overflow-y: auto;
    /* Scrollable contents if viewport is shorter than content. */
  }
</style>

<!-- Sidebar -->
<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
  <div class="position-sticky">
    <div class="list-group list-group-flush mx-3 mt-4">
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
          <?php $this->dropDownStore(); ?>
        </li>

        <li class="nav-item ">
          <a href="<?php echo URL_BASE   . "store/profile" ?>" class="nav-link  link-body-emphasis" aria-current="page">
            <i class="bi  bi-house me-2" width="16" height="16">

            </i>
            Home
          </a>
        </li>
        <li class="nav-item ">
          <a href="<?php echo URL_BASE . $_SESSION['domain'] ?>" class="nav-link  link-body-emphasis" aria-current="page">
            <i class="bi  bi-eye me-2" width="16" height="16"> </i>
            Ir para locadora
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link link-body-emphasis collapsed" data-bs-toggle="collapse" href="#editarCollapse"
            aria-expanded="false">
            <i class="bi bi-chevron-down"></i> Editar
          </a>
          <div class="collapse show" id="editarCollapse">
            <ul class="list-unstyled">
              <li class="ms-4 nav-item">
                <a href="<?php echo URL_BASE   . "Store/edit/" . $_SESSION['store'] ?>"
                  class="nav-link link-body-emphasis ">
                  <i class="bi bi-shop me-2"></i>
                  Locadora
                </a>
              </li>
              <li class="ms-4 nav-item">
                <a href="<?php echo URL_BASE   . "Categorie" ?>" class="nav-link link-body-emphasis">
                  <i class="bi bi-folder me-2"></i>
                  Categorias
                </a>
              </li>
              <li class="ms-4 nav-item">
                <a href="<?php echo URL_BASE   . "Equipment" ?>" class="nav-link link-body-emphasis">
                  <i class="bi bi-tools me-2"></i>
                  Equipamento
                </a>
              </li>
              <li class="ms-4 nav-item">
                <a href="<?php echo URL_BASE   . "Banner" ?>" class="nav-link link-body-emphasis">
                  <i class="bi bi-image me-2"></i>
                  Banner
                </a>
              </li>
              <li class="ms-4 nav-item">
                <a href="<?php echo URL_BASE   . "Differential" ?>" class="nav-link link-body-emphasis">
                  <i class="bi bi-star-fill me-2"></i>
                  Diferenciais
                </a>
              </li>
              <li class="ms-4 nav-item">
                <a href="<?php echo URL_BASE   . "Testimonial" ?>" class="nav-link link-body-emphasis">
                  <i class="bi bi-chat-right-quote-fill me-2"></i>
                  Depoimentos
                </a>
              </li>              
              <li class="ms-4 nav-item">
                <a href="<?php echo URL_BASE   . "Imagesgalerie" ?>" class="nav-link link-body-emphasis">
                  <i class="bi bi-camera me-2"></i>
                  Galeria
                </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item ">
          <a href="<?php echo URL_BASE . "login/logoff" ?>" class="nav-link  link-body-emphasis" aria-current="page">
            <i class="bi  bi-box-arrow-right" width="16" height="16">              
              
            </i>
            Sair
          </a>
        </li>


      </ul>
    </div>
  </div>
</nav>


<!-- Sidebar -->