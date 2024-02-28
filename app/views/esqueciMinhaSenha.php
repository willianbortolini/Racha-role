<div class="modal modal-sheet position-static d-block" tabindex="-1" role="dialog" id="modalSignin">

  <div class="modal-dialog" role="document">

    <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Qual o seu e-mail?</h1>
        <a href="javascript:void(0);" onclick="window.history.back();" class="btn-close" aria-label="Close"></a>
      </div>
      <div class="modal-body p-5 pt-0">
        <form class="" action="<?php echo URL_BASE   . "login/recuperarSenha" ?> " method="post">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" name="email" id="email" placeholder="name@example.com">
            <label for="email">Endereço de email</label>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Solicitar</button>
        </form>
        <small class="text-body-secondary">Um e-mail de recuperação de senha sera enviado para o e-mail informado.</small>
      </div>
    </div>
  </div>
</div>