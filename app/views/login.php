<style>
  body{
    background-color: #BA9B88;
  }
</style>
<div class="ml-1 mr-2">
  <?php
  $this->verMsg();
  $this->verErro();
  ?>
</div>


<div class="modal modal-sheet position-static d-block" tabindex="-1" role="dialog" id="modalSignin">
<div class="modal-header pe-5 mt-2 border-bottom-0">
    <a href="javascript:void(0);" onclick="window.history.back();" class="btn-close" aria-label="Close"></a>

  </div>

  <div class="profile-image" style="display: flex; justify-content: center;">
    <img src="<?= URL_BASE . "assets/img/login.png" ?>" alt="Profile Image" class="rounded-circle"
      style="width: 250px; height: 250px; object-fit: cover;">
  </div>

  <div class="modal-header p-5 pb-4 border-bottom-0">
    <h1 class="fw-bold mb-0 fs-2">Racha Role</h1>

  </div>
  <div class="modal-body p-5 pt-0">
    <form class="" action="<?php echo URL_BASE . "login/logar" ?> " method="post">
      <div class="form-floating mb-3">
        <input type="email" class="form-control rounded-3" name="email" id="floatingInput"
          placeholder="name@example.com">
        <label for="floatingInput">Endereço de email</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control rounded-3" name="senha" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Senha</label>
      </div>
      <small class="text-body-secondary"><a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="<?php echo URL_BASE . "login/esqueci" ?>">Esqueci minha senha
        </a></small>
      <hr class="my-4">
      <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Login</button>
      <small class="text-body-secondary">Não tem uma conta? <a
      class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="<?php echo URL_BASE . "Users/create" ?>">Inscrever-se</a></small>
      <hr class="my-4">
      <a href="<?php echo $authUrl; ?>" class="w-100 py-2 mb-2 btn btn-outline-light rounded-3" type="submit">
        <i class="bi bi-google"></i>
        Login com Google
      </a>
    </form>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Função para verificar o token
    function checkAuth() {
      const token = localStorage.getItem('authTokenRachaRole');
      console.log(token);
      if (token) {
        fetch('<?php echo URL_BASE . 'login/loginComToken' ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ token: token })
        })
          .then(response => response.json())
          .then(data => {
            console.log(data);
            if (data.status === 'ok') {
              window.location.href = '<?php echo URL_BASE . 'amigos/Home' ?>';
            }
          })
          .catch(error => {
            console.error('Erro ao verificar o token:', error);
          });
      }
    }

    checkAuth();
  });
</script>