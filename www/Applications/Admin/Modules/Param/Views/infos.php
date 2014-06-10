<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/admin">Accueil</a></li>
			<li><a href="/admin/parametres">Paramètres</a></li>
			<li class="active">Modifier informations</li>
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
			<div class="form-group">
				<label for="address" class="col-sm-3 control-label">Adresse</label>
				<div class="col-sm-4">
					<input type="text" id="address" name="address" class="form-control" placeholder="10 rue de l'Université" value="<?php echo $config->get('conf_address');?>">
					<?php
					if(isset($erreur) && in_array('address', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="ville" class="col-sm-3 control-label">Ville</label>
				<div class="col-sm-4">
					<input type="text" id="ville" name="ville" class="form-control" placeholder="Paris" value="<?php echo $config->get('conf_ville');?>">
					<?php
					if(isset($erreur) && in_array('ville', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="cp" class="col-sm-3 control-label">Code postal</label>
				<div class="col-sm-4">
					<input type="text" id="cp" name="cp" class="form-control" placeholder="75 001" value="<?php echo $config->get('conf_cp');?>">
					<?php
					if(isset($erreur) && in_array('cp', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
			<div class="form-group">
				<label for="tel" class="col-sm-3 control-label">Téléphone</label>
				<div class="col-sm-4">
					<input type="text" id="tel" name="tel" class="form-control" placeholder="01 02 03 04 05" value="<?php echo $config->get('conf_tel');?>">
					<?php
					if(isset($erreur) && in_array('tel', $erreur)) {
						echo "<span class='help-block'></span>";
					}
					?>
				</div>
			</div>
		</form>
	</div>
</div>