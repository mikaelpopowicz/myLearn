<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/sections">Liste des sections</a></li>
			<li class="active">Modifier <?php echo $section['libelle'];?></li>
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
									<input type="text" id="libelle" name="libelle" class="form-control" value="<?php echo (isset($section) ? $section['libelle'] :  "");?>">
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
			</div>
		</form>
	</div>
</div>