<div class="container">
	<div class="hero-unit text-center">
		<div class="headline">
			<h1 class="primary-color">Un monde de partage</h1>
		</div>
		<div class="content">
			<p>
				Pour avoir il faut donner. N'hésitez pas à partager vos connaissances, les travaux que vous effectuez en cours.
			</p>
		</div>
	</div>
</div>
<div class="main-content">
	<div class="strip primary-color-bg odd">
		<div class="container">
			<div class="hero-unit text-center">
				<div class="headline">
					<h1 class="white-text">Retrouver les cours de BTS SIO</h1>
				</div>
				<div class="content">
					<p class="white-text">Partagez, récupérez, commenter ! Tous y est.</p>
					<p><a href="/cours" class="btn btn-large btn-white custom-btn">Commencer</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row-fluid equal equal-style">
			<div class="span4">
				<a class="innershadows btn btn-block btn-primary" href="/cours/slam"><h2><i class="fa fa-code"></i> SLAM</h2></a>
				<div class="content">
					<h4 class="text-center primary-color">La programmation</h4>
					<p>
						Retrouvez les cours et exercices de programmation, d'analyse et de base de données
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
		<p>Hashage du mot de passe admin</p>
		<pre>
			$salt = "AZszBS8273dxz";
			$mdp = "mdp";
			echo sha1(md5(sha1(md5($salt)).sha1(md5($mdp)).sha1(md5($salt))));
			RESULTAT :
			<?php
				$salt = "AZszBS8273dxz";
				$mdp = "irisbde75";
				echo sha1(md5(sha1(md5($salt)).sha1(md5($mdp)).sha1(md5($salt))));
			?>
			
			Test :
			echo (md5(sha1(md5($salt)).sha1(md5($mdp)).sha1(md5($salt))));
			<?php
				echo (md5(sha1(md5($salt)).sha1(md5($mdp)).sha1(md5($salt))));
				
			?>
			Test sha-3 :
		</pre>
	</div>
</div>
