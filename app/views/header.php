 <nav class="navbar navbar-expand-lg  container">
  <a class="navbar-brand text-wrapper-4" href="<?php echo URL_BASE ?>">InvTrack</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
    aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav mr-3">
      <!--<li class="nav-item active">
        <a class="nav-link text-wrapper-4" href="<?php echo URL_BASE ?>">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-wrapper-4" href="#">Sobre o Curso</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-wrapper-4" href="#">FAQ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-wrapper-4" href="#">Contato</a>
      </li>-->
      <li class="nav-item">
        <a class="nav-link text-wrapper-4" href="<?php echo URL_BASE . 'login/logoff' ?>">SAIR</a>
      </li>
    </ul>
  </div>
</nav>



<div class="ml-1 mr-2">
  <?php
  $this->verMsg();
  $this->verErro();
  ?>
</div>