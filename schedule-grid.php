<?php
	include('header.php');
	$con = $PDO->query($Tables->SelectFrom('name_cou', 'courses WHERE id_cou = '.$_GET['id'])) or die ($PDO);
	while($row = $con->fetch(PDO::FETCH_OBJ)){
		$name_cou = $row->name_cou;
	}
?>
<div class="columns">
    <div class="column">
        <div class="tabs is-left"><?php echo $Navegation->MainNavegation($link); ?></div>
    </div>
    <!--<div class="column">
		<div class="tabs is-right">
			<ul>
				<li class="is-active">
					<a href="message">
						<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
			    		<span class="content is-blak">Solicitar Reserva de Sala</span>
			    	</a>
			    </li>
			    <li>
					<a>
						<span class="icon is-small"><i class="fas fa-chalkboard-teacher" aria-hidden="true"></i></span>
			    		<span class="content is-blak">Grade de Manutenção</span>
			    	</a>
			    </li>
			</ul>
		</div>
	</div>-->
</div>
<div class="box content">
	<!--Criar formato onde, a partir da seleção do curso, a página seja automaticamente redirecionada -->
	<?php 
		#include('load/options/courses.php'); 
		echo $Navegation->HeroMessage('Grade de Horários', 'Visualização da grade de horários para '.$name_cou); ?>
	<hr />
<?php include('load/pages/'.$link.'.php'); ?>
</div>
<?php include('footer.php'); ?>