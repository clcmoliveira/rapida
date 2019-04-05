<?php
	include('header-admin.php');
	include('load/pages/courses.php');
?>
<div class="columns">
	<div class="column is-4">
		<div class="tabs is-left"><?php echo $Load->MainNavegation(LINK, 'Turmas'); ?></div>
	</div>
	<div class="column">
		<div class="tabs is-right">
		  	<ul>
		    	<li class="is-active">
		      		<a href="classroom">
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
		    	<li>
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
		        		<span class="content is-blak">Add Turma</span>
		      		</a>
		    	</li>
			</ul>
		</div>
	</div>
</div>
<div class="box content">
	<!--Criar formato onde, a partir da seleção da turma, a página seja automaticamente redirecionada -->
	<?php include('load/options/courses.php'); ?>
	<?php
		echo $Load->HeroMessage(LINK, 'Turmas', 'Visualização da Turma de '.$name_cou).'<hr/>';
		include('load/supertables/classroom.php'); ?>
	</div>
<?php include('footer-admin.php'); ?>