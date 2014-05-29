<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form role="check" class="form-horizontal" method="post">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Informations BDD <span class="pull-right">Etape 2/5</span></h3>
				</div>
				<div class="panel-body">
					<p>
						Veuillez saisir les informations suivante :
					</p>
					<div class="form-group">
						<label for="hote" class="col-sm-2 control-label">Hôte</label>
						<div class="col-sm-4">
							<input type="text" id="hote" name="hote" class="form-control" placeholder="localhost" value="<?php echo isset($bdd) ? $bdd['hote'] : "";?>" autofocus>
							<?php
							if(isset($erreur) && in_array('hote', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="base" class="col-sm-2 control-label">Base</label>
						<div class="col-sm-4">
							<input type="text" id="base" name="base" class="form-control" placeholder="mylearn" value="<?php echo isset($bdd) ? $bdd['base'] : "";?>">
							<?php
							if(isset($erreur) && in_array('base', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="user" class="col-sm-2 control-label">Utilisateur</label>
						<div class="col-sm-4">
							<input type="text" id="user" name="user" class="form-control" placeholder="user" value="<?php echo isset($bdd) ? $bdd['user'] : "";?>">
							<?php
							if(isset($erreur) && in_array('user', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-2 control-label">Mot de passe</label>
						<div class="col-sm-4">
							<input type="text" id="password" name="password" class="form-control" placeholder="password" value="<?php echo isset($bdd['password']) ? $bdd['password'] : "";?>"><?php if(isset($erreur) && in_array('password', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
							<button name="connexion" class="btn btn-default">Connexion</button>
						</div>
					</div>
					<?php
					if(isset($message)) echo $message;
					?>
				</div>
				<div class="panel-footer">
					<button name="previous" class="btn btn-default">Retour</button>
					<button name="next" class="btn btn-primary pull-right" <?php echo isset($next) ? $next : ""?> >Suivant</button>	
				</div>
			</form>
		</div>
	</div>
</div>