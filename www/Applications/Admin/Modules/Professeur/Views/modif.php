<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/professeurs">Liste des professeurs</a></li>
			<li class="active">Modifier <?php echo $professeur['nom']?></li>
		</ol>
	</div>
</div>
<?php
//echo '<pre>';print_r($professeur);echo '</pre>';
?>
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
					<!-- Username -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="username">Username</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<input type="text" id="username" name="username" class="form-control" value="<?php echo (isset($professeur) ? $professeur->username() :  "");?>" readonly>
								</div>
							</div>
						</div>
					</div>
					<!-- Nom -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="nom">Nom</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<input type="text" id="nom" name="nom" class="form-control" value="<?php echo (isset($professeur) ? $professeur['nom'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Professeur::NOM_INVALIDE, $erreurs))
									{
										echo '<span class="help-block erreur">Ne peut être vide</span>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- Prénom -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="prenom">Prénom</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo (isset($professeur) ? $professeur['prenom'] :  "");?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<!-- Email -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="email">Email</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<input type="text" id="email" name="email" class="form-control" value="<?php echo (isset($professeur) ? $professeur['email'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Professeur::EMAIL_INVALIDE, $erreurs))
									{
										echo '<span class="help-block erreur">Invalide</span>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- Matière -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="matiere">Matière</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<select id="matiere" name="matiere" class="form-control selectpicker">
										<?php
										foreach ($listeMatiere as $matiere) {
											$selected = isset($professeur) && $professeur->matiere()->id() == $matiere->id() ? "selected" : "";
											echo '<option value="'.base64_encode(serialize($matiere)).'" '.$selected.'>'.$matiere->libelle().'</option>';
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