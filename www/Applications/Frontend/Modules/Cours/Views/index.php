<div class="container">
	<div class="hero-unit text-center">
		<div class="headline">
			<h1 class="primary-color">Bienvenue sur MyLearn</h1>
		</div>
		<div class="content">
			<p>
				Cette plateforme vous est mise à disposition par <?php 
				echo $config->get('conf_nom')
					?>
			</p>
		</div>
	</div>
</div>
<div class="main-content">
	<div class="strip primary-color-bg odd">
		<div class="container">
			<div class="hero-unit text-center">
				<div class="headline">
					<h1 class="white-text">Retrouver les cours de <?php 
						echo unserialize(base64_decode($user->getAttribute('classes')[0]))->libelle()
							?>
					</h1>
				</div>
				<div class="content">
					<p class="white-text">Partagez, récupérez, commenter ! Tous y est.</p>
					<p><a href="/cours/" class="btn btn-large btn-white custom-btn">Commencer</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row-fluid equal equal-style">
			<div class="span4">
				<a class="innershadows" href="/cours">
					<img class="banner-img" src="/images/learn.jpg">					
				</a>
				<div class="content">
					<h3 class="primary-color">Vos cours</h3>
					<p>
						Ecrivez-vos cours ici, et retrouver n'importe quand. Idéal pour les révisions.
					</p>
				</div>
			</div>
			<div class="span4">
				<a class="innershadows btn btn-block btn-primary" href="/cours/sisr"><h2><i class="fa fa-terminal"></i> SISR</h2></a>
				<div class="content">
					<h4 class="text-center primary-color">Le réseau</h4>
					<p>
						Retrouvez les cours et exercices du programme SISR, réseau, routage, etc.
					</p>
				</div>
			</div>
			<div class="span4">
				<a class="innershadows btn btn-block btn-primary" href="/tutos"><h2><i class="e-icon-share"></i> Tutos & contributions</h2></a>
				<div class="content">
					<h4 class="text-center primary-color">Les tutos et les cours</h4>
					<p>
						Retrouvez les cours de toutes les matières, et aussi des tutos divers.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
