<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-list-alt fa-lg"></i> Installation</h4>
	</div>
	<div class="panel-body">
		<div class="progress progress-striped active">
			<div class="progress-bar progress-bar-primary"  role="progressbar" style="width: 33.34%"></div>
			<div class="progress-bar progress-bar-info"  role="progressbar" style="width: 11.11%"></div>
			<div class="progress-bar progress-bar-warning"  role="progressbar" style="width: 22.22%"></div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<h4 class="text-primary">Etape 1 :</h4>
				<ul>
					<li>Vérifications <span class="pull-right label label-primary"><i class="fa fa-check"></i> </span></li>
					<li>Ecriture des fichiers <span class="pull-right label label-primary"><i class="fa fa-check"></i> </span></li>
					<li>Création base de donnée <span class="pull-right label label-primary"><i class="fa fa-check"></i> </span></li>
				</ul>
			</div>
			<div class="col-md-4">
				<h4 class="text-info">Etape 2 :</h4>
				<ul>
					<li>Créer une section <span class="pull-right">1</span></li>
					<li>Créer une session <span class="pull-right">1</span></li>
					<li>Créer une classe <span class="pull-right">1</span></li>
				</ul>
			</div>
			<div class="col-md-4">
				<h4 class="text-warning">Etape 3 :</h4>
				<ul>
					<li>Créer une matière <span class="pull-right">1</span></li>
					<li>Ajouter un professeur <span class="pull-right">1</span></li>
					<li>Ajouter un élève <span class="pull-right">1</span></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-tasks fa-lg"></i> Gestion</h3>
			</div>
			<div class="panel-body">
				<div class="list-group">
					<a href="/admin/section" class="list-group-item">
						<span class="badge badge-info">3</span>
						Section
					</a>
					<a href="/admin/session" class="list-group-item">
						<span class="badge badge-info">3</span>
						Session
					</a>
					<a href="/admin/classe" class="list-group-item">
						<span class="badge badge-info">3</span>
						Classe
					</a>
				</div>		
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-file-text fa-lg"></i> Contenus</h3>
			</div>
			<div class="panel-body">
				<div class="list-group">
					<a href="/admin/matiere" class="list-group-item">
						<span class="badge badge-success">3</span>
						Matière
					</a>
					<a href="/admin/cours" class="list-group-item">
						<span class="badge badge-success">3</span>
						Cours
					</a>
					<a href="/admin/devoirs" class="list-group-item">
						<span class="badge badge-success">3</span>
						Devoirs
					</a>
				</div>	
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-users fa-lg"></i> Utilisateurs</h3>
			</div>
			<div class="panel-body">
				<div class="list-group">
					<a href="/admin/administrateur" class="list-group-item">
						<span class="badge badge-warning">3</span>
						Administrateur
					</a>
					<a href="/admin/professeurs" class="list-group-item">
						<span class="badge badge-warning">3</span>
						Professeur
					</a>
					<a href="/admin/eleves" class="list-group-item">
						<span class="badge badge-warning">3</span>
						Elève
					</a>
				</div>	
			</div>
		</div>
	</div>
</div>
<div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="pull-right">
			<a href="/admin/parametres" class="btn btn-primary btn-xs">
				<i class="fa fa-edit fa-lg"></i> Editer
			</a>
		</div>
		<h1 class="panel-title"><i class="fa fa-cog fa-lg"></i> Paramètres</h1>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				<h4 class="text-primary">Informations</h4>
				<hr>
				<dl class="dl-horizontal">
					<dt>Etablissement</dt>
					<dd><?php echo $nom;?></dd>
					<dt>Description</dt>
					<dd><?php echo $desc;?></dd>
				</dl>
			</div>
			<div class="col-md-4">
				<h4 class="text-primary">Configuration base de donnée</h4>
				<hr>
				<dl class="dl-horizontal">
					<dt>Hôte</dt>
					<dd><?php echo $hote;?></dd>
					<dt>Base</dt>
					<dd><?php echo $base;?></dd>
					<dt>Utilisateur</dt>
					<dd><?php echo $db_user;?></dd>
				</dl>
			</div>
			<div class="col-md-4">
				<h4 class="text-primary">Connexion</h4>
				<hr>
				<dl class="dl-horizontal">
					<dt>Login</dt>
					<dd><?php echo $user->getAttribute('username');?></dd>
				</dl>
			</div>
		</div>
	</div>
</div>