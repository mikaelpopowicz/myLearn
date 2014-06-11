<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li><a href="/professeur/devoirs">Devoirs</a></li>
			<li class="active"><?php echo $devoir->libelle();?></li>
		</ol>
	</div>
</div>

<section>
	<ul class="nav nav-tabs nav-justified">
		<li class="active"><a href="#general" data-toggle="tab">Général</a></li>
		<li><a href="#travaux" data-toggle="tab">Travaux</a></li>
		<li><a href="#notes" data-toggle="tab">Notes</a></li>
	</ul>
</section>

<div class="tab-content">
	<div class="tab-pane fade in active" id="general">
		<h1 class="page-header">
			<?php echo $devoir->libelle();?>
			<div class="pull-right">
				<?php
				if($devoir->active() == 0)
				{
				?>
				<form method="post">
					<button type="submit" name="activer"class="btn btn-primary">
						<i class="fa fa-check fa-fw"></i> Activer le devoir
					</button>
				</form>
				<?php
				}
				else
				{
				?>
				<small><span class='label label-success'>Activé</span></small>
				<?php	
				}
				?>
		
			</div>
		</h1>
		<div class="row">
			<div class="col-lg-8">
				
				<p>
					<strong>Enoncé :</strong><br/>
					<?php echo $devoir->enonce();?>
				</p>
			</div>
			<div class="col-lg-4">
				<form method="post" class="form-horizontal">
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h4 class="panel-title">
								<i class="fa fa-file fa-lg"></i> Pièces jointes
								<div class="pull-right">
									<button type="submit" name="supprimer_piece"class="btn btn-warning btn-xs">
										<i class="fa fa-trash-o fa-fw"></i> Supprimer
									</button>
									<a class="btn btn-success btn-xs" data-toggle="modal" href="#AddPiece">
										<i class="fa fa-plus-square-o"></i> Ajouter
									</a>
								</div>
							</h4>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover table-bordered table-condensed" id="piecesTab">
								<thead>
									<tr>
										<th width="50 px"><input name="check_all" id="check_all" type="checkbox"></th>
										<th>Libelle</th>
										<th>Upload</th>
									</tr>
								</thead>
								<tbody id="tabs">
									<?php
									if ($devoir->pieces() && is_array($devoir->pieces())) {
										foreach($devoir->pieces() as $piece) {
											echo "<tr>";
											echo "\n\t\t\t\t\t\t\t<td>";
											echo "\n\t\t\t\t\t\t\t\t<input name='check[]' type='checkbox' value=".base64_encode(serialize($piece)).">";
											echo "\n\t\t\t\t\t\t\t</td>";
											echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<a target='blank' href='/professeur/devoirs/".$devoir->id()."/".$piece->id()."'>".$piece->libelle()."</a>\n\t\t\t\t\t\t\t</td>";
											echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$piece->dateUpload()->format('d/m/Y')."\n\t\t\t\t\t\t\t</td>";
											echo "\n\t\t\t\t\t\t</tr>\n";
										}
									}
									else
									{
										echo "<td colspan='3'>Aucune pièce jointe</td>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="travaux">
		<br/>
		<table class="table table-striped table-hover table-bordered datatable" id="renduTab">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Nombre de documents</th>
					<th>Dernier upload</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="tabs">
				<?php
				if ($devoir->rendus() && is_array($devoir->rendus())) {
					foreach($devoir->rendus() as $rendu) {
						$last = "jamais";
						$action = "";
						if(is_array($rendu->pieces()) && $rendu->pieces())
						{
							$action = "<ul class='list-inline'>";
							foreach ($rendu->pieces() as $piece) {
								$action .= '<li><a target="blank" href="/professeur/devoirs/'.$devoir->id().'/production-'.$piece->id().'">'.$piece->libelle().'</a></li>';
								if(($last instanceof \DateTime && $last < $piece->dateUplaod()) || $last == 'jamais')
								{
									$last = $piece->dateUpload()->format('d/m/Y');
								}
							}
							$action .= "</ul>";
						}
						
						
						echo "<tr>";
						echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$rendu->eleve()->nom()."\n\t\t\t\t\t\t\t</td>";
						echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$rendu->eleve()->prenom()."\n\t\t\t\t\t\t\t</td>";
						echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".count($rendu->pieces())."\n\t\t\t\t\t\t\t</td>";
						echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$last."\n\t\t\t\t\t\t\t</td>";
						echo "\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t".$action."\n\t\t\t\t\t\t\t</td>";
						echo "\n\t\t\t\t\t\t</tr>\n";
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="tab-pane fade" id="notes">
		<?php
		if($note)
		{
		?>
		<?php	
		}
		else
		{
			echo "<h3 class='text-warning text-center'>Vous pourrez noter à partir de la date maximum</h3>";
		}
		?>
	</div>
</div>

