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
			<div class="col-md-6">
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
					<dt>Email de contact</dt>
					<dd><?php echo $config->get('conf_contact');?></dd>
					<dt>&nbsp;</dt>
					<dd>&nbsp;</dd>
					<dt>&nbsp;</dt>
					<dd><a href="/admin/parametres/modifier-informations" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</a></dd>
				</dl>
			</div>
			<div class="col-md-6">
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
					<a href="/admin/parametres/modifier-user" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier profil</a>
					<a href="/admin/parametres/modifier-password" class="btn btn-warning"><i class="fa fa-edit"></i> Modifier mot de passe</a>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
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
					<dt>&nbsp;</dt>
					<dd>&nbsp;</dd>
					<dt>&nbsp;</dt>
					<dd><a href="#" class="btn btn-primary disabled"><i class="fa fa-edit"></i> Modifier</a><dd>
				</dl>
			</div>
			<div class="col-md-6">
				<div class="page-header">
					<h3 class="text-primary">Configuration d'envoi SMTP</h3>
				</div>
				<dl class="dl-horizontal">
					<dt>Serveur</dt>
					<dd><?php echo $config->get('smtp_host');?></dd>
					<dt>Port</dt>
					<dd><?php echo $config->get('smtp_port');?></dd>
					<dt>Username</dt>
					<dd><?php echo $config->get('smtp_user');?></dd>
					<dt>Email d'envoi</dt>
					<dd><?php echo $config->get('conf_email');?></dd>
					<dt>&nbsp;</dt>
					<dd>&nbsp;</dd>
					<dt>&nbsp;</dt>
					<dd><a href="/admin/parametres/modifier-smtp" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</a></dd>
				</dl>
			</div>
		</div>
	</div>
</div>