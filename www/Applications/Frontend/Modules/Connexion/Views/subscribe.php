<div class="container main-content">
	<div class="form-register">
		<h3 class="short_headline text-center"><span>S'inscrire</span></h3>

		<hr class="empty">
		<form class="form-horizontal" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="email" >Email <span class="text-error">*</span></label>
					<div class="controls">
						<input type="text" id="email" name="email" placeholder="john.doe@domain.tld" value="<?php echo isset($byte) ? $byte['email'] : "";?>" required>
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Byte::EMAIL_INVALIDE, $erreurs))
						{
							echo '<span class="help-inline">L\'email est invalide ou déja utilisé</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="username" >Pseudo <span class="text-error">*</span></label>
					<div class="controls">
						<input type="text" id="username" name="username" placeholder="jony75" value="<?php echo isset($byte) ? $byte['username'] : "";?>" required>
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Byte::USER_INVALIDE, $erreurs))
						{
							echo '<span class="help-inline">Le pseudo est déjà utilisé</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nom" >Nom <span class="text-error">*</span></label>
					<div class="controls">
						<input type="text" id="nom" name="nom" placeholder="Doe" value="<?php echo isset($byte) ? $byte['nom'] : "";?>" required>
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Byte::NOM_INVALIDE, $erreurs))
						{
							echo '<span class="help-inline">Le nom ne peut être vide</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="pass1" >Mot de passe <span class="text-error">*</span></label>
					<div class="controls">
						<input type="password" id="pass1" name="pass1" placeholder="********" value="<?php echo isset($byte) ? $byte['password'] : "";?>"required />
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Byte::PASS_INVALIDE, $erreurs))
						{
							echo '<span class="help-inline">Les mots de passe sont diférents</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="pass2" >Confirmation <span class="text-error">*</span></label>
					<div class="controls">
						<input type="password" id="pass2" name="pass2" placeholder="********" value="<?php echo isset($byte) ? $byte['password'] : "";?>" required />
					</div>
				</div>
				<button class="btn custom-btn btn-primary btn-large" name="go" type="submit">Envoyer</button>
			</fieldset>
		</form>
	</div>
	<p class="text-center">Déjà inscrit ? <a href="/connexion">Connexion</a></p>
	<?php
	if(isset($byte)) {
		echo "<pre>";print_r($byte);echo '<br>Valide :';var_dump($byte->isValid());echo "</pre>";
	}
	?>
</div>