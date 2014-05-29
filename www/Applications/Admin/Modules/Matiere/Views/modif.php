<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/matieres">Liste des matières</a></li>
			<li class="active">Modifier <?php echo isset($matiere) ? $matiere['libelle'] : ""?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<form method="post" class="form-horizontal">
			<div class="well">
				<button type="submit" name="modifier"class="btn btn-primary">
					Modifier
				</button>
				<button type="submit" name="annuler" class="btn btn-default">
					<i class="fa fa-reply fa-fw"></i> annuler
				</button>
			</div>
			
			<div class="row">
				<div class="col-lg-6">
					<!-- Libelle -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="libelle">Libelle</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<input type="text" id="libelle" name="libelle" class="form-control" value="<?php echo (isset($matiere) ? $matiere['libelle'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Matiere::LIBELLE_INVALIDE, $erreurs))
									{
										echo '<span class="help-block erreur">Ne peut être vide</span>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<!-- Pièce -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="icon">Icône</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<select id="icon" name="icon" class="form-control selectpicker">
										<?php
										foreach ($fas as $fa) {
											$selected = isset($matiere) && $matiere['icon'] == $fa ? "selected" : "";
											echo '<option value="fa '.$fa.'" '.$selected.' data-icon="fa '.$fa.'"></option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>