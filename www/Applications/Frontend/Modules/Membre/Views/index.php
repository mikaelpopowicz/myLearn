<div class="page-header">
	<h1>Mon profil</h1>
</div>
<div class="strip primary">
	<div class="container">
		<ul class="inline">
			<li>
				<a href="/" class="primary-color">Accueil</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				Mon profil
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="row-fluid">
			<div class="span3">
				<ul class="nav nav-pills nav-stacked">
					<li class="<?php echo isset($class_profil) ? $class_profil : "";?>">
						<a href="/membre/mon-profil">Mes informations</a>
					</li>
					<li class="<?php echo isset($class_mes_cours) ? $class_mes_cours : "";?>">
						<a href="/membre/mes-cours">Mes cours</a>
					</li>
					<li class="<?php echo isset($class_config) ? $class_config : "";?>">
						<a href="/membre/ma-configuration">Configuration</a>
					</li>
				</ul>
			</div>
			<div class="span9">
				<table class="responsive">
					<thead>
						<tr>
							<th colspan="2">
								Mes informations
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Username</td>
							<td><?php echo $profil['username']; ?></td>
						</tr>
						<tr>
							<td>Nom</td>
							<td><?php echo $profil['nom']; ?></td>
						</tr>
						<tr>
							<td>Prénom</td>
							<td><?php echo $profil['prenom']; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $profil['email']; ?></td>
						</tr>
						<tr>
							<td>Actif</td>
							<td><?php echo $profil['active'] == 1 ? "Oui" : "Non"; ?></td>
						</tr>
						<tr>
							<td>Date d'inscription</td>
							<td><?php echo $profil['dateByte']->format('d/m/Y'); ?></td>
						</tr>
					</tbody>
				</table>
				<form class="form-inline" method="post">
					<button type="submit" class="btn btn-primary" name="modifier_profil">Modifier mon profil</button>
					<button type="submit" class="btn btn-info" name="modifier_pass">Modifier mon mot de passe</button>
				</form>
			</div>
		</div>
	</div>
</div>