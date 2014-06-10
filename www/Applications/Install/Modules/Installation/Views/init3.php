<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form role="check" class="form-horizontal" method="post">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Informations établissement <span class="pull-right">Etape 3/5</span></h3>
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
					<div class="form-group">
						<label for="contact" class="col-sm-3 control-label">Email de contact</label>
						<div class="col-sm-4">
							<input type="text" id="contact" name="contact" class="form-control" placeholder="Mail de contact de l'école" value="<?php echo isset($infos) ? $infos['contact'] : "";?>">
							<?php
							if(isset($erreur) && in_array('contact', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="address" class="col-sm-3 control-label">Adresse</label>
					<div class="col-sm-4">
						<input type="text" id="address" name="address" class="form-control" placeholder="10 rue de l'Université" value="<?php echo isset($infos) ? $infos['address'] : "";?>">
						<?php
						if(isset($erreur) && in_array('address', $erreur)) {
							echo "<span class='help-block'></span>";
						}
						?>
					</div>
				</div>
				<div class="form-group">
					<label for="ville" class="col-sm-3 control-label">Ville</label>
					<div class="col-sm-4">
						<input type="text" id="ville" name="ville" class="form-control" placeholder="Paris" value="<?php echo isset($infos) ? $infos['ville'] : "";?>">
						<?php
						if(isset($erreur) && in_array('ville', $erreur)) {
							echo "<span class='help-block'></span>";
						}
						?>
					</div>
				</div>
				<div class="form-group">
					<label for="cp" class="col-sm-3 control-label">Code postal</label>
					<div class="col-sm-4">
						<input type="text" id="cp" name="cp" class="form-control" placeholder="75 001" value="<?php echo isset($infos) ? $infos['cp'] : "";?>">
						<?php
						if(isset($erreur) && in_array('cp', $erreur)) {
							echo "<span class='help-block'></span>";
						}
						?>
					</div>
				</div>
				<div class="form-group">
					<label for="tel" class="col-sm-3 control-label">Téléphone</label>
					<div class="col-sm-4">
						<input type="text" id="tel" name="tel" class="form-control" placeholder="01 02 03 04 05" value="<?php echo isset($infos) ? $infos['tel'] : "";?>">
						<?php
						if(isset($erreur) && in_array('tel', $erreur)) {
							echo "<span class='help-block'></span>";
						}
						?>
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