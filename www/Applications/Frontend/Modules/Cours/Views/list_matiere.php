<div class="page-header">
	<h1>Liste des matières</h1>
</div>
<div class="strip primary">
	<div class="container">
		<ul class="inline">
			<li>
				<a href="/" class="primary-color">Accueil</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<a href="/cours" class="primary-color">Cours</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
					<?php echo $classe->libelle()." - Session ".$classe->session()->session();?>
			</li>
		</ul>
	</div>
</div>
<div class="main-content container">
    <div class="headline">
		<h3>Choisissez votre matière</h3>
	</div>
	<div class="row-fluid equal equal-style">
	<?php
	$i = 0;
	$listeMatiere = $classe->matieres();
	if(isset($listeMatiere) && is_array($listeMatiere))
	{
		foreach ($listeMatiere as $matiere) {
	?>
	<div class="span3">
		<a class="innershadows btn btn-block btn-primary" href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.urlencode(str_replace(' ','-',$classe->libelle()))."/".str_replace(' ','-',$matiere->libelle());?>"><h2><i class="<?php echo $matiere->icon();?>"></i> <?php echo $matiere->libelle();?></h2></a>
		<div class="content">
			<p class="text-center">
				<?php 
				//echo $controller->getCountCours($matiere['id']);
				?> cours dans cette section
			</p>
		</div>          
		</a>
	</div>
	<?php
	$i++;
	if ($i != 0 && $i%4 == 0) {
	?>
	</div>
	<br>
	<div class="row-fluid equal equal-style">
	<?php
			}
		}
	}
	else
	{
		echo "<br/><br/><br/><br/><h3 class='text-warning'>Désole, il n'y a pas encore de matières sélectionnées pour votre classe</h3><br/><br/><br/><br/>";
	}
	?>
	</div><!--/row-fluid-->
</div>