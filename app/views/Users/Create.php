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
                <h2 class="text-center mb-4">Cadastro de Usuário</h2>
                <a href="javascript:void(0);" onclick="window.history.back();" class="btn-close" aria-label="Close"></a>

            </div>
            <div class="modal-body p-5 pt-0">
                <form action="<?PHP echo URL_BASE . 'Users/salvar' ?>" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo (isset($usuarios->email)) ? $usuarios->email : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirmacao">Confirmação de Senha:</label>
                        <input type="password" class="form-control" id="confirmacao" name="confirmacao" required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="politica" name="politica" checked required>
                        <label class="form-check-label" for="politica">Aceito as <a
                                href="<?PHP echo URL_BASE . 'politicaprivacidade' ?>" target="_blank">políticas de
                                privacidade</a>.</label>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="cookies" name="cookies" checked required>
                        <label class="form-check-label" for="cookies">Concordo com o uso de cookies para personalizar
                            minha experiência.</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>