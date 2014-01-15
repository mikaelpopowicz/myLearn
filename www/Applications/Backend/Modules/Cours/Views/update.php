<div id="modifier-cours">
	<div class="page-header">
		<h1>Modifier un cours</h1>
	</div>
	<form method="post" class="form-horizontal" role="modifier">
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
										<button type="submit" name="modifier" class="btn btn-large btn-primary">Enregistrer</button>
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
				<section id="infos">
					<div class="page-header">
						<h3>Informations</h3>
					</div>
					<div class="row">
						<div class="col-md-4">
							<span class="text-info">Auteur</span> : <?php echo $cours['auteur'];?>
						</div>
						<div class="col-md-4">
							<span class="text-info">Commentaire(s)</span> : <?php echo $comments;?>
						</div>
						<div class="col-md-4">
							<span class="text-info">Nombre de vue</span> : <?php echo $manC->getCount($cours['id'])['count_c'];?>
						</div>
					</div>
				</section>
				<section id="titre">
					<div class="page-header">
						<h3>Titre, description et contenu</h3>
					</div>
					<div class="form-group">
						<label for="titre" class="col-sm-2 control-label">Titre</label>
						<div class="col-sm-10">
							<input type="text" id="titre" name="titre" class="form-control" value="<?php echo $cours['titre'];?>" />
							<?php
							if (isset($erreurs) && in_array(\Library\Entities\Cours::TITRE_INVALIDE, $erreurs))
								{
									echo '<span class="help-block">Le titre ne peut être vide.</span>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="matiere" class="col-sm-2 control-label">Matière</label>
						<div class="col-sm-10">
							<select name="matiere" id="matiere" class="form-control">
								<?php
								if(isset($matieres) && is_array($matieres)) {
									foreach ($matieres as $matiere) {
										$selected = $matiere['id'] == $cours['matiere'] ? "selected" : "";
										echo "<option value='".$matiere['id']."' ".$selected.">".$matiere['libelle']."</option>";
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea rows="4" id="description" name="description" class="form-control"><?php echo $cours['description'];?></textarea>
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
							<textarea rows="20" id="contenu" name="contenu" class="form-control"><?php echo $cours['contenu'];?></textarea>
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
	<pre>
		<?php
		if(isset($cours)) {
			print_r($cours);
		}
		?>
	</pre>
</div>