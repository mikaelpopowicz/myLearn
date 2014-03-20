<div class="page-header">
	<h1>Liste des classes</h1>
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
		<h3>Choisissez une classe</h3>
	</div>
	<div class="row-fluid equal equal-style">
	<?php
	$i = 0;
	if(isset($classes) && is_array($classes))
	{	
		foreach ($classes as $classe) {
			$classe = unserialize(base64_decode($classe));
	?>
	
	<div class="span3">
		<a class="innershadows btn btn-block btn-primary" href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.urlencode(str_replace(' ','-',$classe->libelle()));?>"><h2> <?php echo $classe->libelle();?> <small><span class="muted"><?php echo $classe->session()->session();?></span></small></h2></a>
		<div class="content">
			<p class="text-center">
				<?php 
				echo count($classe->matieres());
				?> matière(s) disponible(s)
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