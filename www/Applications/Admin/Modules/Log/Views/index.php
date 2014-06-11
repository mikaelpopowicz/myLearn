<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li class="active">Logs de connexion</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">			
		<table class="table table-hover table-bordered datatable" id="planTab">
			<thead>
				<tr>
					<th>Login utilisé</th>
					<th>Utilisateur</th>
					<th>@IP</th>
					<th>Etat</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody id='tabs'>
				<?php
				if (isset($logs) && is_array($logs)) {
					foreach($logs as $log) {
						$use = ($log->user() instanceof \Library\Entities\User) ? $log->user()->nom()." ".$log->user()->prenom() : "<strong>Non trouvé</strong>";
						echo "<tr>";
						echo "<td>".$log->login()."</td>";
						echo "<td>".$use."</td>";
						echo "<td>".$log->source()."</td>";
						echo "<td><span class='label label-".$log->classe()."'>".$log->etat()."</span></td>";
						echo "<td>".$log->dateConnexion()->format('d/m/Y')."</td>";
						echo "\n\t\t\t\t\t\t</tr>\n";
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div>