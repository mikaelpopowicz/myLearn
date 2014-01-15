<div class="page-header">
	<h1>Modifier mon mot de passe</h1>
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
				Mofifier mon mot de passe
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
					<label class="control-label" for="pass1">Mot de passe</label>
					<div class="controls">
						<input type="password" id="pass1" name="pass1" placeholder="********" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="pass2">Confirmation</label>
					<div class="controls">
						<input type="password" id="pass2" name="pass2" placeholder="********" required>
						<?php
						if (isset($erreurs))
						{
							echo '<span class="help-inline">Les mots de passe ne sont pas identiques</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" name="modifier">Enregistrer</button>
						<a  href="/membre/mon-profil" class="btn btn-default">Annuler</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>