<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li class="active">Liste des classes</li>
		</ol>
	</div>
</div>
<?php
$i = 0;
if(isset($classes) && is_array($classes))
{	
	echo '<div class="row">';
	foreach ($classes as $classe) {
		$classe = unserialize(base64_decode($classe));
?>

	<div class="col-md-3">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h2 class="panel-title">
					<a href="/professeur/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.$classe->uri();?>">
						<?php echo $classe->libelle();?>
					</a>
					<span class="text-muted"><?php echo $classe->session()->session();?></span>
				</h2>
			</div>
			<div class="panel-body>">
				<p class="text-center">
				<?php 
				foreach ($classe->matieres() as $mat) {
					if($matiere->id() == $mat->id()) echo $mat->cours();
				}
				?> cours disponible(s)
				</p>
			</div>
		</div>
	</div>
<?php
$i++;
if ($i != 0 && $i%4 == 0) {
?>
	</div>
	<br>
	<div class="row">
<?php
		}
	}
	echo '</div>';
}
?>