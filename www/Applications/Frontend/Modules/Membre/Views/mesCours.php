<div class="page-header">
	<h1>Mes cours</h1>
</div>
<div class="strip primary">
	<div class="container">
		<ul class="inline">
			<li>
				<a href="/" class="primary-color">Accueil</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				Mes cours
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="row-fluid">
			<div class="span3">
				<ul class="nav nav-pills nav-stacked">
					<li class="<?php echo isset($class_profil) ? $class_profil : "";?>">
						<a href="/mon-compte">Mes informations</a>
					</li>
					<li class="<?php echo isset($class_mes_cours) ? $class_mes_cours : "";?>">
						<a href="/mon-compte/mes-cours">Mes cours</a>
					</li>
				</ul>
			</div>
			<div class="span9">
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
						<th><input type="checkbox" name="checkAll" id="check_all"></th>
						<th width="300">Nom</th>
						<th>Matière</th>
						<th>Dernière modification</th>
						<th><i class="fa fa-eye fa-lg"></i></th>
						<th><i class="fa fa-comments-o fa-lg"></i></th>
						<th>Classe</th>
						<th>Session</th>
					</tr>
				</thead>
				<tbody id="tabs">
					<?php
					if(isset($listeCours) && is_array($listeCours) && !empty($listeCours)) {
						foreach($listeCours as $cours) {
							echo "<tr>";
							echo "<td><input type='checkbox' name='check[]' value='".$cours->id()."'></td>";
							?>
							<td id='click' onclick="document.location='/cours/<?php echo str_replace('/','-',$cours->classe()->session()->session())."/".$cours->classe()->uri()."/".$cours->matiere()->uri()."/".$cours->uri();?>'"><?php echo $cours->titre();?></td>
							<?php
							echo "<td>".$cours->matiere()->libelle()."</td>";
							echo "<td>".$cours->dateModif()->format('d/m/Y à H:i')."</td>";
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
			</div>
		</div>
	</div>
</div>