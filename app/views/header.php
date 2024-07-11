<style>
  .header{
    padding: 10px 30px;
    background-color: #7A909B;
    font-weight: 700;
  }
</style>
<nav class="header navbar navbar-expand-lg  container">
<a class="nav-link text-wrapper-4" href="<?php echo URL_BASE ?>">Home</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
    aria-expanded="false" aria-label="Toggle navigation">
    <img src="<?PHP echo URL_BASE . 'logoApp.png' ?>" width="30px" alt="">
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav mr-3">
      <!--<li class="nav-item active">
        
      </li>
      <li class="nav-item">
        <a class="nav-link text-wrapper-4" href="#">Sobre o Curso</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-wrapper-4" href="#">FAQ</a>
      </li>
      <li class="nav-item">
      <a href="<?php echo URL_BASE . "users/edit/" . $_SESSION['id'] ?>" class="btn btn-primary">perfil</a>
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