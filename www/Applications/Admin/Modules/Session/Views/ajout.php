<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/sessions">Liste des sessions</a></li>
			<li class="active">Nouvelle session</li>
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
					<!-- Session -->
					<div class="form-group">
						<label class="col-lg-3 control-label" for="session">Session</label>
						<div class="col-lg-9">
							<div class="row">
								<div class="col-lg-8">
									<input type="text" id="session" name="session" class="form-control" value="<?php echo (isset($session) ? $session['session'] :  "");?>">
									<?php
									if (isset($erreurs) && in_array(\Library\Entities\Session::SESS_INVALIDE, $erreurs))
									{
										echo '<span class="help-block erreur">Ne peut être vide, doit être au format AAAA/AAAA</span>';
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