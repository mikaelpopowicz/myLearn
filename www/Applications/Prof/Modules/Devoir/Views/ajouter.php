<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li><a href="/professeur/devoirs">Devoirs</a></li>
			<li class="active">Nouveau devoir</li>
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
					<h3>Libelle, énoncé et date maximum</h3>
				</div>
				<div class="form-group">
					<label for="libelle" class="col-sm-2 control-label">Libellé</label>
					<div class="col-sm-10">
						<input type="text" id="libelle" name="libelle" class="form-control" placeholder="Titre du devoir" value="<?php echo isset($devoir['libelle']) ? $devoir->libelle() : "";?>"/>
						<?php
						if (isset($erreurs) && in_array(\Library\Entities\Devoir::LIBELLE_INVALIDE, $erreurs))
							{
								echo '<span class="help-block">Le libellé ne peut être vide.</span>';
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
									$selected = isset($devoir['classe']) && $devoir['classe']->id() == $classe->id() ? "selected" : "";
									echo "<option value='".base64_encode(serialize($classe))."' >".$classe->libelle()."</option>";
								}
							}
							?>
						</select>
					</div>
				</div>
				<!-- Date maximum -->
				<div class="form-group">
					<label class="col-sm-2 control-label" for="datepicker">Date maximum</label>
					<div class="col-sm-10">
						<div class="input-group date">
							<input type="text" id="datepicker" name="date" class="form-control" value="<?php echo (isset($devoir['dateMax']) ? $devoir->dateMax()->format('d/m/Y') :  "");?>" readonly="" required="">
							<span class="input-group-addon"><i class="fa fa-th"></i></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="contenu" class="col-sm-2 control-label">Enoncé</label>
					<div class="col-sm-10">
						<textarea rows="15" id="contenu" name="enonce" class="form-control"><?php echo isset($devoir['contenu']) ? $devoir->contenu() : "";?></textarea>
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