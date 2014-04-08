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
				<button type="submit" name="modifier"class="btn btn-success">
					<i class="fa fa-edit fa-fw"></i> Modifier
				</button>
				<button type="submit" name="annuler" class="btn btn-default">
					<i class="fa fa-reply fa-fw"></i> annuler
				</button>
			</div>
			<div class="form-group">
				<label for="nom" class="col-sm-3 control-label">Nom établissement</label>
				<div class="col-sm-4">
					<input type="text" id="nom" name="nom" class="form-control" placeholder="Ecole ..." value="<?php echo $config->get('conf_nom');?>" autofocus>
					<?php
					if(isset($erreur) && in_array('nom', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="description" class="col-sm-3 control-label">Description</label>
				<div class="col-sm-4">
					<textarea id="description" name="description" class="form-control"><?php echo $config->get('conf_description');?></textarea>
					<?php
					if(isset($erreur) && in_array('description', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-3 control-label">Email myLearn</label>
				<div class="col-sm-4">
					<input type="text" id="email" name="email" class="form-control" placeholder="Mail d'envoi de myLearn" value="<?php echo $config->get('conf_email');?>">
					<?php
					if(isset($erreur) && in_array('email', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="contact" class="col-sm-3 control-label">Email de contact</label>
				<div class="col-sm-4">
					<input type="text" id="contact" name="contact" class="form-control" placeholder="Mail de contact de l'école" value="<?php echo $config->get('conf_contact');?>">
					<?php
					if(isset($erreur) && in_array('contact', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
		</form>
	</div>
</div>