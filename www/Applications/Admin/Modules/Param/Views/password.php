<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/parametres">Paramètres</a></li>
			<li class="active">Modifier mot de passe</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<form role="check" class="form-horizontal" method="post">
			<div class="well">
				<button type="submit" name="modifier"class="btn btn-primary">
					<i class="fa fa-edit fa-fw"></i> Modifier
				</button>
				<a href="/admin/parametres"class="btn btn-default">
					<i class="fa fa-reply fa-fw"></i> annuler
				</a>
			</div>
			<div class="form-group">
				<label for="pass1" class="col-sm-3 control-label">Mot de passe</label>
				<div class="col-sm-4">
					<input type="password" id="pass1" name="pass1" class="form-control" placeholder="******" autofocus required>
				</div>
			</div>
			<div class="form-group">
				<label for="pass2" class="col-sm-3 control-label">Confirmation</label>
				<div class="col-sm-4">
					<input type="password" id="pass2" name="pass2" class="form-control" placeholder="******" required>
					<?php
					if(isset($erreurs)) {
						echo "<span class='help-block'>".$erreurs[0]."</span>";
					}
					?>
				</div>
			</div>
		</form>
	</div>
</div>