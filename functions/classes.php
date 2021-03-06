<?php
	# Lista de páginas e suas respectivas funcionalidades
	# Classe Referente ao Login
  	class Login { 
        # 1 - Retorna se o usuário logou
        function IsLogged() {
        	return (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) ? false : true;
        }
    }
    $Login = new Login;

    # Classe referente as Tabelas
  	class Tables {
		# 1.1 - Localizar uma coluna de uma tabela para carregar seus dados
	    function Found_Item($item, $name_table){
	    	return $item.'_'.substr($name_table, 0, 3);
	    }
	    
	    # 1 - Carregar todos os dados (ou específicos) de uma tabela através do string informado
	    function SelectFrom($item = null, $name_table, $limit = array()){
	    	$Tables = new Tables;
	    	switch ($item) {
	    		case 'COUNT': $sql = 'SELECT COUNT('.$name_table.'.'.$Tables->Found_Item('id', $name_table).') AS qt'; break;
	    		case null: $sql = 'SELECT *'; break;
	    		default: $sql = 'SELECT '.$item; break;
	    	}
	    	return $sql .= (!$limit) ? ' FROM '.$name_table : ' FROM '.$name_table.' LIMIT '.$limit[1].', '.$limit[2];
	    }
	    
	    # 2 - Cria o Hash da Senha, usando MD5 e SHA-1
	    function HashStr($password){
	    	return sha1(md5($password));
	    }
	    
	    # 3 - Busca uma determinada linha da tabela //a desenvolver
	    function SearchId($name_table){
	     	return isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	    }
	    
	    # 4 - Conta os registros de uma tabela ou de uma busca //a aprimorar
	    function CountViewTable($type = null, $name_table = LINK, $item = null){
	    	$Load = new Load;
	    	$Tables = new Tables;
	      	$PDO = $Load->DataBase();
	      	$sizeof = array();
	      	$sizeof[1] = strlen($name_table);
	      	$sizeof[2] = strlen(strstr($name_table, ', '));
	      	$calc = ($sizeof[1] - $sizeof[2]);
	      	#echo $calc;
	      	$name_table_2 = substr($name_table, 0, $calc);
	      	switch ($type) {
	      		case 'search':
	      			$q = isset($_GET['q']) ? $_GET['q'] : '';
	      			$qt = count($PDO->prepare($Tables->SelectFrom('COUNT', $name_table_2)." WHERE ".$item." LIKE '%".$q."%' ORDER BY ".$item));
	      		break;
	      		case null:
	      		default:
	      			#echo $Tables->SelectFrom('COUNT('.$name_table_2.'.'.$Tables->Found_Item('id', $name_table_2).') AS qt', $name_table);
	      			$con = $PDO->query($Tables->SelectFrom('COUNT('.$name_table_2.'.'.$Tables->Found_Item('id', $name_table_2).') AS qt', $name_table)) or die ($PDO);
	      			while($row = $con->fetch(PDO::FETCH_OBJ)){
	        			$qt = $row->qt;
	      			}
	      		break;
	      	}
	      	return $qt;
	    }
	    
	    # 5 - Deleta um registro do sistema // a desenvolver
	    function DeleteId($name_table){
	    	$Load = new Load;
	    	$Tables = new Tables;
	    	$PDO = $Load->DataBase();
	    	$con = $PDO->query('DELETE FROM '.$name_table.' WHERE '.$Tables->FoundId($name_table).' = '.$Tables->SearchId($name_table)) or die ($PDO);
	    	if ($con) {
	    	  return $Load->Link($name_table);
	    	} else {
	    	  //return messageShow('error', $_SERVER['REQUEST_URI'], $str);
	    	}
	    }
  	}
  	$Tables = new Tables;

  	# Classe Referente ao Carregamento das Atribuições, Variáveis
	class Load {
		# 1 - Conexão com o BD
	    function DataBase() {
	    	$pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8', DB_USER, DB_PASS);
	    	$pdo->exec('set names utf8');
	    	return $pdo;
	    }
		
		# 2 Verifica se o server é https e printa a URL do link
	    function Server() {
	     	return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://'.$_SERVER["SERVER_NAME"].'/' : 'http://'.$_SERVER["SERVER_NAME"].'/';
	    }
	    
	    # 3 - Redirecionamento de URL
	    function Link($name_page = null) {
	      	return header('Location: '.SERVER.''.$name_page);
	    }
	    
	    # 4 - Descobrir o link para gerar o Load page
	    function DiscoverLink($link = LINK, $sizeof = false){
	    	if ($link != 'login')
	    		$link = (isset($_GET['id'])) ? substr($link, 0, $sizeof) : $link;
	    	else
         		$link = (isset($_GET['email'])) ? substr($link, 1) : $link;
         	return $link;
	    }
	    
	    # 5 - Gerador de Senha Aleatória
	    function RandomPass($size = 10, $ma = true, $mi = true, $nu = true, $si = false){
	    	#letras maiusculas e minusculas
	    	foreach(range('a', 'z') as $mi) {
	    		$mi;
	    		$ma = strtoupper($mi);
	    	}
	    	#numeros
		 	foreach(range(0, 9) as $nu) { $nu; }
		 	#simbolos
		 	foreach(range('!', '+') as $si) { $si; }
		 
		 	if ($ma || $mi || $nu || $si){
		 		$password = str_shuffle($ma); 		# se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($mi);		# se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($nu);		# se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
		        $password .= str_shuffle($si);		# se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
		    }
	    	return substr(str_shuffle($password), 0, $size);	# retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
		}
		
		# 5 - Exibe a imagem gravada no BD ou a imagem gravada no site Gravatar.com
		function Gravatar($email = MAIN_EMAIL, $s = 240, $d = 'mp', $r = 'g', $img = false, $atts = array(), $photo = ''){
			$Load = new Load;
			$Tables = new Tables;
			$Login = new Login;
			$PDO = $Load->DataBase();
			switch ($Login->IsLogged()) {
				case false: 
					$email = (isset($_GET['email'])) ? $_GET['email'] : $email; 
				break;
				case true:
					switch (LINK) {
						case 'classroom':
							$con = $PDO->query($Tables->SelectFrom(null, 'students, users WHERE students.id_use = users.id_use')) or die ($PDO);
							while($row = $con->fetch(PDO::FETCH_OBJ)) {
								$email = $row->email;
								$photo = strstr(isset($row->photo), 'gravatar.com') ? $row->photo : isset($row->photo) ? 'uploads/'.$row->photo : '';
							}
						break;
						case 'employees': case 'teachers': case 'students':
							$con = $PDO->query($Tables->SelectFrom($Tables->Found_Item('id', LINK).' AS id', LINK.', users WHERE '.LINK.'.id_use = users.id_use')) or die ($PDO);
							while($row = $con->fetch(PDO::FETCH_OBJ)) {
								$email = $row->email;
								$photo = strstr(isset($row->photo), 'gravatar.com') ? $row->photo : isset($row->photo) ? 'uploads/'.$row->photo : '';
							}
						break;
						case 'profile': case 'profile?id='.$_GET['id']:
							$id = (LINK == 'profile?id='.$_GET['id']) ? $_GET['id'] : $_SESSION['id'];
							$con = $PDO->query($Tables->SelectFrom(null, 'users WHERE id_use = '.$id)) or die ($PDO);
							while($row = $con->fetch(PDO::FETCH_OBJ)) {
								$email = $row->email;
								$photo = strstr(isset($row->photo), 'gravatar.com') ? $row->photo : isset($row->photo) ? 'uploads/'.$row->photo : '';
							}
						break;
					}
				break;
			}
			
			if(!$photo){
				$url = 'https://www.gravatar.com/avatar/';
			    $url .= md5(strtolower(trim($email)));
			    $url .= "?s=$s&d=$d&r=$r";
			    if ($img) {
			    	$url = '<img src="'.$url.'"';
			        foreach ($atts as $key => $val)
			            $url .= ' '.$key.'="'.$val.'"';
			        $url .= ' />';
			    }
			    $photo = $url;
			}
            return $photo;
		}

		function WhatLink($link = LINK){
			switch ($link) {
				case 'coordinators': $str = 'Coordenadores'; break;
		    	case 'classroom': $str = 'Turmas'; break;
		    	case 'courses': $str = 'Cursos'; break;
		    	case 'directors': $str = 'Diretores'; break;
		    	case 'disciplines': $str = 'Disciplinas'; break;
		    	case 'documents': $str = 'Documentos'; break;
		    	case 'employees': $str = 'Funcionários'; break;
		    	case 'forgot-pass': $str = 'Esqueceu a Senha'; break;
		    	case 'historic': $str = 'Notas'; break;
		    	case 'login': $str = 'Entrar'; break;
		    	case 'logout': $str = 'Sair'; break;
		    	case 'new-user': $str = 'Cadastro'; break;
		   		case 'notifies': $str = 'Notificações'; break;
		    	case 'profile': $str = 'Perfil'; break;
		    	case 'reserve': $str = 'Reserva'; break;
		    	case 'schedule-grid': $str = 'Horários'; break;
		    	case 'signup': $str = 'Cadastrar'; break;
		    	case 'students': $str = 'Estudantes'; break;
				case 'teachers': $str = 'Professores'; break;
				case 'terms': $str = 'Termos'; break;
	    		case 'new-user': $str = 'Cadastro'; break;
	    		case 'users' : $str = 'Usuários'; break;
	    		default: $str = ''; break;
		    }
		    return $str;
		}

		#7 - retorna se usuário é ou não de tal tipo selecionado
        function IsUserTheseType($type_use = 5){
        	$Load = new Load;
        	$Tables = new Tables;
        	$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
        	$PDO = $Load->DataBase();
        	$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$id)) or die($PDO);
        	while ($row = $con->fetch(PDO::FETCH_OBJ)) {
        		$type = $row->type_use;
        	}
        	return $type;
        }

        function Background($folder = '../assets/backgrounds/', $i = 0){
			$archives = glob("$folder{*.jpg,*.JPG,*.png,*.gif,*.bmp}", GLOB_BRACE);
			$images = array();
			foreach($archives as $img){
			    $images[] = $img;
			    $i++;
			}
			return $images[rand(1, $i)];
		}
	}
	$Load = new Load;
	define('SERVER', $Load->Server());

	# Classe Referente a Navegação das Páginas
	class Navegation {
		# 1 - Gera o Menu de topo se o usuário estiver logado. Menu irá variar de acordo com o tipo de usuário
	    function HeroMenu(
	    	$menu = '
		    	<div class="hero-head">
		        		<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
						  	<div class="navbar-brand">
							    <a class="navbar-item is-logo" href="'.SERVER.'">rÁpidA</a>
							    <div class="navbar-burger burger" data-target="navMenubd-example">
							    	<span></span>
							    	<span></span>
							    	<span></span>
							    </div>
						  	</div>
	                    	<div id="navMenubd-example" class="navbar-menu">
		    					<div class="navbar-start">'
		){
	    	$Load = new Load;
	    	$Tables = new Tables;
	        $Login = new Login;
			switch ($Login->IsLogged()) {
	            case true:
	    			$PDO = $Load->DataBase();
	    			$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
	    			while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($row->type_use){
							case 1:
							case 2:
							case 3: 
								#diretor, coordenador e funcionário estão unificados no momento
								$menu .= '
	    							<div class="navbar-item has-dropdown is-hoverable">
		        						<a class="navbar-link is-active" href="#"><i class="fas fa-users"></i>&nbsp;Usuários</a>
		        						<div class="navbar-dropdown ">
		        							<a class="dropdown-item " href="'.SERVER.'new-user">'.$Load->WhatLink('new-user').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'employees">'.$Load->WhatLink('employees').'</a>
		        							<hr class="navbar-divider">
		        							<a class="dropdown-item " href="'.SERVER.'teachers">'.$Load->WhatLink('teachers').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'#">'.$Load->WhatLink('coordinators').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'#">'.$Load->WhatLink('directors').'</a>
		        							<hr class="navbar-divider">
		        							<a class="dropdown-item " href="'.SERVER.'students">'.$Load->WhatLink('students').'</a>
		        							<!--<a class="dropdown-item" href="'.SERVER.'classroom">'.$Load->WhatLink('classroom').'</a>-->
		        						</div>
		        					</div>
		        					<div class="navbar-item has-dropdown is-hoverable">
		        						<a class="navbar-link is-active" href="#"><i class="fas fa-book-open"></i>&nbsp;Cursos e Disciplinas</a>
		        						<div class="navbar-dropdown ">
		        							<a class="dropdown-item " href="'.SERVER.'courses">'.$Load->WhatLink('courses').'</a>
		        							<a class="dropdown-item " href="'.SERVER.'disciplines">'.$Load->WhatLink('disciplines').'</a>
		        							<!--<a class="dropdown-item " href="'.SERVER.'schedule-grid">'.$Load->WhatLink('schedule-grid').'</a>-->
		        						</div>
		        					</div>
									<a class="navbar-item" href="'.SERVER.'reserve"><i class="fas fa-graduation-cap"></i>&nbsp;'.$Load->WhatLink('reserve').'</a>';
							break;
												
							case 4:
								#professor
								$menu .= '
	    						<a class="navbar-item" href="'.SERVER.'notifies"><i class="fas fa-book-open"></i>&nbsp;'.$Load->WhatLink('notifies').'</a>
								<a class="navbar-item" href="'.SERVER.'"><i class="fas fa-graduation-cap"></i>&nbsp;Formandos</a>';
							break;
							case 5:
							#aluno
								$menu .= '
	                    		<a class="navbar-item" href="'.SERVER.'historic"><i class="fas fa-book-open"></i>&nbsp;'.$Load->WhatLink('historic').'</a>
								<a class="navbar-item" href="'.SERVER.'documents"><i class="far fa-file"></i>&nbsp;'.$Load->WhatLink('documents').'</a>
								<a class="navbar-item" href="'.SERVER.'schedule-grid"><i class="far fa-file"></i>&nbsp;'.$Load->WhatLink('schedule-grid').'</a>';
							break;
	    			}
	    		}
	                $menu .= '
	                    </div>
	                    <!--<a class="navbar-item" href="search">
							<i class="fas fa-search" aria-hidden="true"></i>&nbsp;<span><input class="input" type="search" placeholder="Procurar..."></span>
						</a>-->
	                    <div class="navbar-end">
							<a class="navbar-item" href="'.SERVER.'profile"><i class="fas fa-user"></i>&nbsp;'.$Load->WhatLink('profile').'</a>
	                    	<a class="navbar-item" href="'.SERVER.'notifies"><i class="fas fa-bell"></i>&nbsp;'.$Load->WhatLink('notifies').'</a>
	                    	<a class="navbar-item" href="'.SERVER.'#"><i class="fas fa-book"></i>&nbsp;Biblioteca</a>
							<a class="navbar-item" href="'.SERVER.'logout"><i class="fas fa-sign-out-alt"></i>&nbsp;'.$Load->WhatLink('logout').'</a>
						</div>
					</div>
		        </nav>';
	            break;
	                    			
	            case false:
	                $menu .= '
	                    </div>
			            <div class="navbar-end">
				    		<a class="navbar-item" href="'.SERVER.'login"><i class="fa fa-user"></i>&nbsp;'.$Load->WhatLink('login').'</a>
				    	</div>
		        	</nav>';
	            break;
	        }            		
            return $menu;
    	}

    	# 2 - Gera a informação e um mapa rápido de acesso através do link informado
	    function MainNavegation($link = LINK, $mess = '<ul>Você está em: &nbsp;'){
	    	$Load = new Load;
	    	if(!$link || $link == 'index') {
	    		$mess .= '<li class="is-active"><a href="'.SERVER.'" aria-current="page">Início</a></li>';
	    	} else {
		    	$mess .='
	    			<li class=""><a href="'.SERVER.'" aria-current="page">Início</a></li>
	    			<li class="is-active"><a href="'.SERVER.''.$link.'" aria-current="page">'.ucfirst($Load->WhatLink($link)).'</a></li>';
	    	}
	    	return $mess .= '</ul>';
	    }

	    # 2.1 - Mostra um menu personalizado, com mapa de acesso, através do link e do tipo de usuário informado
    	function FooterMenu(
	    	$menu = '
	    		<div class="columns">
		    		<div class="column is-3">
			    		<aside class="menu is-hidden-mobile">
			        	<p class="menu-label">Gerais</p>
				        	<ul class="menu-list">
				                <li><a href="'.SERVER.'" class="is-active">Início</a></li>
				                <li><a href="'.SERVER.'profile">Perfil</a></li>
				                <li><a href="'.SERVER.'notifies">Notificações</a></li>
				                <li><a href="'.SERVER.'#">Biblioteca Online</a></li>
				            </ul>
						</aside>
					</div>
				<div class="column is-3">'
    	) {
    		$Load = new Load;
    		$Tables = new Tables;
    		$PDO = $Load->DataBase();
    		$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
    		while($row = $con->fetch(PDO::FETCH_OBJ)){
    			switch ($row->type_use) {
					case 1:
						#diretor
					break;
					case 2:
						#coordenador
					break;
					case 3:
						#funcionário
						$menu .= '
		    				<p class="menu-label">Administração</p>
		                    <ul class="menu-list">
		                        <li>
		                            <a href="#">Cursos e Disciplinas</a>
		                            <ul>
		                                <li><a href="'.SERVER.'courses">'.$Load->WhatLink('courses').'</a></li>
		                                <li><a href="'.SERVER.'disciplines">'.$Load->WhatLink('disciplines').'</a></li>
		                                <!--<li><a href="'.SERVER.'schedule-grid">Grade de Horários</a></li>-->
		                            </ul>
		                        </li>
		                        <li>
		                            <a href="#">Usuários</a>
		                            <ul>
		                            	<li><a href="'.SERVER.'new-user">Cadastrar</a></li>
		                                <li><a href="'.SERVER.'teachers">Professores</a></li>
		                                <li><a href="'.SERVER.'employees">Funcionarios</a></li>
		                                <li>
		                                	<a href="'.SERVER.'students">Alunos</a>
											<ul>
			                                	<li><a href="'.SERVER.'classroom">Turmas e Alunos</a></li>
			                            	</ul>
		                                </li>
		                            </ul>
		                        </li>
		                        <li><a href="'.SERVER.'events">Eventos</a></li>
		                    </ul>
		                    </div>
		                    </div>';
					break;
					
					case 4:
						#professor
						$menu .= '
		    				<p class="menu-label">Professores</p>
		                    <ul class="menu-list">
		                        <li>
		                            <a>Alunos</a>
		                            <ul>
		                                <li><a href="'.SERVER.'partial">Adicionar Nota</a></li>
		                                <li><a href="'.SERVER.'average">Adicionar Média</a></li>
		                                <li><a href="'.SERVER.'average">Gerenciar</a></li>
		                            </ul>
		                        </li>
		                    </ul>
		                    </div>
		                    </div>';
					break;
					case 5:
						$menu .= '
		    				<p class="menu-label">Alunos</p>
		                    <ul class="menu-list">
		                    	<li><a href="'.SERVER.'notifies">Solicitar Documentos</a></li>
		                        <li><a href="'.SERVER.'historic">Visualizar Histórico</a></li>
		                        <li><a href="'.SERVER.'#">Rematrícula</a></li>
		                    </ul>
		                    </div>
		                    </div>';
					break;
				}
    		}
    		return $menu;
    	}

		function HeroMessage(){
	    	$Load = new Load;
	    	$Tables = new Tables;
	    	$PDO  = $Load->DataBase();
	    	$title = (LINK != '') ? $Load->WhatLink() : 'Olá, '.$_SESSION['name']; 
	    	$subtitle = '';
	    	switch(LINK){
	    		case '': case SERVER: $subtitle = 'Tenha um bom dia!'; break;
	    		case 'classroom':
	    			#$title = 'Turmas';
	    			switch ($Load->IsUserTheseType()) {
						case true:
							$script = LINK.', courses, students, users WHERE '.LINK.'.id_cou = courses.id_cou 
							AND classroom.id_cla = students.id_cla 
							AND students.id_use = users.id_use AND users.id_use = '.$_SESSION['id'];
						break;
						case false: $script .= ', courses WHERE '.LINK.'.id_cou = courses.id_cou AND id_cla = '.$_GET['id']; break;
					}
					$con = $PDO->query($Tables->SelectFrom(null, $script)) or die($PDO);
	      			while($row = $con->fetch(PDO::FETCH_OBJ)){
	      				$name_cou = $row->name_cou;
	      			}
	    			$subtitle = 'Visualização da Turma de '.$name_cou;
	    		break;
	    		case 'new-user': $subtitle = 'Informe os dados para cadastrar'; break;
	    		case 'notifies': $subtitle = 'Informe os dados para gerar sua notificação'; break;
	    		case 'profile': $subtitle = 'Informe os dados para editar'; break;
	    		case 'reserve':
	    			$title = 'Reserva de Sala';
	    			$subtitle = 'Reserva de sala para manutenção periódica';
	    		break;
	    		case 'schedule-grid':
	    			$title = 'Grade de Horários';
	    			$con = $PDO->query($Tables->SelectFrom(null, 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
	    			while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($row->type_use) {
							case 5:
				    			$script = 'classroom, courses, disciplines, students, users';
								$script .= ' WHERE classroom.id_cla = students.id_cla';
								$script .= ' AND classroom.id_cou = courses.id_cou';
								$script .= ' AND disciplines.id_cou = courses.id_cou';
								$script .= ' AND students.id_use = users.id_use AND users.id_use = '.$row->id_use;
								$con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
								while($row = $con->fetch(PDO::FETCH_OBJ)){
									$name_cou = $row->name_cou;
								}
							break;
							default: 
							break;
						}
					}
					$subtitle = 'Visualização da grade de horários para '.$name_cou;
	    		break;
	    		case 'historic':
	    			$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch($row->type_use){
							case 5: $name_use = $_SESSION['name']; break;
							default: 
								$id = (isset($_GET['id'])) ? $_GET['id'] : '';
								$con = $PDO->query($Tables->SelectFrom('name_use', 'users WHERE id_use = '.$id)) or die ($PDO);
								while($row = $con->fetch(PDO::FETCH_OBJ)){ 
									$name_use = $row->name_use; 
								}
							break;
						}
					}
	    			$subtitle = 'Histórico de notas de '.$name_use;
	    		break;
	    	}

	    	$hero = '
    		<section class="hero is-info welcome is-small">
			    <div class="hero-body">
			        <div class="container">
			        	<h1 class="title is-medium is-white">'.$title.'</h1>
			            <h2 class="subtitle">'.$subtitle.'</h2>
			        </div>
			    </div>
			</section>';
			return $hero;
	    }
	}
	$Navegation = new Navegation;

	# Classe que cataloga as funções referentes as páginas
    class Pages {
		function LoadTablePage($link = LINK){
			$Load = new Load;
			$PDO = $Load->DataBase();
			$Tables = new Tables;
			$script = $link;

			$id = $Tables->Found_Item('id', $link);
			$type_table = $Tables->Found_Item('type', $link);
			$name_table = $Tables->Found_Item('name', $link);
			$status_table = $Tables->Found_Item('status', $link);
			$count = $Tables->CountViewTable(null, $link);
			switch ($link) {
				case 'classroom':
					switch($Load->IsUserTheseType()){
						case true:
							$script .= ', students, users, courses 
								WHERE '.$link.'.id_cou = courses.id_cou 
								AND '.$link.'.id_cla = students.id_cla AND students.id_use = users.id_use
								AND users.id_use = '.$_SESSION['id'];
						break;
						case false: 
							$script .= ', courses WHERE '.$link.'.id_cou = courses.id_cou';
						break;
					}
			        $th = '<th></th><th>Nome do Curso</th><th>Tipo de Curso</th>';
					$icon = '<i class="fas fa-users"></i>';
					$type_table = $Tables->Found_Item('type', 'courses');
					$name_table = $Tables->Found_Item('name', 'courses');
				break;
				case 'courses':
					$th = '<th></th><th>Nome</th><th>Tipo de Curso</th><th>Período</th>';
					$icon = '<i class="fas fa-pencil-alt"></i>';
				break;
				case 'disciplines': 
					$th = '<th>Nome</th><th>Nome do Curso</th><th>Professor</th>';
					$name_table .= ', courses, teachers, users WHERE '.$link.'.id_cou = courses.id_cou AND '.$link.'.id_tea = teachers.id_tea AND teachers.id_use = users.id_use';
					$icon = '<i class="fas fa-chalkboard"></i>';
					$type_table = $Tables->Found_Item('type', 'courses');
				break;
				case 'notifies':
					$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use LIKE '.$_SESSION['id'].' AND status_use = 1')) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($row->type_use){
							case 4: case 5: 
								$script .= ', users WHERE users.id_use = '.$link.'.id_use AND users.id_use = '.$_SESSION['id'];
							break;
							default: 
								$script .= ', users WHERE users.id_use = '.$link.'.id_use';
							break;
						}
					}
					$th = '<th></th><th>Titulo</th><th>Tipo da Notificação</th><th>Nome do Usuário</th>';
					$icon = '<i class="fas fa-bell"></i>';
				break;

				case 'reserve':
					$th = '<th></th><th>Data</th><th>Laboratório</th><th>Início</th><th>Término</th>';
					#$script .= 'ORDER BY '.$link.'.day_class';
				break;
				case 'users':
					$th = '<th></th><th>Nome</th><th>Tipo do Usuário</th><th></th>';
					$icon = '<i class="fas fa-users"></i>';
				break;
			}
			#echo $script;
			$con = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
			$count = $Tables->CountViewTable(null, $script);
			echo '
			    <div class="card events-card">
			        <header class="card-header">
			            <p class="card-header-title">'.ucfirst($Load->WhatLink($link)).'</p>
			            <a href="'.$link.'" class="card-header-icon" aria-label="more options"><span class="icon"><i class="fa fa-angle-down" aria-hidden="true"></i></span></a>
			        </header>
			        <div class="card-table">
			            <div class="content">
			                <table class="table is-fullwidth is-striped">
			                	<thead><tr>'.$th.'</tr></thead>
			                    <tbody>';
			                    while($row = $con->fetch(PDO::FETCH_OBJ)){
									switch($Load->IsUserTheseType()){
										case true: $action_button = $action_color = $action_link = ''; break;
										case false:
											switch ($row->$status_table) {
												case 1: $action_link = 'change?t='.$link.'?id='.$row->$id; $action_color = 'danger'; $action_button = '<i class="fas fa-minus-circle"></i>';
												break;
												case 2: $action_link = 'change?t='.$link.'?id='.$row->$id; $action_color = 'success'; $action_button = '<i class="fas fa-check-square">';
												break;
											}
										break;
									}
								    switch ($link) {
								    	case 'classroom':
								    		$link = ($Load->IsUserTheseType()) ? $link : $link.'?id='.$row->$id;
								    		$col_1 = '<a href="'.$link.'" class="button is-link is-small">'.$icon.'</a>';
								    		$col_2 = $row->name_cou;
								    		$type = ($row->type_cou == 1) ? 'Ensino Médio' : 'Ensino Modular';
								    		$col_3 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';
											$col_4 = ($action_link != null) ? '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>' : '';
											$col_5 = '';
								    	break;
								    	case 'courses':
								    		$col_1 = '<a href="'.$link.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
								    		$col_2 = $row->$name_table;
								    		$type = ($row->$type_table == 1) ? 'Ensino Médio' : 'Ensino Modular';
								    		$col_3 = '<a class="button is-light is-inverted is-small">'.$type.'</a>';
								    		switch ($row->period) {
								    			case 'M': $col_period = 'warning'; $period = 'Manhã'; break;
								    			case 'T': $col_period = 'danger'; $period = 'Tarde'; break;
								    			case 'N': $col_period = 'link'; $period = 'Noite'; break;
								    			case 'I': $col_period = 'primary'; $period = 'Integral'; break;
								    		}
								    		$col_4 = '<a href="schedule-grid?id='.$row->$id.'" class="button is-'.$col_period.' is-small">'.$period.'</a>';
								    		$col_5 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'. $action_button.'</a>';
								    	break;
								    	case 'disciplines':
								    			$col_1 = $row->$name_table;
								    			$col_2 = '<a href="courses?n='.$row->name_cou.'">'.$row->name_cou.'</a>';
								    			$col_3 = '<a href="courses?n='.$row->name_use.'">'.$row->name_use.'</a>';
								    			$col_4 = '<a href="'.$link.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
								    			$col_5 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'. $action_button.'</a>';
								    	break;
								    	case 'notifies':
								    			$col_1 = '<a href="'.$link.'?id='.$row->$id.'" class="button is-link is-small">'.$icon.'</a>';
												$col_2 = $row->$name_table;
												switch ($row->$type_table) {				
													case 1: $type = 'Solicitação'; $color = 'is-primary'; break;
													case 2: $type = 'Revisão'; $color = 'is-warning'; break;
													case 3: $type = 'Matrícula'; $color = 'is-success'; break;
													case 4: $type = 'Ocorrência'; $color = 'is-danger'; break;
													case 5: $type = 'Trancamento'; $color = 'is-dark'; break;
													case 6: $type = 'Histórico'; $color = 'is-link'; break;
													case 7: $type = 'Outros'; $color = 'is-primary'; break;
												}
												$col_3 = '<a class="button '.$color.' is-small">'.$type.'</a>';
												$col_4 = $row->name_use;
												switch ($row->$status_table) {
													case 1:
														$action_link = 'get_doc?t='.$link.'?id='.$row->$id;
														$action_color = 'success';
														$action_button = '<i class="fas fa-file"></i>&nbsp;Gerar';
													break;
													case 2: 
														$action_link = 'view_doc?t='.$link.'?id='.$row->$id;
														$action_color = 'primary';
														$action_button = '<i class="fas fa-file">&nbsp;Ver';
													break;
												}
												$col_5 = '';
								    	break;

								    	case 'reserve':
								    		switch ($row->day_class) {				
												case 1: $day = 'Segunda';  break;
												case 2: $day = 'Terça';  break;
												case 3: $day = 'Quarta';  break;
												case 4: $day = 'Quinta'; break;
												case 5: $day = 'Sexta'; break;
												case 6: $day = 'Sábado'; break;
												case 7: $day = 'Domingo';  break;
											}
								    		$col_1 = '';
								    		$col_2 = $day;
								    		$col_3 = $row->classroom;
								    		$col_4 = date('H:i:s',strtotime($row->time_start));
								    		$col_5 = date('H:i:s',strtotime($row->time_end));
								    	break;
								    	case 'users':
								    		$col_1 = '<a href="'.SERVER.'profile?id='.$row->id_use.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>';
								    		$col_2 = $row->name_use;
								    		switch ($row->type_use) {
								    			case 1: $type = 'Diretor'; break;
								    			case 2: $type = 'Coordenador'; break;
								    			case 3: $type = 'Funcionário'; break;
								    			case 4: $type = 'Professor'; break;
								    			case 5: $type = 'Aluno'; break;
								    		}
								    		#$col_2 = '<figure class="image is-32x32"><img class="is-rounded" src="'.$photo.'">';
								    		$col_3 = $type;
								    		$col_4 = '<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>';
								    		#ativar e desativar apenas em caso de usuário admin
								    		$col_5 = '';
								    	break;
								    }
										echo '
											<tr>
												<td>'.$col_1.'</td>
												<td>'.$col_2.'</td>
										    	<td>'.$col_3.'</td>
										    	<td>'.$col_4.'</td>';

												echo ($col_5) ? '<td>'. $col_5.'</td>' : '';
					    					echo '</tr>';
					    			}
					    			echo '                         
			                            </tbody>
			                        </table>
			                    </div>
			                </div>
			                <footer class="card-footer"><a class="card-footer-item">Exibindo '.$count.' resultados.</a></footer></div>';
		}

		function LoadSuperTablePage($link = LINK, $th = ''){
			$id = (isset($_GET['id'])) ? $_GET['id'] : '';
			$Load = new Load;
			$PDO = $Load->DataBase();
			$Tables = new Tables;
			$table = $link;
			switch ($link) {
		        case 'classroom':
		        	$th = '<th colspan="2">Aluno</th><th>RA</th><th>Data de Matrícula</th><th>Data de Aniversário</th>';
		        	switch ($Load->IsUserTheseType()) {
						case true:
							$table .= ', courses, students, users WHERE '.$link.'.id_cou = courses.id_cou 
							AND classroom.id_cla = students.id_cla 
							AND students.id_use = users.id_use AND users.id_use = '.$_SESSION['id'];
						break;
						case false: 
							$table .= ', courses, students, users';
							$table .= ' WHERE '.$link.'.id_cla = '.$id;
							$table .= ' AND '.$link.'.id_cou = courses.id_cou';
							$table .= ' AND students.id_cla = '.$link.'.id_cla';
							$table .= ' AND students.id_use = users.id_use AND users.type_use = 5';
						break;
					}
				break;
				case 'historic':
					$th = '<th colspan="2">Aluno</th><th colspan="2">Notas</th><th colspan="2">Faltas</th><th colspan="2">Abonos</th><th>Média Final</th>';
					$con = $PDO->query($Tables->SelectFrom('type_use', 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch($row->type_use){
							case 5:  $id = $_SESSION['id']; $name_use = $_SESSION['name']; break;
							default:
								$id = (isset($_GET['id'])) ? $_GET['id'] : '';
								if(!$id){
									$title = 'Ops';
									$message = 'Houve problemas durante a sua requisição.';
									$links[1] = SERVER; $links[2] = 'Início';
									$links[3] = '#';  $links[4] = 'Voltar aonde estava';
									include('ops.php');
									exit;
								}
							break;
						}
						$table .= ', students, disciplines, users';
						$table .= ' WHERE '.$link.'.id_dis = disciplines.id_dis'; 
						$table .= ' AND '.$link.'.id_stu = students.id_stu';
						$table .= ' AND students.id_use = users.id_use';
						$table .= ' And users.id_use = '.$id;
					}
				break;
				case 'reserve': 
					$th = '<th style="width: 50%">Dia e Horário</th><th>Laboratório</th>';
					$table .= ' ORDER BY day_class';
				break;
				case 'schedule-grid':
					$th = '<th>Horário</th><th id="1">Segunda</th><th id="2">Terça</th><th id="3">Quarta</th><th id="4">Quinta</th><th id="5">Sexta</th><th id="6">Sábado</th>';
					$con = $PDO->query($Tables->SelectFrom(null, 'users WHERE id_use = '.$_SESSION['id'])) or die ($PDO);
					while($row = $con->fetch(PDO::FETCH_OBJ)){
						switch ($row->type_use) {
							case 5:
								$table = 'classroom, courses, disciplines, students, users';
								$table .= ' WHERE classroom.id_cla = students.id_cla';
								$table .= ' AND classroom.id_cou = courses.id_cou';
								$table .= ' AND disciplines.id_cou = courses.id_cou';
								$table .= ' AND students.id_use = users.id_use AND users.id_use = '.$_SESSION['id'];
							break;
							default:
								$id = (isset($_GET['id'])) ? $_GET['id'] : '';
								if(!$id){
									$title = 'Ops';
									$message = 'Houve problemas durante a sua requisição.';
									$links[1] = SERVER; $links[2] = 'Início';
									include('functions/ops.php');
								}
								$table = 'disciplines, courses WHERE disciplines.id_cou = courses.id_cou AND courses.id_cou = '.$id;
							break;
						}
					}
				break;
			}
			echo '<table class="table is-fullwidth is-striped"><thead><tr>'.$th.'</tr></thead>';
			echo $Tables->SelectFrom(null, $table);
		    $con = $PDO->query($Tables->SelectFrom(null, $table)) or die ($PDO);						
			while($row = $con->fetch(PDO::FETCH_OBJ)){
				echo '<tbody><tr>';
				switch ($link) {
					case 'classroom':
						echo '
							<th><p class="image is-64x64"><img class="is-rounded" src="'.$Load->Gravatar().'"></th>
							<th>'.$row->name_use.'</th>
							<td>'.$row->id_use.'</td>
							<td>'.date('d/m/Y', strtotime($row->signup_date)).'</td>
							<td>'.date('d/m/Y', strtotime($row->birthday_date)).'</td>
							<td><a class="button is-link" href="historic?id='.$row->id_use.'">Ver Historico</a></td>
							<td><a class="button is-link" href="profile?id='.$row->id_use.'">Ver Perfil</a></td>';
					break;
					case 'historic':
									echo '
										<th><p class="image is-64x64"><img class="is-rounded" src="'.$Load->Gravatar().'"></th>
										<th>'.$row->name_use.'</th>
										<td>'.$row->n1.'</td>
										<td>'.$row->n2.'</td>
										<td>'.$row->mp.'</td>
										<td>'.$row->fi.'</td>
										<td>'.$row->fa.'</td>
										<td>'.$row->f.'</td>
										<td>'.$row->mf.'</td>
										<td>'.$row->status_his.'</td>';
					break;
					case 'reserve':
						switch($row->day_class){
			        	   	case 1: $day_class = 'Segunda'; break;
			        	   	case 2: $day_class = 'Terça'; break;
			        	   	case 3: $day_class = 'Quarta'; break;
			        	   	case 4: $day_class = 'Quinta'; break;
			        	   	case 5: $day_class = 'Sexta'; break;
			        	   	case 6: $day_class = 'Sábado'; break;
			        	}
						echo '<td>'.$day_class.'</br>'.$row->time_start.' - '.$row->time_end.'</td><td>'.$row->classroom.'</td>';
					break;
					case 'schedule-grid':
						$start = array();
						switch ($row->period) {
							case 'I':
								$classes = 11;
								$start[1] = "07:30";
								$start[2] = "08:20";
								$start[3] = "09:10";
								$start[4] = "10:00";
								$start[5] = "10:20";
								$start[6] = "11:10";
								$start[7] = "12:00";
								$start[8] = "13:00";
								$start[9] = "13:50";
								$start[10] = "14:40";
								$start[11] = "15:30";
							break;
							case 'T':
								$classes = 9;
								$start[1] = "13:00";
								$start[2] = "13:50";
								$start[3] = "14:40";
								$start[4] = "15:30";
								$start[5] = "15:45";
								$start[6] = "16:35";
								$start[7] = "17:25";
								$start[8] = "18:00";
								$start[9] = "19:00";
							break;
							case 'N':
								$classes = 6;
								$start[1] = "19:00";
								$start[2] = "19:50";
								$start[3] = "20:40";
								$start[4] = "21:00";
								$start[5] = "21:50";
								$start[6] = "22:40";
							break;
							case 'M': break;
						}
						for($i = 1; $i < $classes; $i++){
							echo '<tr><th>'.$start[$i].' - '.$start[$i+1].'</th>';
							$query = $PDO->query($Tables->SelectFrom(null, $table.' AND disciplines.time_start = "'.$start[$i].':00" ORDER by day_class')) or die ($PDO);
							while($row = $query->fetch(PDO::FETCH_OBJ)){
								echo '<td><a href="disciplines?id='.$row->id_dis.'">'.$row->name_dis.'<br/>'.$row->classroom.'</td></tr>';
							}
						}
					break;
				}
			}
			echo '</tr></tbody></table>';
		}

		function LoadArticlePage($name_page = LINK){
			$Load = new Load;
			$Tables = new Tables;
			$PDO = $Load->DataBase();
			$pg = isset($_GET['pg']) ? $_GET['pg'] : '';
			$script = $name_page;
			switch ($name_page){
				default:
		    		$name_table = $Tables->Found_Item('name', $name_page);
				break;
				case 'employees': 
					$script.=', users  WHERE '.$name_page.'.id_emp = users.id_use'; 
					$name_table = $Tables->Found_Item('name', 'users'); 
				break;
			}

			#echo $Tables->SelectFrom(null, $script, (1 * $pg), (10 * $pg));
		    $query = $PDO->query($Tables->SelectFrom(null, $script, (1 * $pg), (10 * $pg))) or die ($PDO);
		    $cont = $Tables->CountViewTable(null, $script);

		    while($row = $query->fetch(PDO::FETCH_OBJ)){
		    	$id = $Tables->Found_Item('id', $name_page);
		    	$edit_link = $name_page.'?id='.$row->$id;
		    	$status_table = $Tables->Found_Item('status', $name_page);
		   		$action_link = ($status_table) ? 'deactivate?t='.$name_page.'?id='.$row->$id : 'activate?t='.$name_page.'?id='.$row->$id;
				$action_color = ($status_table) ? 'danger' : 'success';
				$action_button = ($status_table) ? '<i class="fas fa-minus-circle"></i>' : '<i class="fas fa-check-square">';
				$content = '';
				#$img = '<img class="is-rounded" src="'.$Load->Gravatar().'">';
		    	$titulo = $row->$name_table;
		    	switch ($name_page) {
					case 'classroom':
						$link = 'courses?id='.$row->$id;
						//$name_page.', courses, students, users WHERE '.$name_page.'.id_cla = '.$row->$id.' AND '.$name_page.'.id_cou = courses.id_cou AND students.id_cla = '.$name_page.'.id_cla AND students.id_use = users.id_use
						$cont_class = $Tables->CountViewTable($script);
						switch ($row->period) {
							case 'M': $period = 'Manhã'; break;
							case 'T': $period = 'Tarde'; break;
							case 'N': $period = 'Noite'; break;
							case 'I': $period = 'Integral'; break;
						}
						$message = 'Número de Alunos: '.$row->students.'</br>Período: '.$period.'<br/>Curso: ';
						$user = $titulo;
					break;
					
					case 'employees':
					case 'teachers':
					case 'students':
					#case 'users':
						#echo $id;
						$link = 'profile?id='.$row->$id;
						switch ($row->birthday_date) {
							case true:
								$birthday_date = date('d/m/Y', strtotime($row->birthday_date));
								$birthday_year = date('Y', strtotime($row->birthday_date));
								$age = date(YEAR-$birthday_year);
							break;
							
							case false:
								$birthday_date = $birthday_year = $age = '';
							break;
						}
						
						switch ($row->signup_date) {
							case true:
								$signup_date = date('d/m/Y', strtotime($row->signup_date));
								$signup_year = date('Y', strtotime($row->signup_date));
								$signup_time = date(YEAR-$signup_year);
							break;
							
							case false:
								$signup_date = $signup_year = $signup_time = '';
							break;
						}
						
						switch ($row->type_use) {
							case 1:
								
							break;
							case 2:
								
							break;
								
							case 3:
								$tag = 'is-warning';
								$tipo = 'Funcionário';
								$string = 'area';
								$input = '';
							break;

							case 4:
								$tag = 'is-success';
								$tipo = 'Professor';
								$string = 'area';
								$input = '';
							break;
							
							case 5:
								$tag = 'is-primary';
								$tipo = 'Aluno';
								$string = 'turma';
								$input = '';
							break;
						}

						$user = $login = ($row->login) ? $row->login : '';
						$email = ($row->email) ? $row->email : '';
						$img = isset($row->photo) ? '<img class="is-rounded" src="'.$row->photo.'">' : '<img class="is-rounded" src="'.$Load->Gravatar().'">';
						
						/*
						$cep = ($row->cep) ? $row->cep : '';
						$address = ($row->address) ? $row->address : '';
						$number = ($row->number) ? $row->number : '';
						$neighborhood = ($row->neighborhood) ? $row->neighborhood : '';
						$city = ($row->city) ? $row->city : '';
						$state = ($row->state) ? $row->state : '';
						$rg = ($row->rg) ? $row->rg : '';
						$cpf = ($row->cpf) ? $row->cpf : '';
						$phone = ($row->phone) ? $row->phone : '';*/
						#preparar especificações para cada tipo de usuário

						$content = 'Idade: '.$age.'<br/>';
						$content .= $tipo.' desde '.$signup_year.'<br/>';
						$content .= 'Login: <a href="'.$link.'">'.$user.'</a>';
					break;
				}
				echo '
					<article class="post">
						<h4>'.$titulo.'</h4>
						<div class="media">
							<div class="media-left">'.$img.'</div>
							<div class="media-content">
								<div class="content">
									<p>'.$content.'</p>
								</div>
							</div>
							<div class="media-right">
								<a href="'.$edit_link.'" class="button is-link is-small"><i class="fas fa-pencil-alt"></i></a>
								<a href="'.$action_link.'" class="button is-'.$action_color.' is-small">'.$action_button.'</a>
							</div>
						</div>
						<hr />
					</article>';
			}
			echo'
					<div class="columns">
						<div class="column">
							<p>Exibindo '.$cont.' de '.$cont.' resultados.</p>
						</div>
						<div class="column">
						</div>
					</div>';
		}

		function LoadOptionsPage($name_page = LINK){
			$Tables = new Tables;
			$Load = new load;
			$PDO = $Load->DataBase();
			$script = $name_page;
			switch ($name_page) {
				case 'courses':
					$script .=' WHERE status_cou = 1';
					$name_table = $Tables->Found_Item('name', $name_page);
					$id_table = $Tables->Found_Item('id', $name_page);
					$icon = '<i class="fas fa-chalkboard"></i>';
				break;
				
				case 'teachers':
					$script .=', users WHERE '.$name_page.'.id_use = users.id_use AND status_use = 1';
					$name_table = $Tables->Found_Item('name', 'users');
					$id_table = $Tables->Found_Item('id', $name_page);
					$icon = '<i class="fas fa-user"></i>';
				break;
			}
			$query = $PDO->query($Tables->SelectFrom(null, $script)) or die ($PDO);
			echo'
				<div class="field" id="'.$name_page.'">
			        <label class="label">'.$Load->WhatLink($name_page).'</label>
			        <div class="control has-icons-left">
			            <div class="select is-hovered is-link">
			            	<select name="'.$id_table.'">';
				            	while($row = $query->fetch(PDO::FETCH_OBJ)){
				            		echo '<option value="'.$row->$id_table.'">'.$row->$name_table.'</option>';
				            	}
			            	echo '
			            	</select>
			            </div>
			            <span class="icon is-small is-left">'.$icon.'</span>
			        </div>
			    </div>';
		}
    }
    $Pages = new Pages;