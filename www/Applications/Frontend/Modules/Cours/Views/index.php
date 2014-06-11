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
				<a class="innershadows" href="/mon-compte">
					<img class="banner-img" src="/images/compte.png">					
				</a>
				<div class="content">
					<h4 class="text-center primary-color">Mon compte</h4>
					<p>
						Gérez votre profil à tous moments. Vos données personnelles et votre mot de passe.
					</p>
				</div>
			</div>
			<div class="span4">
				<a class="innershadows" href="/contact">
					<img class="banner-img" src="/images/contact.png">					
				</a>
				<div class="content">
					<h4 class="text-center primary-color">Restez connectés</h4>
					<p>
						Retrouvez tous les contacts utiles, vos professeurs et l'école.
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
