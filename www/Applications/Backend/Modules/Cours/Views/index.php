<div id="Cours">
	<div class="page-header">
		<h2>Gestion des cours <small>Création, modification et suppression</small></h2>
	</div>
	<form method="post" class="form-horizontal">
		
		<!--==== Barre de boutons ====-->
		<div class="well">
			<button type="submit" name="ajouter"class="btn btn-primary">
				<i class="icon icon-white icon-add"></i> Ajouter
			</button>
			<button type="submit" name="modifier"class="btn btn-warning">
				<i class="icon icon-blue icon-compose"></i> Modifier
			</button>
			<button type="submit" name="supprimer"class="btn btn-danger">
				<i class="icon icon-black icon-cross"></i> Supprimer
			</button>
		</div>
		
		<!--====  Tableau des cours ====-->
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped datatable">
				<thead>
					<tr>
						<th><input type="checkbox" name="checkAll" id="checkAll"></th>
						<th width="300">Nom</th>
						<th>Matière</th>
						<th>Auteur</th>
						<th>Vues</th>
						<th>Commentaires</th>
						<th>Id</th>
					</tr>
				</thead>
				<tbody id="tabs">
					<?php
					if(isset($listeCours) && is_array($listeCours) && !empty($listeCours)) {
						foreach($listeCours as $cours) {
							echo "<tr>";
							echo "<td><input type='checkbox' name='check[]' value='".$cours['id']."'></td>";
							echo "<td>".$cours['titre']."</td>";
							echo "<td>".$manM->getUnique($cours['matiere'])['libelle']."</td>";
							echo "<td>".$cours['auteur']."</td>";
							echo "<td>0</td>";
							echo "<td>0</td>";
							echo "<td>".$cours['id']."</td>";
							echo "</tr>";
						}
					}
					?>
				</tbody>
			</table>
		</div>
		
		
	</form>
</div>