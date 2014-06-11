<div class="page-header">
	<h1>Devoirs</h1>
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
				<a href="/devoirs" class="primary-color">Devoirs</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				Rendre un devoir
			</li>
		</ul>
	</div>
</div><div class="main-content">
	<div class="container">
	<div class="row-fluid">
		<div class="span9">
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label" for="fichier">Fichier</label>
					<div class="controls">
						<input type="file" id="fichier" name="fichier">
						<?php
						if (isset($erreurs))
						{
							echo '<span class="help-inline">Problème d\'upload</span>';
						}
						?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" name="upload">Enregistrer</button>
						<button class="btn btn-default" name="annuler">Annuler</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>