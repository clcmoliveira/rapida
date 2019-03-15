<?php
	$name_page = 'Cursos e Disciplinas';
	include('header-admin.php'); 
?>
<div class="columns">
    <div class="column is-4">
        <div class="tabs is-left"><?php echo $Load->MainNavegation(LINK, ucfirst('Cursos e Disciplinas')); ?></div>
    </div>
    <div class="column">
		<div class="tabs is-right">
			<ul>
		    	<li class="is-active">
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
		        		<span>Todos</span>
		      		</a>
		    	</li>
		    	<li>
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
		        		<span class="content is-link">Ativos</span>
		      		</a>
		    	</li>
		    	<li>
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard" aria-hidden="true"></i></span>
		        		<span class="content is-danger">Inativos</span>
		      		</a>
		    	</li>
		  		<li>
		      		<a>
		        		<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
		        		<span class="content is-blak">Add Disciplina</span>
		      		</a>
		    	</li>
	    	</ul>
		</div>
	</div>
</div>
<div class="box content">
	<?php
		echo $Load->HeroMessage(LINK, 'Gerenciamento de cursos e disciplinas', 'Visualização da disciplinas cadastradas').'<hr/>'; 
		//include ('load/load-courses-disciplines.php'); ?>
</div>
<?php include('footer-admin.php'); ?>