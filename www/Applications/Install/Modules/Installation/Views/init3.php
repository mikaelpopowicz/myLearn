<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form role="check" class="form-horizontal" method="post">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Informations établissement <span class="pull-right">Etape 3/4</span></h3>
				</div>
				<div class="panel-body">
					<p>
						Veuillez saisir les informations suivante :
					</p>
					<div class="form-group">
						<label for="nom" class="col-sm-3 control-label">Nom établissement</label>
						<div class="col-sm-4">
							<input type="text" id="nom" name="nom" class="form-control" placeholder="Ecole ..." value="<?php echo isset($infos) ? $infos['nom'] : "";?>" autofocus>
							<?php
							if(isset($erreur) && in_array('nom', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-4">
							<textarea id="description" name="description" class="form-control"><?php echo isset($infos) ? ($infos['description']) : "Description pour la page de connexion";?></textarea>
							<?php
							if(isset($erreur) && in_array('description', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<button name="previous" class="btn btn-default">Retour</button>
					<button name="next" class="btn btn-primary pull-right" <?php echo isset($next) ? $next : ""?> >Suivant</button>	
				</div>
			</form>
		</div>
	</div>
</div>