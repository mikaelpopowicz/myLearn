<div class="page-header">
	<h1>Modifier mon profil</h1>
</div>
<div class="strip primary">
	<div class="container">
		<ul class="inline">
			<li>
				<a href="/" class="primary-color">Accueil</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<a href="/membre/mon-profil">Mon profil</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				Mofifier mon profil
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
	<div class="row-fluid">
		<div class="span3">
			<ul class="nav nav-pills nav-stacked">
				<li class="<?php echo isset($class_profil) ? $class_profil : "";?>">
					<a href="/membre/mon-profil">Mes informations</a>
				</li>
				<li class="<?php echo isset($class_mes_cours) ? $class_mes_cours : "";?>">
					<a href="/membre/mes-cours">Mes cours</a>
				</li>
				<li class="<?php echo isset($class_config) ? $class_config : "";?>">
					<a href="/membre/ma-configuration">Configuration</a>
				</li>
			</ul>
		</div>
		<div class="span9">
			<form class="form-horizontal" method="post">
				<div class="control-group">
					<label class="control-label" for="username">Username</label>
					<div class="controls">
						<input type="text" id="username" name="username" placeholder="Votre nom d'utilisateur" value="<?php echo isset($profil['username']) ? $profil['username'] : "";?>">
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Byte::USER_INVALIDE, $erreurs))
						{
							echo '<span class="help-inline">Le pseudo est déjà utilisé</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nom">Nom</label>
					<div class="controls">
						<input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?php echo isset($profil['nom']) ? $profil['nom'] : "";?>">
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Byte::NOM_INVALIDE, $erreurs))
						{
							echo '<span class="help-inline">Le nom ne peut être vide</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="prenom">Prénom</label>
					<div class="controls">
						<input type="text" id="prenom" name="prenom" placeholder="Votre prénom" value="<?php echo isset($profil['prenom']) ? $profil['prenom'] : "";?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email">Email</label>
					<div class="controls">
						<input type="text" id="email" name="email" placeholder="Votre adresse email" value="<?php echo isset($profil['email']) ? $profil['email'] : "";?>">
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Byte::EMAIL_INVALIDE, $erreurs))
						{
							echo '<span class="help-inline">L\'email est invalide ou déja utilisé</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" name="modifier">Enregistrer</button>
						<button class="btn btn-default" name="annuler">Annuler</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>