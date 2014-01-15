<div class="page-header">
	<h1>Ma Configuation</h1>
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
				Ma configuration
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
				
			</div>
		</div>
	</div>
</div>