<div class="page-header">
	<h1>Mon compte</h1>
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
				Mes informations
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
						<a href="/mon-compte">Mes informations</a>
					</li>
					<li class="<?php echo isset($class_mes_cours) ? $class_mes_cours : "";?>">
						<a href="/mon-compte/mes-cours">Mes cours</a>
					</li>
					<li class="<?php echo isset($class_config) ? $class_config : "";?>">
						<a href="/mon-compte/configuration">Configuration</a>
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
							<td><?php echo $user->getAttribute('username'); ?></td>
						</tr>
						<tr>
							<td>Nom</td>
							<td><?php echo $user->getAttribute('nom'); ?></td>
						</tr>
						<tr>
							<td>Prénom</td>
							<td><?php echo $user->getAttribute('prenom'); ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $user->getAttribute('email'); ?></td>
						</tr>
						<tr>
							<td>Date de naissance</td>
							<td><?php echo $naissance; ?></td>
						</tr>
					</tbody>
				</table>
				<form class="form-inline" method="post">
					<a class="btn btn-primary" href="/mon-compte/modifier-mes-informations">Modifier mon profil</a>
					<a class="btn btn-info" href="/mon-compte/modifier-mot-de-passe">Modifier mon mot de passe</a>
				</form>
			</div>
		</div>
	</div>
</div>