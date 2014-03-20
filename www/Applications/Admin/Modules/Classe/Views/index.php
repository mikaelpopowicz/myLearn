<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li class="active">Liste des classes</li>
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
				<div class="pull-right">
					<a href="/admin/classes/nouvelle-classe" class="btn btn-success">
						<i class="fa fa-plus-square-o"></i> Ajouter
					</a>
				</div>
			</div>
			
			<table class="table table-hover table-bordered datatable" id="planTab">
				<thead>
					<tr>
						<th width="50 px"><input name="check_all" id="check_all" type="checkbox"></th>
						<th>Classe</th>
						<th>Section</th>
						<th>Session</th>
						<th>Nombre de professeurs</th>
						<th>Nombre d'élèves</th>
					</tr>
				</thead>
				<tbody id='tabs'>
					<?php
					if (isset($listeClasse) && is_array($listeClasse)) {
						foreach($listeClasse as $classe) {
							echo "<tr>";
							echo "\n\t\t\t\t\t\t\t<td>";
							echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".$classe['id'].">";
							echo "\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t";
							echo "<a href='/admin/classes/".$classe['id']."'>".$classe->libelle();
							echo "\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$classe->section()->libelle()."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$classe->session()->session()."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".count($classe->professeurs())."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".count($classe->eleves())."\n\t\t\t\t\t\t\t</td>";
							echo "\n\t\t\t\t\t\t</tr>\n";
						}
					}
					?>
				</tbody>
			</table>
			
		</form>
	</div>
</div>