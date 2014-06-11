<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li><a href="/professeur/mes-cours">Mes cours</a></li>
			<li class="active">Ecrire un cours</li>
		</ol>
	</div>
</div>
<form method="post" class="form-horizontal" role="ajout">
		<div class="row">
			<div class="col-md-3">
				<div class="bs-sidebar hidden-print affix-top" role="complementary" style="" data-spy="affix" data-offset-top="130">
					<ul class="nav bs-sidenav">
						<li>
							<div class="text-center">
								<h2>Actions</h2>
								<hr>
								<ul class="list-inline">
									<li>
										<button type="submit" name="ajouter" class="btn btn-large btn-success">Enregistrer</button>
									</li>
									<li>
										<button type="submit" name="annuler" class="btn btn-large btn-default">Annuler</button>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<section id="titre">
					<div class="page-header">
						<h3>Titre, description et contenu</h3>
					</div>
					<div class="form-group">
						<label for="titre" class="col-sm-2 control-label">Titre</label>
						<div class="col-sm-10">
							<input type="text" id="titre" name="titre" class="form-control" placeholder="Titre du chapitre" value="<?php echo isset($cours['titre']) ? $cours['titre'] : "";?>"/>
							<?php
							if (isset($erreurs) && in_array(\Library\Entities\Cours::TITRE_INVALIDE, $erreurs))
								{
									echo '<span class="help-block">Le titre ne peut être vide.</span>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="matiere" class="col-sm-2 control-label">Classe</label>
						<div class="col-sm-10">
							<select name="classe" id="classe" class="form-control">
								<?php
								if(isset($classes) && is_array($classes)) {
									foreach ($classes as $classe) {
										$classe = unserialize(base64_decode($classe));
										$selected = isset($cours['classe']) && $cours['classe']->id() == $classe->id() ? "selected" : "";
										echo "<option value='".base64_encode(serialize($classe))."' >".$classe->libelle()."</option>";
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea rows="4" id="description" name="description" class="form-control" placeholder="Description du cours"><?php echo isset($cours['description']) ? $cours['description'] : "";?></textarea>
							<?php
							if (isset($erreurs) && in_array(\Library\Entities\Cours::DESCRIPTION_INVALIDE, $erreurs))
								{
									echo '<span class="help-block">La description ne peut être vide.</span>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="contenu" class="col-sm-2 control-label">Contenu</label>
						<div class="col-sm-10">
							<textarea rows="20" id="contenu" name="contenu" class="form-control"><?php echo isset($cours['contenu']) ? $cours->contenu() : "";?></textarea>
							<?php
							if (isset($erreurs) && in_array(\Library\Entities\Cours::CONTENU_INVALIDE, $erreurs))
								{
									echo '<span class="help-block">Le contenu ne peut être vide.</span>';
								}
							?>
						</div>
					</div>
				</section>
			</div>
		</div>
	</form>