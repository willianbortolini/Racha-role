 <div class="p-1">
                    <?php
                    $this->verMsg();
                    $this->verErro();
                    ?>
                </div>
            <div class="caixa">
				<h2 class="titulo"><span class="case"><i class="ico user"></i>Meu perfil</span> Editar e alterar dados do perfil</h2>
			</div>
			<div class="base-home">
				<div class="rows base-perfil py-3">
				<div class="col-12">
				<div class="caixa">
					<form action="<?php echo URL_BASE . "escola/salvarusuario" ?>" method="POST">
					<fieldset class="mt-1">
					<legend>Dados do cadastro</legend>
					<div class="rows">
						<!--<div class="col-6">
							<label>Foto perfil</label>
							<div class="thumb">
								<img src="img/foto01.png">
								<input type="file" name="" value="">
							</div>
							<small class="text-center d-block">Tamanho máximo: 220px altura x 220px largura</small>
						</div> -->
						
						<div class="col-12">
							<div class="py-1">
								<label>Usuario</label>
								<input type="text" name="usuario" placeholder="Usuario" value="<?php echo ($usuario->usuario) ? $usuario->usuario : NULL; ?>">
							</div>
                                                        <div class="py-1">
								<label>Nome completo</label>
								<input type="text" name="nome_completo" placeholder="Nome" value="<?php echo ($usuario->nome_completo) ? $usuario->nome_completo : NULL; ?>">
							</div>
							<div class="py-1">
								<label>Email</label>
								<input type="text" name="email" placeholder="Email" value="<?php echo ($usuario->email) ? $usuario->email : NULL; ?>">
							</div>
							
						</div>
					</div>
					</fieldset>
					<fieldset>
					<legend>Dados pessoais</legend>
					<div class="rows">
						<div class="col-3 mb-3">
							<label>CPF</label>
							<input type="text" class="mascara-cpf" name="cpf" placeholder="CPF" value="<?php echo ($usuario->cpf) ? $usuario->cpf : NULL; ?>">
						</div>
						<div class="col-3 mb-3">
							<label>Data de nascimento</label>
                                                        <input type="date" name="data_nascimento"  placeholder="Data" value="<?php echo ($usuario->data_nascimento) ? $usuario->data_nascimento : NULL; ?>">
						</div>
						<div class="col-3 mb-3">
							<label>Telefone</label>
							<input type="text" name="telefone"  class="mascara-celular" placeholder="Telefone" value="<?php echo ($usuario->fone) ? $usuario->fone : NULL; ?>">
						</div>
						<div class="col-3 mb-3">
							<label>Profissão</label>
							<input type="text" name="profissao" placeholder="Profissão" value="<?php echo ($usuario->profissao) ? $usuario->profissao : NULL; ?>">
						</div>
					</div>
					</fieldset>
					
					<fieldset>
					<legend>Endereço</legend>
					<div class="rows">
						<div class="col-4 mb-3">
							<label>Bairro</label>
							<input type="text" class="bairro"  name="bairro" placeholder="Bairro" value="<?php echo ($usuario->bairro) ? $usuario->bairro : NULL; ?>">
						</div>
						<div class="col-4 mb-3">
							<label>Cidade</label>
							<input type="text" class="cidade" name="cidade" placeholder="Cidade" value="<?php echo ($usuario->cidade) ? $usuario->cidade : NULL; ?>">
						</div>
						<div class="col-4 mb-3">
							<label>Rua</label>
							<input type="text" class="rua" name="rua" placeholder="Endereço" value="<?php echo ($usuario->rua) ? $usuario->rua : NULL; ?>">
						</div>
					</div>
					<div class="rows">	
						<div class="col-3 mb-3">
							<label>Estado</label>
							<input type="text" class="estado"  name="estado"  value="<?php echo ($usuario->estado) ? $usuario->estado : NULL; ?>">
						</div>	
						<div class="col-3 mb-3">
							<label>CEP</label>
							<input type="text" class="mascara-cep busca_cep" name="cep" placeholder="CEP" value="<?php echo ($usuario->cep) ? $usuario->cep : NULL; ?>">
						</div>
						<div class="col-4 mb-3">
							<label>Complemento</label>
							<input type="text" name="complemento" placeholder="Complemento" value="<?php echo ($usuario->complemento) ? $usuario->complemento : NULL; ?>">
						</div>
						<div class="col-2 mb-3">
							<label>Número</label>
							<input type="text" name="numero" placeholder="Número" value="<?php echo ($usuario->numero) ? $usuario->numero : NULL; ?>">
						</div>
					</div>
					</fieldset>                                            
                                                <input type="submit" value="Atualizar perfil" class="btn btn-verde ">                                               
                                            
                                        </form>
				</div>
				</div>
				</div>
		
		
		
		</div>        
		
		</div>
	