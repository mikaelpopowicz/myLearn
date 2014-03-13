<div class="page-header">
	<h1>Modifier un cours</h1>
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
				<a href="/cours" class="primary-color">Cours</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				Modifier un cours
			</li>
		</ul>
	</div>
</div>
<div class="container main-content">
	<form method="post" class="form-horizontal">
		<div class="row-fluid sidebar-left">
			<div class="span9 primary-column">
				<div class="page-header">
					<h1>Titre, matière, description et contenu</h1>
				</div>
				<div class="control-group">
					<label class="control-label" for="titre">Titre</label>
					<div class="controls">
							<input type="text" class="input-block-level" id="titre" name="titre" placeholder="Titre du chapitre" value="<?php echo isset($cours['titre']) ? $cours['titre'] : "";?>">
							<?php
							if (isset($erreurs) && in_array(\Library\Entities\Cours::TITRE_INVALIDE, $erreurs))
								{
									echo '<span class="help-inline">Le titre ne peut être vide.</span>';
								}
							?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="matiere">Matière</label>
					<div class="controls">
						<select name="matiere" id="matiere" class="input-block-level">
							<?php
							if(isset($matieres) && is_array($matieres)) {
								foreach ($matieres as $matiere) {
									$seleted = isset($cours['matiere']) && $cours['matiere'] == $matiere['id'] ? "selected" : "";
									echo "<option value='".$matiere['id']."' ".$seleted.">".$matiere['libelle']."</option>";
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="description">Description</label>
					<div class="controls">
							<textarea rows="4"class="input-block-level" id="description" name="description" placeholder="Description du chapitre"><?php echo isset($cours['description']) ? $cours['description'] : "";?></textarea>
							<?php
							if (isset($erreurs) && in_array(\Library\Entities\Cours::DESCRIPTION_INVALIDE, $erreurs))
								{
									echo '<span class="help-inline">La description ne peut être vide.</span>';
								}
							?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="contenu">Contenu</label>
					<div class="controls">
							<textarea rows="20"class="input-block-level" id="contenu" name="contenu" placeholder="Contenu du chapitre"><?php echo isset($cours['contenu']) ? $cours['contenu'] : "";?></textarea>
							<?php
							if (isset($erreurs) && in_array(\Library\Entities\Cours::CONTENU_INVALIDE, $erreurs))
								{
									echo '<span class="help-inline">Le contenu ne peut être vide.</span>';
								}
							?>
					</div>
				</div>
			</div>
			<!-- close span9 primary-column -->

			<section class="span3 sidebar secondary-column affix-top" data-spy="affix">
				<aside class="widget">
					<div class="row-fluid"
						<div class="span12">
							<div class="text-center">
								<h2>Actions</h2>
								<ul class="inline">
									<li>
										<button type="submit" name="modifier" class="btn btn-primary">Enregistrer</button>
									</li>
									<li>
										<button type="submit" name="annuler" class="btn btn-default">Annuler</button>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</aside>

			<!--close aside .widget-->
			</section>
		</div>
		<!--close row-fluid-->
	</form>
</div>