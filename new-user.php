<?php
	include('header.php');
	#echo $Pages->LoadSamplePage(substr(LINK, 1));
	include('load/pages/users.php');
?>
<div class="columns">
    <div class="column is-3">
        <div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
    </div>
</div>
<div class="box content">
	<?php echo $Navegation->HeroMessage(ucfirst('perfil'), 'Informe os dados para '.$selected_type); ?>
	<hr/>
	<section class="info-tiles">
		<form action="#" method="post">
			<div class="columns">
                <div class="column is-6">
					<p class="title is-small">Dados do <?php echo ucfirst($type); ?></p>
					<div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">Nome</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $name_use; ?>" value="<?php echo $name_use; ?>" name="name_use">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">E-mail</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="text" placeholder="<?php echo $email; ?>" name="email" value="<?php echo $email; ?>">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                    </div>
					<div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">Senha</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="password" value="" placeholder="" name="password">
  									<span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
							<div class="field">
  								<label class="label">Repita a Senha</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="password" value="" placeholder="" name="conf_password">
  									<span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                        	<div class="field">
  								<label class="label"><?php echo ucfirst($string); ?></label>
  								<?php echo $input; ?>
							</div>
                        </div>
                    </div>
                    <div class="columns">
                    	<div class="column">
							<div class="field">
  								<label class="label">Data de Nascimento</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="date" placeholder="<?php echo $birthday_date; ?>" value="<?php echo $birthday_date; ?>" name="birthday_date">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    	<div class="column">
							<div class="field">
  								<label class="label">RG</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $rg; ?>" value="<?php echo $rg; ?>" name="rg">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                        	<div class="field">
  								<label class="label">CPF</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $cpf; ?>" value="<?php echo $cpf; ?>" name="cpf">
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Telefone</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $phone; ?>" value="<?php echo $phone; ?>" name="phone">
  									<span class="icon is-small is-left"><i class="fas fa-mobile"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                    <hr />
                    <p class="title is-small">Dados Residenciais do <?php echo ucfirst($type); ?></p>
                    <div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">CEP</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="text" placeholder="<?php echo $cep; ?>" value="<?php echo $cep; ?>" name="cep" id="cep">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Endereço</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $address; ?>" value="<?php echo $address; ?>" name="address" id="address" disabled>
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
					<div class="columns">
						<div class="column">
							<div class="field">
  								<label class="label">Número</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="number" placeholder="<?php echo $number; ?>" value="<?php echo $number; ?>" name="number" id="number">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Bairro</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $neighborhood; ?>" value="<?php echo $neighborhood; ?>" name="neighborhood" id="neighborhood" disabled>
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                    <div class="columns">
                    	<div class="column">
							<div class="field">
  								<label class="label">Cidade</label>
								<div class="control has-icons-left has-icons-right">
									<input class="input is-link" type="text" placeholder="<?php echo $city; ?>" value="<?php echo $city; ?>" name="city" id="city" disabled>
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
								<p class="help is-success"></p>
							</div>
                        </div>
                        <div class="column">
                        	<div class="field">
  								<label class="label">Estado</label>
  								<div class="control has-icons-left has-icons-right">
  									<input class="input is-link" type="text" placeholder="<?php echo $state; ?>" value="<?php echo $state; ?>" name="state" id="state" disabled>
  									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
								</div>
							</div>
                        </div>
                    </div>
                </div>
				<div class="column is-6">
					<div class="columns">
						<div class="column is-6">
							<!--Mudar para Gravatar-->
							<label class="label">Foto</label>
							<div class="field">
		  						<div class="file is-centered is-boxed is-link has-name is-small">
		    						<label class="file-label">
		      							<input class="file-input" type="file" name="photo">
		      							<span class="file-cta">
		        							<span class="file-icon"><i class="fas fa-upload"></i></span>
		        							<span class="file-label">Carregar Foto…</span>
		      							</span>
		      							<span class="file-name">Carregar Foto…</span>
		    						</label>
		    					</div>
		  					</div>
						</div>
						<div class="column is-4">
							<figure class="image is-128x128"><img class="is-rounded" src="<?php echo $photo; ?>"></figure>
		  				</div>
		  			</div>
		  			<hr/>
		  			<?php echo $data; ?>
					<hr/>
					<?php $Pages->LoadTablePage('users'); ?>
				</div>
			</div>
			<div class="columns">
				<div class="column">
					<input class="button is-block is-success is-large is-fullwidth" type="submit" name="<?php echo $type_button; ?>" value="Salvar" />
				</div>
				<div class="column">
					<input class="button is-block is-danger is-large is-fullwidth" type="button" name="cancel" value="Cancelar" />
				</div>
			</div>
		</form>
	</section>
</div>
<p class="subtitle is-6">
	<?php
		if(isset($_POST['save']) || isset($_POST['edit'])){
			#puxar as informações adquiridas
			$name_use = isset($_POST['name_use']) ? $_POST['name_use'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $conf_password = isset($_POST['conf_password']) ? $_POST['conf_password'] : '';
            $birthday_date = isset($_POST['birthday_date']) ? $_POST['birthday_date'] : '';
            $rg = isset($_POST['rg']) ? $_POST['rg'] : '';
            $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $cep = isset($_POST['cep']) ? $_POST['cep'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $number = isset($_POST['number']) ? $_POST['number'] : '';
            $neighborhood = isset($_POST['neighborhood']) ? $_POST['neighborhood'] : '';
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $state = isset($_POST['state']) ? $_POST['state'] : '';

            # Verifica se os campos estão vazios e exibe uma mensagem de erro
	        if (empty($email) || empty($password) || empty($password_conf)) {
	          echo 'Informe o email e a senha.';
	          exit;
	        }

	        if($password != $password_conf){
	          echo 'As duas senhas não conferem';
	          exit;
	        }
		}

		if(isset($_POST['save'])){} elseif(isset($_POST['edit'])){}

		include('footer-admin.php');
	?>
</p>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="assets/js/cep.js"></script>
<script src="assets/js/cpf.js"></script>
<script type="text/javascript">
    function Nova(){
        location.reload();
    }
</script>
</div>