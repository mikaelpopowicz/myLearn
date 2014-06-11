<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form role="check" class="form-horizontal" method="post">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Configuration email <span class="pull-right">Etape 4/5</span></h3>
				</div>
				<div class="panel-body">
					<p>
						Veuillez saisir les informations suivante :
					</p>
					<div class="form-group">
						<label for="nom" class="col-sm-3 control-label">Serveur SMTP</label>
						<div class="col-sm-4">
							<input type="text" id="host" name="host" class="form-control" placeholder="smtp.domain.tld" value="<?php echo isset($smtp) ? $smtp['host'] : "";?>" autofocus>
							<?php
							if(isset($erreur) && in_array('host', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="nom" class="col-sm-3 control-label">Port SMTP</label>
						<div class="col-sm-4">
							<input type="text" id="port" name="port" class="form-control" placeholder="587" value="<?php echo isset($smtp) ? $smtp['port'] : "";?>">
							<?php
							if(isset($erreur) && in_array('port', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="nom" class="col-sm-3 control-label">Utilisateur</label>
						<div class="col-sm-4">
							<input type="text" id="user" name="user" class="form-control" placeholder="adress@domain.tld" value="<?php echo isset($smtp) ? $smtp['user'] : "";?>">
							<?php
							if(isset($erreur) && in_array('user', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="nom" class="col-sm-3 control-label">Mot de passe</label>
						<div class="col-sm-4">
							<input type="password" id="password" name="password" class="form-control" placeholder="******" value="<?php echo isset($smtp) ? $smtp['password'] : "";?>">
							<?php
							if(isset($erreur) && in_array('password', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="contact" class="col-sm-3 control-label">Email d'envoi</label>
						<div class="col-sm-4">
							<input type="text" id="envoi" name="envoi" class="form-control" placeholder="noreply-mylearn@ecole.fr" value="<?php echo isset($smtp) ? $smtp['envoi'] : "";?>">
							<?php
							if(isset($erreur) && in_array('envoi', $erreur)) {
								echo "<span class='help-block'></span>";
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="security" class="col-sm-3 control-label">Sécurité</label>
						<div class="col-sm-4">
							<div class="radio-inline">
								<label>
									<input type="radio" name="security" id="none" value="none" <?php echo isset($smtp['security']) && $smtp['security'] == "none" ? "checked" : "";?>>
									Aucune
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" name="security" id="ssl" value="ssl" <?php echo isset($smtp['security']) && $smtp['security'] == "ssl" ? "checked" : "";?>>
									SSL
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" name="security" id="tls" value="tls" <?php echo isset($smtp['security']) && $smtp['security'] == "tls" ? "checked" : "";?>>
									TLS
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-3">
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