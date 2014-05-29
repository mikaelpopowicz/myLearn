<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li><a href="/professeur/cours">Liste des classes</a></li>
			<li><a href="/professeur/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.$classe->uri()?>"><?php echo $classe->libelle().' - '.$classe->session()->session()?></a></li>
			<li class="active"><?php echo $cours->titre();?></li>
		</ol>
	</div>
</div>
<section id="cours">
	<h1 class="text-primary">
		<?php echo $cours->titre();?>
	</h1>
	<div>
		<i class="fa fa-pencil"></i>&nbsp; <?php echo $cours->auteur()->nom().' '.$cours->auteur()->prenom();?>
		&nbsp;&nbsp;&nbsp;
		<i class="fa fa-clock-o"></i>&nbsp; <?php echo $cours->dateAjout()->format('d/m/Y');?>
	</div>
	<br/>
	<div>
		<?php echo $cours->contenu();?>
	</div>
</section>