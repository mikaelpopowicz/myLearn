<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/classes">Liste des classes</a></li>
			<li class="active">Nouvelle classe</li>
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
					<!-- Libelle -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="libelle">Libellé</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<input type="text" id="libelle" name="libelle" class="form-control" value="<?php echo (isset($classe) ? $classe['libelle'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Classe::LIBELLE_INVALIDE, $erreurs))
									{
										echo '<span class="help-block erreur">Ne peut être vide</span>';
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<!-- Session -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="session">Session</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<select id="session" name="session" class="form-control selectpicker" data-live-search="true">
										<?php
										foreach ($sessions as $session) {
											$selected = isset($classe) && $classe->session() == $session['id'] ? "selected" : "";
											echo '<option value="'.$session['id'].'" '.$selected.'>'.$session->session().'</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<!-- Section -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="section">Section</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<select id="section" name="section" class="form-control selectpicker" data-live-search="true">
										<?php
										foreach ($sections as $section) {
											$selected = isset($classe) && $classe->section() == $section['id'] ? "selected" : "";
											echo '<option value="'.$section['id'].'" '.$selected.'>'.$section->libelle().'</option>';
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