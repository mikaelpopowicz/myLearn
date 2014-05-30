
	<form method="post" class="form-horizontal">
		
		<!--==== Barre de boutons ====-->
		<div class="well">
			<span class="text-success"><strong><i class="fa fa-share fa-lg"></i> Actions sur la sélection :</strong></span>
			<button type="submit" name="modifier"class="btn btn-primary">
				<i class="fa fa-edit fa-fw"></i> Modifier
			</button>
			<button type="submit" name="supprimer"class="btn btn-warning">
				<i class="fa fa-trash-o fa-fw"></i> Supprimer
			</button>
			<div class="pull-right">
				<a href="/professeur/cours/ecrire-un-cours" class="btn btn-success">
					<i class="fa fa-plus-square-o"></i> Ajouter
				</a>
			</div>
		</div>
		
		<!--====  Tableau des cours ====-->
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped datatable">
				<thead>
					<tr>
						<th><input type="checkbox" name="checkAll" id="checkAll"></th>
						<th width="300">Nom</th>
						<th>Dernière modification</th>
						<th><i class="fa fa-eye"></i></th>
						<th><i class="fa fa-comments-o"></i></th>
						<th>Classe</th>
						<th>Session</th>
					</tr>
				</thead>
				<tbody id="tabs">
					<?php
					if(isset($listeCours) && is_array($listeCours) && !empty($listeCours)) {
						foreach($listeCours as $cours) {
							echo "<tr>";
							echo "<td><input type='checkbox' name='check[]' value='".$cours['id']."'></td>";
							?>
							<td id='click' onclick="document.location='/professeur/cours/<?php echo str_replace('/','-',$cours->classe()->session()->session())."/".$cours->classe()->uri()."/".$cours->uri();?>'"><?php echo $cours->titre();?></td>
							<?php
							echo "<td>".$cours->dateModif()->format('d/m/Y')."</td>";
							echo "<td>".count($cours->vues())."</td>";
							echo "<td>".count($cours->commentaires())."</td>";
							echo "<td>".$cours->classe()->libelle()."</td>";
							echo "<td>".$cours->classe()->session()->session()."</td>";
							echo "</tr>";
						}
					}
					?>
				</tbody>
			</table>
		</div>
		
		
	</form>