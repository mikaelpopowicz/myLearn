<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li class="active">Devoirs</li>
		</ol>
	</div>
</div>
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
				<a href="/professeur/devoirs/nouveau-devoir" class="btn btn-success">
					<i class="fa fa-plus-square-o"></i> Ajouter
				</a>
			</div>
		</div>
		
		<!--====  Tableau des devoirs ====-->
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped datatable">
				<thead>
					<tr>
						<th><input name="check_all" id="check_all" type="checkbox"></th>
						<th width="300">Libelle</th>
						<th>Classe</th>
						<th>Session</th>
						<th>Date max</th>
						<th>Elèves</i></th>
						<th>Rendu</th>
						<th>Actif</th>
					</tr>
				</thead>
				<tbody id="tabs">
					<?php
					if(isset($devoirs) && is_array($devoirs) && !empty($devoirs)) {
						foreach($devoirs as $devoir) {
							$active = $devoir['active'] == 1 ? "<span class='label label-success'>oui</span>" : "<span class='label label-danger'>non</span>";
							$count = 0;
							if(is_array($devoir->rendus()) && $devoir->rendus())
							{
								foreach ($devoir->rendus() as $key) {
									if(count($key->pieces()) > 0)
									{
										$count++;
									}
								}
							}							
							echo "<tr>";
							echo "<td><input type='checkbox' name='check[]' value='".base64_encode(serialize($devoir))."'></td>";
							echo "<td><a href='/professeur/devoirs/".$devoir->id()."'>".$devoir->libelle()."</a></td>";
							echo "<td>".$devoir->classe()->libelle()."</td>";
							echo "<td>".$devoir->classe()->session()->session()."</td>";
							echo "<td>".$devoir->dateMax()->format('d/m/Y')."</td>";
							echo "<td>".count($devoir->rendus())."</td>";
							echo "<td>".$count."</td>";
							echo "<td>".$active."</td>";
							echo "</tr>";
						}
					}
					?>
				</tbody>
			</table>
		</div>
		
		
	</form>