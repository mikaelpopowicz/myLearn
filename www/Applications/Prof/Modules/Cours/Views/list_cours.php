<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li class="active"><?php echo $classe->libelle().' - '.$classe->session()->session()?></li>
		</ol>
	</div>
</div>
<?php
if(isset($lesCours) && is_array($lesCours))
{
	foreach ($lesCours as $cours) {
		echo '<h3><a href="/professeur/cours/'.str_replace('/','-',$classe->session()->session()).'/'.$classe->uri().'/'.$cours->uri().'">'.$cours->titre().'</a>';
		echo '&nbsp;&nbsp;&nbsp;<small><i class="fa fa-pencil"></i>&nbsp;'.$cours->auteur()->nom().' '.$cours->auteur()->prenom();
		echo '&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;'.$cours->dateAjout()->format('d/m/Y').'</small></h3>';
		echo '<p>'.$cours->description();
		echo '&nbsp;<a class="btn btn-outline" href="/professeur/cours/'.str_replace('/','-',$classe->session()->session()).'/'.$classe->uri().'/'.$cours->uri().'">Lire &rarr;</a></p>';
	}
}
else if(isset($erreur))
{
	echo '<h3 class="text-danger">'.$erreur->message().'</h3>';
}
echo isset($pagination) ? $pagination : "";
?>