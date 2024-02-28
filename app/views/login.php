<div class="ml-1 mr-2">
  <?php
  $this->verMsg();
  $this->verErro();
  ?>
</div>
<div class="modal modal-sheet position-static d-block" tabindex="-1" role="dialog" id="modalSignin">

  <div class="modal-dialog" role="document">

    <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Bem vindo de volta!</h1>
        <a href="javascript:void(0);" onclick="window.history.back();" class="btn-close" aria-label="Close"></a>

      </div>
      <div class="modal-body p-5 pt-0">
        <form class="" action="<?php echo URL_BASE . "login/logar" ?> " method="post">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" name="email" id="floatingInput"
              placeholder="name@example.com">
            <label for="floatingInput">Endereço de email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" name="senha" id="floatingPassword"
              placeholder="Password">
            <label for="floatingPassword">Senha</label>
          </div>
          <small class="text-body-secondary"><a href="<?php echo URL_BASE . "login/esqueci" ?>">Esqueci minha senha
            </a></small>
          <hr class="my-4">
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Login</button>
          <small class="text-body-secondary">Não tem uma conta? <a
              href="<?php echo URL_BASE   . "usuario/create" ?>">Inscrever-se</a></small>
          <hr class="my-4">
          <a href="<?php echo $authUrl; ?>" class="w-100 py-2 mb-2 btn btn-outline-secondary rounded-3" type="submit">
            <i class="bi bi-google"></i>
            Login com Google
          </a>

        </form>
      </div>
    </div>
  </div>
</div>