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
						<a href="/membre/mon-profil">Mes informations</a>
					</li>
					<li class="<?php echo isset($class_mes_cours) ? $class_mes_cours : "";?>">
						<a href="/membre/mes-cours">Mes cours</a>
					</li>
					<li class="<?php echo isset($class_config) ? $class_config : "";?>">
						<a href="/membre/ma-configuration">Configuration</a>
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
						<th><input type="checkbox" name="checkAll" id="checkAll"></th>
						<th width="300">Nom</th>
						<th>Matière</th>
						<th>Vues</th>
						<th>Commentaires</th>
					</tr>
				</thead>
				<tbody id="tabs">
					<?php
					if(isset($listeCours) && is_array($listeCours) && !empty($listeCours)) {
						foreach($listeCours as $cours) {
							echo "<tr>";
							echo "<td><input type='checkbox' name='check[]' value='".$cours['id']."'></td>";
							?>
							<td id='click' onclick="document.location='/cours/<?php echo $cours['matiere'];?>/<?php echo $cours['id']?>'"><?php echo $cours['titre'];?></td>
							<?php
							echo "<td>".$cours['matiere']."</td>";
							echo "<td>".$count->getCount($cours['id'])['count_c']."</td>";
							echo "<td>".$manC->getCountOf($cours['id'])."</td>";
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