<div class="modal modal-sheet position-static d-block" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Informe uma nova senha</h2>
                <button type="button" class="btn-close" onclick="window.history.back();" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="<?php echo URL_BASE . 'login/redefinirSenhaSalvar'; ?>" method="post">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" name="senha" id="senha" placeholder="Senha">
                        <label for="senha">Senha</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" name="confirmacao" id="confirmacao" placeholder="Confirme a Senha">
                        <label for="confirmacao">Confirmação de Senha</label>
                    </div>
                    <input type="hidden" name="usuarios_id" value="<?php echo $usuario->usuarios_id; ?>">
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>
