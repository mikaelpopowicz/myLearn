<div class="page-header">
	<h1><?php echo $devoir->libelle();?></h1>
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
				<a href="/devoirs" class="primary-color">Devoirs</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<?php echo $devoir->libelle();?>
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="row-fluid">
			<div class="span8">
				<p>
					<strong>Enoncé :</strong><br/>
					<?php echo $devoir->enonce();?>
				</p>
				<p>
					<strong>Fichier(s) :</strong>
					<?php
					if(is_array($devoir->pieces()) && !empty($devoir->pieces()))
					{
						echo '<ul>';
						foreach ($devoir->pieces() as $fichier) {
							echo "<li>";
							echo "<a target='blank' href='/devoirs/consulter-".$devoir->id()."/telecharger-".$fichier->id()."'>".$fichier->libelle()."</a>";
							echo "</li>";
						}
						echo "</ul>";
					}
					?>
				</p>
			</div>
			<div class="span4">
				<div class="well">
					<form method="post" class="form-horizontal">
						<p class="text-warning">
							<i class="fa fa-upload"></i> Documents à rendre
							<span class="pull-right">
								<button type="submit" name="supprimer_piece"class="btn btn-warning btn-mini">
									<i class="fa fa-trash-o fa-fw"></i> Supprimer
								</button>
								<a class="btn btn-success btn-mini" data-toggle="modal" href="#AddPiece">
									<i class="fa fa-plus-square-o fa-fw"></i> Ajouter
								</a>
							</span>
						</p>
						<table class="table">
							<thead>
								<tr>
									<th width="50 px"><input name="check_all" id="check_all" type="checkbox"></th>
									<th>Libelle</th>
									<th>Upload</th>
								</tr>
							</thead>
							<tbody id="tabs">
								<?php
								if(is_array($devoir->rendus()->pieces()) && !empty($devoir->rendus()->pieces()))
								{
									foreach ($devoir->rendus()->pieces() as $piece) {
										echo "<tr>";
										echo "\n\t\t\t\t\t\t\t<td>";
										echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".base64_encode(serialize($piece)).">";
										echo "\n\t\t\t\t\t\t\t</td>";
										echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<a target='blank' href='/devoirs/consulter-".$devoir->id()."/document-".$piece->id()."'>".$piece->libelle()."</a>\n\t\t\t\t\t\t\t</td>";
										echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$piece->dateUpload()->format('d/m/Y')."\n\t\t\t\t\t\t\t</td>";
										echo "\n\t\t\t\t\t\t</tr>\n";
									}
								}
								else
								{
									echo "<tr><td colspan='3'>Aucun document</td></tr>";
								}
								
								?>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>