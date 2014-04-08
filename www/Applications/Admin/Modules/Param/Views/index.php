<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li class="active">Paramètres</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">		
		<div class="row">
			<div class="col-md-4">
				<div class="page-header">
					<h3 class="text-primary">Informations</h3>
				</div>
				<dl class="dl-horizontal">
					<dt>Version</dt>
					<dd><?php echo $config->get('version');?></dd>
					<dt>Date installation</dt>
					<dd><?php echo $config->get('conf_date');?></dd>
					<dt>Nom établissement</dt>
					<dd><?php echo $config->get('conf_nom');?></dd>
					<dt>Description</dt>
					<dd><?php echo $config->get('conf_description');?></dd>
					<dt>Email d'envoi</dt>
					<dd><?php echo $config->get('conf_email');?></dd>
					<dt>Email de contact</dt>
					<dd><?php echo $config->get('conf_contact');?></dd>
				</dl>
				<p class="text-center">
					<a href="/admin/parametres/modifier-informations" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</a>
				</p>
			</div>
			<div class="col-md-4">
				<div class="page-header">
					<h3 class="text-primary">Configuration base de données</h3>
				</div>
				<dl class="dl-horizontal">
					<dt>Hôte</dt>
					<dd><?php echo ($config->get('db_host'));?></dd>
					<dt>Nom de la base</dt>
					<dd><?php echo $config->get('db_name');?></dd>
					<dt>Utilisateur</dt>
					<dd><?php echo $config->get('db_user');?></dd>
				</dl>
				<p class="text-center">
					<a href="/admin/parametres/modifier-bdd" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</a>
				</p>
			</div>
			<div class="col-md-4">
				<div class="page-header">
					<h3 class="text-primary">Connexion</h3>
				</div>
				<dl class="dl-horizontal">
					<dt>Username</dt>
					<dd><?php echo $user->getAttribute('username');?></dd>
					<dt>Email</dt>
					<dd><?php echo $user->getAttribute('email');?></dd>
				</dl>
				<p class="text-center">
					<a href="/admin/parametres/modifier-user" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</a>
				</p>
			</div>
		</div>
	</div>
</div>