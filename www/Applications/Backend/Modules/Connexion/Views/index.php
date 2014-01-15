<div class="container">
	<form class="form-signin" role="form" method="post">
		<h2 class="form-signin-heading text-info text-center">Administration</h2>
		<?php
		echo isset($erreurs) ? $erreurs : "";
		?>
		<input type="text" class="form-control" placeholder="Utilisateur" name="login" required autofocus>
		<input type="password" class="form-control" placeholder="Password" name="password" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
	</form>

	<p class="text-center text-info">
		<a href="http://poo">Aller sur le site</a>
	</p>

</div> <!-- /container -->