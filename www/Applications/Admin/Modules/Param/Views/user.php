<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/parametres">Paramètres</a></li>
			<li class="active">Modifier connexion</li>
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
				<button type="submit" name="annuler" class="btn btn-default">
					<i class="fa fa-reply fa-fw"></i> annuler
				</button>
			</div>
			<div class="form-group">
				<label for="nom" class="col-sm-3 control-label">Username</label>
				<div class="col-sm-4">
					<input type="text" id="nom" name="username" class="form-control" placeholder="Ecole ..." value="<?php echo $profil->username();?>" autofocus>
					<?php
					if(isset($erreurs) && in_array(\Library\Entities\User::USER_INVALIDE, $erreurs)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-4">
					<input type="text" id="email" name="email" class="form-control" placeholder="Mail d'envoi de myLearn" value="<?php echo $profil->email();?>">
					<?php
					if(isset($erreurs) && in_array(\Library\Entities\User::EMAIL_INVALIDE, $erreurs)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
		</form>
	</div>
</div>