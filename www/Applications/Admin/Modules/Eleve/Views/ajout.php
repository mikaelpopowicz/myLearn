<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/eleves">Liste des élèves</a></li>
			<li class="active">Nouvel élève</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<form method="post" class="form-horizontal">
			<div class="well">
				<button type="submit" name="ajouter"class="btn btn-success">
					<i class="fa fa-plus-square-o fa-fw"></i> Ajouter
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
									<input type="text" id="username" name="username" class="form-control" value="<?php echo (isset($eleve) ? $eleve['username'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Eleve::USER_INVALIDE, $erreurs))
									{
										echo '<span class="help-block erreur">Ne peut être vide</span>';
									}
									?>
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
									<input type="text" id="nom" name="nom" class="form-control" value="<?php echo (isset($eleve) ? $eleve['nom'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Eleve::NOM_INVALIDE, $erreurs))
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
									<input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo (isset($eleve) ? $eleve['prenom'] :  "");?>">
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
									<input type="text" id="email" name="email" class="form-control" value="<?php echo (isset($eleve) ? $eleve['email'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Eleve::EMAIL_INVALIDE, $erreurs))
									{
										echo '<span class="help-block erreur">Invalide</span>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- Date de naissance -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="datepicker">Date de naissance</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<div class="input-group date">
										<input type="text" id="datepicker" name="date" class="form-control" value="<?php echo (isset($eleve) ? $eleve['dateNaissance']->format('d/m/Y') :  "");?>" readonly="" required="">
										<span class="input-group-addon"><i class="fa fa-th"></i></span>
										<?php
										if (isset($erreurs) && in_array(\Library\Entities\Eleve::DATE_INVALIDE, $erreurs))
										{
											echo '<span class="help-block erreur">Invalide</span>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</form>
	</div>
</div>