<div class="container main-content">
	<div class="form-signin">
		<h3 class="short_headline text-center"><span>Mot de passe perdu</span></h3>
		<hr class="empty">
		<p class="text-center">Adresse email à laquelle envoyer le lien de réinitialisation du mot de passe</p>
		<?php
		echo isset($erreurs) ? $erreurs : "";
		?>
		<form method="post">
			<fieldset>
				<input type="email" class="input-block-level" name="email" placeholder="Email">
				<button class="btn custom-btn btn-primary btn-large" name="send" type="submit"><i class="fa fa-lock"></i>&nbsp; Envoyer</button>
			</fieldset>
		</form>
		<hr class="empty">
	</div>
	<p class="text-center">
		<a href="/connexion/mot-de-passe-perdu">Mot de passe oublié ?</a> / Vous n'avez pas encore de compte ? <a href="/inscription">Inscrivez-vous</a>
	</p>
</div>