<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-list-alt fa-lg"></i> Installation</h4>
	</div>
	<div class="panel-body">
		<div class="progress progress-striped active">
			<?php
			if($etapes['2']['compteur'] + $etapes['3']['compteur'] < 66.66) {
			?>
			<div class="progress-bar progress-bar-primary"  role="progressbar" style="width: 33.34%"></div>
			<div class="progress-bar progress-bar-info"  role="progressbar" style="width: <?php echo $etapes['2']['compteur'];?>%"></div>
			<div class="progress-bar progress-bar-warning"  role="progressbar" style="width: <?php echo $etapes['3']['compteur'];?>%"></div>
			<?php
			} else {
			?>
			<div class="progress-bar progress-bar-success"  role="progressbar" style="width: 100%"></div>
			<?php
			}
			?>
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
			<?php
			foreach ($etapes as $key => $value) {
				$class = $key == '2' ? 'text-info' : 'text-warning';
				echo '<div class="col-md-4">';
				echo '<h4 class="'.$class.'">Etape '.$key.' :</h4>';
				echo '<ul>';
				foreach ($value as $par => $val) {
					if($par != 'compteur') {
						echo '<li>'.$val['text'].$val['icon'].'</li>';
					}
				}
				echo '</ul>';
				echo '</div>';
			}
			?>
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
					<a href="/admin/sections" class="list-group-item">
						<span class="badge badge-info"><?php echo $section->count();?></span>
						Section
					</a>
					<a href="/admin/sessions" class="list-group-item">
						<span class="badge badge-info"><?php echo $session->count();?></span>
						Session
					</a>
					<a href="/admin/classes" class="list-group-item">
						<span class="badge badge-info"><?php echo $classe->count();?></span>
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
					<a href="/admin/matieres" class="list-group-item">
						<span class="badge badge-success"><?php echo $matiere->count();?></span>
						Matière
					</a>
					<a href="#" class="list-group-item">
						<span class="badge badge-success"><?php echo $cours->count();?></span>
						Cours
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
					<a href="/admin/professeurs" class="list-group-item">
						<span class="badge badge-warning"><?php echo $prof->count();?></span>
						Professeur
					</a>
					<a href="/admin/eleves" class="list-group-item">
						<span class="badge badge-warning"><?php echo $eleve->count();?></span>
						Elève
					</a>
				</div>	
			</div>
		</div>
	</div>
</div>
<div>
	mcryp => <?php echo extension_loaded ("mcrypt") ? "Oui" : "non" ;?>
</div>