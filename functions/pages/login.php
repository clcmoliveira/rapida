<?php
  switch ($Login->IsLogged()) {
    case false:
    	switch($link){
    		case 'login':
    			$title = 'Login';
        		$message = 'Informe os dados para entrar
			          <figure class="image is-128x128 avatar"><img class="is-rounded" src="'.$picture.'"></figure>
			          <form method="post" action="">
			            <div class="field">
			              <div class="control">
			                <input class="input is-large" type="email" name="email" placeholder="'.$placeholder.'" value="'.$email.'" autofocus="">
			              </div>
			            </div>
			            <div class="field">
			              <div class="control">
			                <input class="input is-large" type="password" name="password" placeholder="Sua Senha">
			              </div>
			            </div>
			            <div class="field">
			              <label class="checkbox"><input type="checkbox">&nbsp;Lembre-me</label>
			            </div>
			            <input class="button is-block is-info is-large is-fullwidth" type="submit" name="signin" value="Entrar" />
			          </form>';
			          $links[1] = SERVER.'signup'; 
			          $links[2] = 'Cadastrar';
			          $links[3] = SERVER.'forgot-pass'; 
			          $links[4] = 'Recuperar Senha';

			          if(isset($_POST['signin'])) {
			            # Resgata variáveis do formulário
			            $email = isset($_POST['email']) ? $_POST['email'] : '';
			            $password = isset($_POST['password']) ? $Tables->HashStr($_POST['password']) : '';
			            # Verifica se os campos estão vazios e exibe uma mensagem de erro
			            if (empty($email) || empty($password)) {
			              echo 'Informe email e/ou senha.'; exit;
			            }
			                        
			            # Verificar se o usuário existe e se a senha é a mesma     
			            $stmt = $PDO->prepare($Tables->SelectFrom(null, 'users WHERE email LIKE :email AND password LIKE :password AND status_use = 1', 0, 1));
			            $stmt->bindParam(':email', $email);
			            $stmt->bindParam(':password', $password);
			            $stmt->execute();
			            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
			            if (count($users) <= 0) {
			              echo 'Email ou senha incorretos. Deseja <strong><a href="forgot-pass?email='.$email.'">recuperar</a></strong>?'; exit;
			            }
			            # Busca os resultados e os cataloga com a variável $_SESSION
			            $user = $users[0];
			            $_SESSION['logged_in'] = true;    
			            $_SESSION['id'] = $user['id_use'];
			            $_SESSION['name'] = $user['name_use'];
			            $Load->Link();
			          }
    		break;
    		case 'forgot-pass':
    			$title = 'Recuperar';
		        $message = 'Informe o e-mail para recuperar seu acesso
		          <figure class="image is-128x128 avatar"><img class="is-rounded" src="'.$picture.'"></figure>
		          <form method="post" action="">
		            <div class="field">
		              <div class="control">
		                <input class="input is-large" type="email" name="email" placeholder="'.$placeholder.'" value="'.$email.'" autofocus="">
		              </div>
		            </div>
		            <input class="button is-block is-info is-large is-fullwidth" type="submit" name="recover" value="Recuperar" />
		          </form>';
		          $links[1] = 'login'; 
		          $links[2] = 'Entrar';
		          $links[3] = 'signup'; 
		          $links[4] = 'Cadastrar';

		          if(isset($_POST['recover'])) {
		            # Resgata variáveis do formulário
		            $email = isset($_POST['email']) ? $_POST['email'] : '';

		            # Verifica se os campos estão vazios e exibe uma mensagem de erro
		            if (empty($email)) {
		              echo 'Informe email.'; exit;
		            }

		              # Verifica se o usuário existe e exibe ou uma mensagem de erro ou vai ao cadastro
		              $con = $PDO->prepare($Tables->SelectFrom(null, 'users WHERE email = '.$email.' AND status_use = 1')) or die ($PDO);
		              if(count($con) == 1){
		                $password = $Tables->HashStr($Load->RandomPass());

		                $stmt = $PDO->prepare($Tables->SelectFrom(null, 'users WHERE email = '.$email.' AND password = :password AND status_use = 1'));
		                $stmt->bindParam(':password', $password);
		                $stmt->execute();
		                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		                if (count($users) <= 0) {
		                  echo 'Um erro aconteceu'; exit;
		                }

		                # Busca os resultados e os cataloga com a variável $_SESSION
		                $user = $users[0];
		                $_SESSION['logged_in'] = true;
		                  
		                $_SESSION['id'] = $user['id_use'];
		                $_SESSION['name'] = $user['name_use'];
		                $Load->Link('profile');
		                //$password = $Tables->HashStr();
		                //echo 'Sua nova senha é '.$password;
		                //echo 'Sua nova senha será encaminhada por email';
		              }
		          }
    		break;
    		case 'signup':
				$title = 'Cadastrar';
		        $message = 'Informe os dados para cadastrar
		            <figure class="image is-128x128 avatar"><img class="is-rounded" src="'.$Load->Gravatar().'"></figure>
		            <form method="post" action="" method="POST">
		              <div class="field">
		                <div class="control">
		                  <input class="input is-large" type="email" name="email" placeholder="Seu E-mail" autofocus="">
		                </div>
		              </div>
		              <div class="field">
		                <div class="control">
		                  <input class="input is-large" type="password" name="password" placeholder="'.$password.'" autofocus="">
		                </div>
		              </div>
		              <div class="field">
		                <div class="control">
		                  <input class="input is-large" type="password" name="password_conf" placeholder="'.$password_conf.'" autofocus="">
		                </div>
		              </div>
		              <div class="field" id="type_use">
		                <label class="label">Tipo de Usuário</label>
		                  <div class="control has-icons-left">
		                    <div class="select is-hovered is-link">
		                      <select name="type_use">
		                        <option value="1">Diretor</option>
		                        <option value="2">Coordenador</option>
		                        <option value="3">Funcionário</option>
		                        <option value="4" disabled>Professor</option>
		                        <option value="5" disabled>Aluno</option>
		                      </select>
		                    </div>
		                    <span class="icon is-small is-left"><i class="fas fa-chalkboard-teacher"></i></span>
		                  </div>
		                </div>
		              <div class="field"><label class="checkbox"><input type="checkbox">&nbsp;Aceito os Termos</label></div>
		              <input class="button is-block is-info is-large is-fullwidth" type="submit" name="signup" value="Cadastrar" />
		            </form>';
		        $links[1] = 'login'; 
		        $links[2] = 'Entrar';
		        $links[3] = 'forgot-pass'; 
		        $links[4] = 'Recuperar Senha';

		        if(isset($_POST['signup'])) {
		          # Resgata variáveis do formulário
		          $email = isset($_POST['email']) ? $_POST['email'] : '';
		          $password = isset($_POST['password']) ? $_POST['password'] : '';
		          $password_conf = isset($_POST['password_conf']) ? $_POST['password_conf'] : '';

		          # Verifica se os campos estão vazios e exibe uma mensagem de erro
		          if (empty($email) || empty($password) || empty($password_conf)) {
		            echo 'Informe o email e a senha.'; exit;
		          }

		          if($password != $password_conf){
		            echo 'As duas senhas não conferem'; exit;
		          }

		          # Verifica se o usuário existe e exibe ou uma mensagem de erro ou vai ao cadastro
		          $con = $PDO->prepare($Tables->SelectFrom(null, 'users WHERE email LIKE '.$email.' AND status_use = 1', 0, 1)) or die ($PDO);
		          if(count($con) == 1){
		            echo 'E-mail já existe. Deseja <strong><a href="forgot-pass?email='.$email.'">recuperar sua senha</a></strong> ou <strong><a href="login?email='.$email.'">fazer login</a></strong>?'; exit;
		          }

		          # Gerar a critografia da senha
		          $password = $Tables->HashStr($password);
		          $photo = $Load->Gravatar($email);

		          $stmt = $PDO->prepare("INSERT INTO users (email, password, photo, type_use) VALUES (:email, :password, :photo, 1)");
		          $stmt->bindParam(':email', $email);
		          $stmt->bindParam(':password', $password);
		          $stmt->bindParam(':photo', $photo);
		          $result = $stmt->execute();
		          if ($result){
		            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		            if (count($users) <= 0) {
		              echo 'Ops, houve um erro aqui.'; exit;
		            }

		            # Busca os resultados e os cataloga com a variável $_SESSION
		            $user = $users[0];
		            $_SESSION['logged_in'] = true;
		            $_SESSION['id'] = $user['id_use'];
		            $_SESSION['name'] = $user['name_use'];
		            #redireciona para a página de perfil aonde ele finalizará o cadastro  
		            $Load->Link('profile');
		          }
		        }
    		break;
    	}
    break;
    case true:
        $title = 'Ops';
        $message = 'Sessão já inicializada';
        $links[1] = SERVER; 
        $links[2] = 'Início';
        $links[3] = '#'; 
        $links[4] = 'Voltar aonde estava';
      break;
    }
  include('functions/ops.php');