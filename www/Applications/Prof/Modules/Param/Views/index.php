<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li class="active">Paramètres</li>
		</ol>
	</div>
</div>
<section id="infos">
	<h1 class="page-header">
		Mon profil
	</h1>
	<dl class="dl-horizontal">
		<dt>
			Username
		</dt>
		<dd>
			<?php echo !empty($user->getAttribute('username')) ? $user->getAttribute('username') : "&nbsp;" ;?>
		</dd>
		<dt>
			Nom
		</dt>
		<dd>
			<?php echo !empty($user->getAttribute('nom')) ? $user->getAttribute('nom') : "&nbsp;" ;?>
		</dd>
		<dt>
			Prénom
		</dt>
		<dd>
			<?php echo !empty($user->getAttribute('prenom')) ? $user->getAttribute('prenom') : "&nbsp;" ;?>
		</dd>
		<dt>
			Email
		</dt>
		<dd>
			<?php echo !empty($user->getAttribute('email')) ? $user->getAttribute('email') : "&nbsp;" ;?>
		</dd>
	</dl>
	<a class="btn btn-primary" href="/professeur/parametres/modifier-user">
		<i class="fa fa-edit"></i> Modifier profil
	</a>
	<a class="btn btn-warning" href="/professeur/parametres/modifier-password">
		<i class="fa fa-edit"></i> Modifier mot de passe
	</a>
</section>