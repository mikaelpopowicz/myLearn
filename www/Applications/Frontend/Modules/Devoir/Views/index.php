<div class="page-header">
	<h1>Devoirs</h1>
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
				Devoirs
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<form method="post" class="form-horizontal">
		
		<!--====  Tableau des devoirs ====-->
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped datatable">
				<thead>
					<tr>
						<th>Libelle</th>
						<th>Professeur</th>
						<th>Date début</th>
						<th>Date fin</th>
						<th>Classe</th>
						<th>Documents rendus</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody id="tabs">
					<?php
					//echo '<pre>';print_r($devoirs);die('</pre>');
					if(isset($devoirs) && is_array($devoirs) && !empty($devoirs)) {
						foreach($devoirs as $devoir) {
							$rendu = "";
							echo "<tr>";
							echo "<td><a href='/devoirs/consulter-".$devoir->id()."'>".$devoir->libelle()."</a></td>";
							echo "<td>".$devoir->professeur()->nom()." ".$devoir->professeur()->prenom()."</td>";
							echo "<td>".$devoir->dateDevoir()->format('d/m/Y')."</td>";
							echo "<td>".$devoir->dateMax()->format('d/m/Y')."</td>";
							echo "<td>".$devoir->classe()->libelle()."</td>";
							echo "<td>".count($devoir->rendus()->pieces())."</td>";
							echo "<td>".$devoir->rendus()->note()."</td>";
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