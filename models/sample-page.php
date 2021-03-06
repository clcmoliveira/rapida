	<div class="columns">
		<div class="column">
			<div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
		</div>
		<?php
			switch($link){
				case SERVER: case 'change': case 'documents': case 'ops': break;
				case 'reserve': case 'schedule-grid':
				?>
				<div class="column">
					<div class="tabs is-right">
					  	<ul>
					    	<li class="is-active">
					      		<a href="">
					        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
					        		<span>Todos</span>
					        	</a>
					        </li>
					        <li>
					        	<a href="reserve">
					        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
					        		<span class="content is-link">Reserva de Sala</span>
					    		</a>
					    	</li>
					    	<li>
					    		<a href="reserve">
					    			<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
					    			<span class="content is-danger">Manutenção</span>
					    		</a>
					    	</li>
						</ul>
					</div>
				</div>
				<?php
				break;
				default:
		?>
		<div class="column">
			<div class="tabs is-right">
			  	<ul>
			    	<li class="is-active">
			      		<a href="">
			        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
			        		<span>Todos</span>
			        	</a>
			        </li>
			        <li>
			        	<a href="?type=1">
			        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
			        		<span class="content is-link">Ativos</span>
			    		</a>
			    	</li>
			    	<li>
			    		<a href="?type=2">
			    			<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
			    			<span class="content is-danger">Inativos</span>
			    		</a>
			    	</li>
			    	<!--<li>
			    		<a>
			    			<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
			    			<span class="content is-blak">Add Turma</span>
			    		</a>
			    	</li>-->
				</ul>
			</div>
		</div>
		<?php
			break;
		}
		?>
	</div>
	<div class="box content">
		<?php
			switch($link){
				case 'change': case 'ops': break;
				case 'classroom': case 'historic': case 'schedule-grid':
					echo $Navegation->HeroMessage().'<hr/>';
					echo $Pages->LoadSuperTablePage();
				break;
				case 'new-user': case 'profile':
					echo $Navegation->HeroMessage().'<hr/>';
					?>
					<section class="info-tiles">
						<form action="" method="post">
							<div class="columns">
								<div class="column">
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
										  			<input class="input is-link" type="password" value="" placeholder="" name="password_conf">
										  			<span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
														<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
												</div>
											</div>
										</div>
									</div>
									<div class="columns">
										<?php
											if(LINK == 'new-user'){
										?>
										<div class="column">
											<div class="field" id="type_cou">
								         		<label class="label">Tipo</label>
								            	<div class="control has-icons-left">
								                    <label class="radio">
								                    	<input type="radio" name="type_cou" value="1" <?php echo $checked1; ?> onclick="Change('area')" onclick="Change('classroom')"> Diretor
								                    </label><br/>
								                    <label class="radio">
								                    	<input type="radio" name="type_cou" value="2" <?php echo $checked2; ?> onclick="Change('area')" onclick="Change('classroom')"> Coordenador
								                    </label><br/>
								                    <label class="radio">
								                    	<input type="radio" name="type_cou" value="3" <?php echo $checked3; ?> onclick="Change('area')" onclick="Change('classroom')"> Funcionário
								                    </label><br/>
								                    <label class="radio">
								                    	<input type="radio" name="type_cou" value="4" <?php echo $checked4; ?> onclick="Change('area')" onclick="Change('classroom')"> Professor
								                    </label><br/>
								                    <label class="radio">
								                        <input type="radio" name="type_cou" value="5" <?php echo $checked5; ?> onclick="Change('classroom')" onclick="Change('area')"> Aluno
								                    </label>
								                </div>
								            </div>
										</div>
										<div class="column">
											<div class="field" id="area" style="display: none;">
										        <label class="label">Área</label>
											    <div class="control has-icons-left has-icons-right">
													<input class="input is-link" type="text" placeholder="<?php echo $area; ?>" value="<?php echo $area; ?>" name="area">
													<span class="icon is-small is-left"><i class="fas fa-chalkboard-teacher"></i></span>
													<span class="icon is-small is-right"><i class="fas fa-check"></i></span>
												</div>
											</div>
											<div class="field" id="classroom" style="display: none;">
												<label class="label">Turma</label>
				                                <div class="control has-icons-left has-icons-right">
					                            	<div class="select is-hovered is-link">
					                                    <select name="classroom">
					                                        <option value="M">Manhã</option>
					                                        <option value="T">Tarde</option>
					                                        <option value="N">Noite</option>
					                                    </select>
					                            	</div>
				                                	<span class="icon is-small is-left"><i class="fas fa-chalkboard-teacher"></i></span>
				                            	</div>
				                        	</div>
										</div>
										<?php
									} else {
										?>
										<div class="column">
				                        	<div class="field">
				  								<label class="label"><?php echo ucfirst($string); ?></label>
				  								<?php echo $input; ?>
											</div>
				                        </div>
				                        <?php
				                    }
				                    ?>
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
													<input class="input is-link" type="phone" placeholder="<?php echo $phone; ?>" value="<?php echo $phone; ?>" name="phone">
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
								<div class="column">
									<div class="columns">
										<div class="column">
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
										<div class="column">
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
					<?php
				break;
				case 'notifies':
					echo $Navegation->HeroMessage().'<hr/>';
				break;
				case 'employees': case 'students': case 'teachers': case 'directors' : case 'coordinators': 
					echo $Navegation->HeroMessage().'<hr/>';
					echo $Pages->LoadArticlePage();
				break;
				case 'reserve':
					echo $Navegation->HeroMessage().'<hr/>';
					?>
					<section class="info-tiles">
                    <form action="" method="post">
                        <div class="columns">
                            <div class="column">
                                <p class="title is-small">Dados da Reserva</p>
                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
		                                    <label class="label">Dia da Semana</label>
		                                    <div class="control has-icons-left">
		                                        <div class="select is-hovered is-link">
		                                            <select name="day_class">
		                                                <option value="1">Segunda</option>
		                                                <option value="2">Terça</option>
		                                                <option value="3">Quarta</option>
		                                                <option value="4">Quinta</option>
		                                                <option value="5">Sexta</option>
		                                                <option value="6">Sábado</option>
		                                            </select>
		                                        </div>
		                                        <span class="icon is-small is-left"><i class="fas fa-day"></i></span>
		                                    </div>
                                        </div>
                                    </div>
                                   	<div class="column">
                                        <div class="field">
		                                    <label class="label">Sala</label>
		                                    <div class="control has-icons-left">
		                                        <div class="select is-hovered is-link">
		                                            <select name="classroom">
		                                                <option value="Laboratório 1">Laboratório 1</option>
		                                                <option value="Laboratório 2">Laboratório 2</option>
		                                                <option value="Laboratório Multiuso 1">Laboratório Multiuso 1</option>
		                                                <option value="Laboratório Multiuso 2">Laboratório Multiuso 2</option>
		                                                <option value="Laboratório Segurança do Trabalho">Laboratório Segurança do Trabalho</option>
		                                                <option value="Biblioteca">Biblioteca</option>
		                                                <option value="Auditório">Auditório</option>
		                                            </select>
		                                        </div>
		                                        <span class="icon is-small is-left"><i class="fas fa-day"></i></span>
		                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                    	<label class="label">Horário Inicial</label>
                                        <div class="field">
							                <div class="control has-icons-left">
							                  	<input class="input is-large" type="time" name="time_start" placeholder="" autofocus="">
							                  	<span class="icon is-small is-left"><i class="fas fa-clock"></i></span>
							                </div>
						              	</div>
                                    </div>
                                    <div class="column">
                                    	<label class="label">Horário Final</label>
                                        <div class="field">
							                <div class="control has-icons-left">
							                  	<input class="input is-large" type="time" name="time_start" placeholder="" autofocus="">
							                  	<span class="icon is-small is-left"><i class="fas fa-clock"></i></span>
							                </div>
						              	</div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <?php $Pages->LoadTablePage($link); ?>
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
					<?php
				break;
				default:
				break;
			}
		?>
	</div>
	<p class="subtitle-is-6 has-text-centered">
		<?php
			switch($link){
				case 'change': echo $res; break;
				case 'profile': case 'new-user':
					if(isset($_POST['save']) || isset($_POST['edit'])){
						#puxar as informações adquiridas
						$type_use = isset($_POST['type_use']) ? $_POST['type_use'] : '';
			        	$name_use = isset($_POST['name_use']) ? $_POST['name_use'] : '';
			        	$login = isset($row->login) ? $row->login : strstr($name_use, ' ');
			        	$password = isset($_POST['password']) ? $_POST['password'] : '';
			        	$password_conf = isset($_POST['password_conf']) ? $_POST['password_conf'] : '';
			        	$email = isset($_POST['email']) ? $_POST['email'] : '';
			        	$cep = isset($_POST['cep']) ? $_POST['cep'] : '';
			        	$birthday_date = isset($_POST['birthday_date']) ? $_POST['birthday_date'] : '';
						$rg = isset($_POST['rg']) ? $_POST['rg'] : '';
						$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
						$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
						$address = isset($_POST['address']) ? $_POST['address'] : '';
						$number = isset($_POST['number']) ? $_POST['number'] : '';
						$neighborhood = isset($_POST['neighborhood']) ? $_POST['neighborhood'] : '';
						$city = isset($_POST['city']) ? $_POST['city'] : '';
						$state = isset($_POST['state']) ? $_POST['state'] : '';

						# Verifica se os campos estão vazios e exibe uma mensagem de erro
						if (empty($name_use) || empty($password) || empty($password_conf) || empty($email) || empty($cep) || empty($birthday_date)){
							echo 'Informe os dados obrigatórios.'; 
							exit;
						}
						if($password != $password_conf){
							echo 'As duas senhas não conferem.'; 
							exit;
						}

						#Verificar se usuário está registrado por meio do e-mail
				        $con = $PDO->query($Tables->SelectFrom('email, type_use', 'users')) or die ($PDO);
				        while ($row = $con->fetch(PDO::FETCH_OBJ)){
				        	if ($row->email == $email && $row->type_use == $type_use){
				        		echo 'Usuário já está registrado.</br>'; exit;
				        	}
				        }
				        $password = $Tables->HashStr($password);

				        if(isset($_POST['save'])){
				        	$stmt = $PDO->prepare("INSERT INTO users (type_use, status_use, signup_date, name_use, password, email, photo, cep, address, number, neighborhood, city, state, rg, cpf, phone, birthday_date) VALUES (:type_use, 1, ".TODAY.", :name_use, :password, :email, :photo, :cep, :address, :number, :neighborhood, :city, :state, :rg, :cpf, :phone, :birthday_date)");

							$stmt->bindParam(':type_use', $type_use);
					        $stmt->bindParam(':name_use', $name_use);
					        $stmt->bindParam(':password', $password);
					        $stmt->bindParam(':email', $email);
					        $stmt->bindParam(':photo', $photo);
					        $stmt->bindParam(':cep', $cep);
					        $stmt->bindParam(':address', $address);
					        $stmt->bindParam(':number', $number);
					        $stmt->bindParam(':neighborhood', $neighborhood);
					        $stmt->bindParam(':city', $city);
					        $stmt->bindParam(':state', $state);
					        $stmt->bindParam(':rg', $rg);
					        $stmt->bindParam(':cpf', $cpf);
					        $stmt->bindParam(':phone', $phone);
					        $stmt->bindParam(':birthday_date', $birthday_date);
				        } else if(isset($_POST['edit'])){
							$stmt = $PDO->prepare("UPDATE `users` SET `name_use` = :name_use, `password` = :password, `email` = :email, `photo` = :photo, `cep` = :cep, ,`address` = :address, ,`number` = :number, ,`neighborhood` = :neighborhood, ,`city` = :city, ,`state` = :state, ,`rg` = :rg, ,`cpf` = :cpf, ,`phone` = :phone, ,`birthday_date` = :birthday_date,  WHERE id_use = ".$_SESSION['id']);
							$stmt->bindParam(':name_use', $name_use);
					        $stmt->bindParam(':password', $password);
					        $stmt->bindParam(':email', $email);
					        $stmt->bindParam(':photo', $photo);
					        $stmt->bindParam(':cep', $cep);
					        $stmt->bindParam(':address', $address);
					        $stmt->bindParam(':number', $number);
					        $stmt->bindParam(':neighborhood', $neighborhood);
					        $stmt->bindParam(':city', $city);
					        $stmt->bindParam(':state', $state);
					        $stmt->bindParam(':rg', $rg);
					        $stmt->bindParam(':cpf', $cpf);
					        $stmt->bindParam(':phone', $phone);
					        $stmt->bindParam(':birthday_date', $birthday_date);
				        }

				        $result = $stmt->execute();
				        if ($result){
				        	$id = (LINK == 'new-user') ? $PDO->lastInsertId() : $_SESSION['id'];
				        	$type = (LINK == 'new-user') ? 'cadastrado' : 'atualizado';
				        	echo 'Usuário '.$type.' com sucesso. Para editar, entre no <a href="profile?id='.$id.'">link</a>.</br>';
				        } else {
				        	print_r($stmt->errorInfo()); exit;
				        }
					}
				break;
				case 'reserve':
					if(isset($_POST['save'])){
						$day_class = isset($_POST['day_class']) ? $_POST['day_class'] : '';
						$classroom = isset($_POST['classroom']) ? $_POST['classroom'] : '';
						#$time_start = isset($_POST['time_start']) ? $_POST['time_start'] : '';
						#$time_end = isset($_POST['time_end']) ? $_POST['time_end'] : '';

						$stmt = $PDO->prepare("
			          		INSERT INTO reserve (day_class, classroom) 
			          		VALUES (:day_class, :classroom)");
			          	
						$stmt->bindParam(':day_class', $day_class, PDO::PARAM_STR);
			          	$stmt->bindParam(':classroom', $classroom, PDO::PARAM_STR);
			          	#$stmt->bindParam(':time_start', $time_start, PDO::PARAM_STR);
			          	#$stmt->bindParam(':time_end', $time_end, PDO::PARAM_STR);		          	
			          	$result = $stmt->execute();
			          	if ($result){
			          		echo 'Reserva salva com sucesso.';
			          	} else{
			          		print_r($stmt->errorInfo());
			          	}
					}
				break;
			}
		?>
	</p>