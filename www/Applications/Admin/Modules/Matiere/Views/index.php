<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/">Accueil</a></li>
			<li class="active">Liste des matières</li>
		</ol>
	</div>
</div>
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
				<button type="submit" name="volume"class="btn btn-danger">
					<i class="fa fa-pus-square-o fa-fw"></i> Ajout en masse
				</button>
				<div class="pull-right">
					<a href="/admin/matieres/nouvelle-matiere" class="btn btn-success">
						<i class="fa fa-plus-square-o"></i> Ajouter
					</a>
				</div>
			</div>
			
			<table class="table table-striped table-hover table-bordered datatable" id="planTab">
				<thead>
					<tr>
						<th width="50 px"><input name="check_all" id="check_all" type="checkbox"></th>
						<th>Libellé</th>
						<th>Icône</th>
						<th>Id</th>                                   
					</tr>
				</thead>
				<tbody id='tabs'>
					<?php
					if (isset($listeMatiere) && is_array($listeMatiere)) {
						foreach($listeMatiere as $matiere) {
							echo "<tr>";
							echo "\n\t\t\t\t\t\t\t<td>";
							echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".$matiere['id'].">";
							echo "\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$matiere['libelle']."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<i class='".$matiere['icon']."'></i>\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$matiere['id']."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t</tr>\n";
						}
					}
					?>
				</tbody>
			</table>
			
		</form>
	</div>
</div>