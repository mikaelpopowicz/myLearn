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
				Cours
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
	foreach ($listeMatiere as $matiere) {
	?>
	<div class="span3">
		<a class="innershadows btn btn-block btn-primary" href="/cours/<?php echo $matiere['libelle'];?>"><h2><i class="<?php echo $matiere['icon'];?>"></i> <?php echo $matiere['libelle'];?></h2></a>
		<div class="content">
			<p class="text-center">
				<?php echo $controller->getCountCours($matiere['id']);?> cours dans cette section
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
	?>
	</div><!--/row-fluid-->
</div>