<div class="jumbotron">
	<div class="container">
		<h1>Bienvenue sur <span class="text-info">myLearn</span></h1>
		<p>Une plateforme éducative, pensée par des élèves pour des élèves. N'hésitez pas à nous soumettre vos demandes sur la plateforme sur notre site.</p>
		<p>
			<a href="http://mylearn.cpm-web.fr"class="btn btn-primary" role="button">En savoir plus »</a>
		</p>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-6 text-center">
			<br><br>
			<h3>Connexion à la plateforme de cours en ligne</h3>
			<h3 class="text-primary"><?php echo isset($nom) ? $nom : "";?></h3>
			<p><?php echo isset($desc) ? $desc : "";?></p>
		</div>
		<div class="col-md-6">
			<div class="well">
				<?php
				if(isset($erreurs) && is_array($erreurs)) {
					echo '<div class="alert alert-'.$erreurs[0].'">';
					echo $erreurs[1];
					echo '</div>';
				} else {
				?>
				<div class="alert alert-info">
					<span class="text-center">Connectez-vous à l'aide de votre login et mot de passe</span>
				</div>	
				<?php
				}
				?>
				<form class="form-signin" role="form" method="post">
					<input type="text" class="form-control" placeholder="Utilisateur" name="login" required autofocus>
					<input type="password" class="form-control" placeholder="Password" name="password" required>
					<button class="btn btn-lg btn-primary btn-block" name="go" type="submit">Connexion</button>
				</form>
				<p class="text-center">
					<a href="/connexion/mot-de-passe-perdu">Mot de passe oublié ?</a>
				</p>
			</div>
		</div>
	</div>
	
	<footer class="footer">
		<p class="text-muted">© 2014 . myLearn</p>
	</footer>
</div> <!-- /container -->
