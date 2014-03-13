<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/classe">Liste des classes</a></li>
			<li class="active"><?php echo $classe->libelle();?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-info-circle fa-lg"></i> Informations</h4>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<dl class="dl-horizontal">
							<dt>Libellé</dt>
							<dd><?php echo $classe->libelle();?></dd>
							<dt>Session</dt>
							<dd><?php echo $session->getUnique($classe->session())->session();?></dd>
							<dt>Section</dt>
							<dd><?php echo $section->getUnique($classe->section())->libelle();?></dd>
						</dl>
					</div>
					<div class="col-lg-6">
						<dl class="dl-horizontal">
							<dt>Nombre de matière</dt>
							<dd><?php echo $assigner->countOf($classe->id());?>
							<dt>Nombre de professeur</dt>
							<dd><?php echo $charger->countOf($classe->id());?>
							<dt>Nombre d'élève</dt>
							<dd><?php echo $etre->countOf($classe->id());?>
						</dl>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<form method="post" class="form-horizontal">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h4 class="panel-title">
						<i class="fa fa-list-alt fa-lg"></i> Matières
						<div class="pull-right">
							<button type="submit" name="supprimer_matiere"class="btn btn-warning btn-xs">
								<i class="fa fa-trash-o fa-fw"></i> Supprimer
							</button>
							<a class="btn btn-success btn-xs" data-toggle="modal" href="#AddMatiere">
								<i class="fa fa-plus-square-o"></i> Ajouter
							</a>
						</div>
					</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-bordered datatable" id="professeurTab">
						<thead>
							<tr>
								<th width="50 px"><input name="check_all" id="check_all" type="checkbox"></th>
								<th>Libellé</th>
								<th>Icone</th>
							</tr>
						</thead>
						<tbody id='tabs'>
							<?php
							if (isset($matiereClasse) && is_array($matiereClasse)) {
								foreach($matiereClasse as $matiere) {
									echo "<tr>";
									echo "\n\t\t\t\t\t\t\t<td>";
									echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".$matiere['id'].">";
									echo "\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$matiere->libelle()."\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<i class='".$matiere->icon()."'></i>\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t</tr>\n";
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		<form method="post" class="form-horizontal">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h4 class="panel-title">
						<i class="fa fa-users fa-lg"></i> Professeurs
						<div class="pull-right">
							<button type="submit" name="supprimer_professeur"class="btn btn-warning btn-xs">
								<i class="fa fa-trash-o fa-fw"></i> Supprimer
							</button>
							<a class="btn btn-success btn-xs" data-toggle="modal" href="#AddProfesseur">
								<i class="fa fa-plus-square-o"></i> Ajouter
							</a>
						</div>
					</h4>
				
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-bordered datatable" id="professeurTab">
						<thead>
							<tr>
								<th width="50 px"><input name="check_all" id="check_all1" type="checkbox"></th>
								<th>Nom</th>
								<th>Prénom</th>
							</tr>
						</thead>
						<tbody id='tabs1'>
							<?php
							if (isset($professeurClasse) && is_array($professeurClasse)) {
								foreach($professeurClasse as $professeur) {
									echo "<tr>";
									echo "\n\t\t\t\t\t\t\t<td>";
									echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".$professeur['id'].">";
									echo "\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$professeur->nom()."\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$professeur->prenom()."\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t</tr>\n";
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
	<div class="col-lg-6">
		<form method="post" class="form-horizontal">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h4 class="panel-title">
						<i class="fa fa-users fa-lg"></i> Elèves
						<div class="pull-right">
							<button type="submit" name="supprimer_eleve"class="btn btn-warning btn-xs">
								<i class="fa fa-trash-o fa-fw"></i> Supprimer
							</button>
							<a class="btn btn-success btn-xs" data-toggle="modal" href="#AddEleve">
								<i class="fa fa-plus-square-o"></i> Ajouter
							</a>
						</div>
					</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover table-bordered datatable" id="eleveTab">
						<thead>
							<tr>
								<th width="50 px"><input name="check_all1" id="check_all2" type="checkbox"></th>
								<th>Nom</th>
								<th>Prénom</th>
							</tr>
						</thead>
						<tbody id="tabs2">
							<?php
							if (isset($eleveClasse) && is_array($eleveClasse)) {
								foreach($eleveClasse as $eleve) {
									echo "<tr>";
									echo "\n\t\t\t\t\t\t\t<td>";
									echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".$eleve['id'].">";
									echo "\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$eleve->nom()."\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$eleve->prenom()."\n\t\t\t\t\t\t\t</td>";
									echo "\n\t\t\t\t\t\t</tr>\n";
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>