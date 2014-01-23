<div class="container main-content">
	<div class="form-signin">
		<h3 class="short_headline text-center"><span>Réinitialisation du mot de passe</span></h3>
		<hr class="empty">
		<p class="text-center">Veuillez choisir un nouveau mot de passe</p>
		<?php
		echo isset($erreurs) ? $erreurs : "";
		?>
		<form method="post">
			<fieldset>
				<input type="password" class="input-block-level" name="pass1" placeholder="Nouveau mot de passe" <?php echo $disabled;?> required>
				<input type="password" class="input-block-level" name="pass2" placeholder="********" <?php echo $disabled;?> required>
				<button class="btn custom-btn btn-primary btn-large" name="pass" type="submit"><i class="fa fa-lock"></i>&nbsp; Valider</button>
			</fieldset>
		</form>
		<hr class="empty">
	</div>
	<p class="text-center">
		<a href="/connexion/mot-de-passe-perdu">Mot de passe oublié ?</a> / Vous n'avez pas encore de compte ? <a href="/inscription">Inscrivez-vous</a>
	</p>
</div>