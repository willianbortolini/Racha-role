<div class="modal modal-sheet position-static d-block" tabindex="-1" role="dialog" id="modalSignin">

	<div class="modal-dialog" role="document">

		<div class="modal-content rounded-4 shadow">
			<div class="modal-header p-5 pb-4 border-bottom-0">
				<h1 class="fw-bold mb-0 fs-2">Informe uma nova senha</h1>
				<a href="javascript:void(0);" onclick="window.history.back();" class="btn-close" aria-label="Close"></a>
			</div>
			<div class="modal-body p-5 pt-0">
				<form class="" action="<?php echo URL_BASE   . "login/redefinirSenhaSalvar" ?>" method="post">
					<div class="form-floating mb-3">
						<input type="password" class="form-control rounded-3" name="senha" id="senha" placeholder="Password">
						<label for="senha">Senha</label>
					</div>
					<div class="form-floating mb-3">
						<input type="password" class="form-control rounded-3" name="confirmacao" id="confirmacao" placeholder="Password">
						<label for="confirmacao">Confirmação senha</label>
					</div>
					<input type="hidden" name="usuarios_id" value="<?php echo $usuario->usuarios_id ?>">
					<button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Salvar</button>
				</form>
			</div>
		</div>
	</div>
</div>