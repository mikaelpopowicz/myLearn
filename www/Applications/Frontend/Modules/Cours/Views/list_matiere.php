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
	<?php
	if(isset($listeMatiere) && is_array($listeMatiere))
	{
		?>
    <div class="headline">
		<h3>Choisissez votre matière</h3>
	</div>
	<div class="row-fluid equal equal-style">
		<?php
		$i = 0;
		foreach ($listeMatiere as $matiere) {
	?>
	<div class="span3">
		<a class="innershadows btn btn-block btn-primary" href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.$classe->uri()."/".$matiere->uri();?>"><h2><i class="<?php echo $matiere->icon();?>"></i> <?php echo $matiere->libelle();?></h2></a>
		<div class="content">
			<p class="text-center">
				<?php 
				echo $matiere->cours();
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
	else if (isset($message))
	{
		echo $message;
	}
	?>
	</div><!--/row-fluid-->
</div>