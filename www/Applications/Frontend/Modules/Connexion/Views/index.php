<div id="wrap">
	<div class="container">
		<div>
		</div>
		<form class="form-signin" role="form" method="post">
			<h2 class="form-signin-heading text-info text-center">Identifiez-vous</h2>
			<?php
			echo isset($erreurs) ? $erreurs : "";
			?>
			<input type="text" class="form-control" placeholder="Utilisateur" name="login" required autofocus>
			<input type="password" class="form-control" placeholder="Password" name="password" required>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
		</form>
		<p class="text-center text-info">
			<a href="http://ppe">Aller sur le site</a>
		</p>
	</div> <!-- /container -->
</div>
<div id="footer">
	<div class="container">
		<p class="text-muted">© 2014 . myLearn</p>
	</div>
</div>