<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li class="active">Liste des élèves</li>
		</ol>
	</div>
</div>
<?php //echo "<pre>";print_r($listeEleve);echo '</pre>';?>
<div class="row">
	<div class="col-lg-12">
		<form method="post" class="form-horizontal">
			<div class="well">
				<span class="text-success"><strong><i class="fa fa-share fa-lg"></i> Actions sur la sélection :</strong></span>
				<button type="submit" name="modifier"class="btn btn-primary">
					<i class="fa fa-edit fa-fw"></i> Modifier
				</button>
				<button type="submit" name="supprimer"class="btn btn-warning">
					<i class="fa fa-trash-o fa-fw"></i> Supprimer
				</button>
				<div class="pull-right">
					<a href="/admin/eleves/nouvel-eleve" class="btn btn-success">
						<i class="fa fa-plus-square-o"></i> Ajouter
					</a>
				</div>
			</div>
			
			<table class="table table-striped table-hover table-bordered datatable" id="planTab">
				<thead>
					<tr>
						<th width="50 px"><input name="check_all" id="check_all" type="checkbox"></th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Actif</th>
						<th>Date de naissance</th>
						<th>Ajouté le</th>
					</tr>
				</thead>
				<tbody id='tabs'>
					<?php
					if (isset($listeEleve) && is_array($listeEleve)) {
						foreach($listeEleve as $eleve) {
							//var_dump($eleve->dateNaissance() instanceof \DateTime);
							$date = ($eleve->dateNaissance() instanceof \DateTime) ? $eleve->dateNaissance()->format('d/m/Y') : "non renseignée";
							$active = $eleve['active'] == 1 ? "<span class='label label-success'>oui</span>" : "<span class='label label-danger'>non</span>";
							echo "<tr>";
							echo "\n\t\t\t\t\t\t\t<td>";
							echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".$eleve['id'].">";
							echo "\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$eleve['nom']."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$eleve['prenom']."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$active."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$date."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$eleve['dateUser']->format('d/m/Y')."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t</tr>\n";
						}
					}
					?>
				</tbody>
			</table>
		</form>
	</div>
</div>