<div class="page-header">
	<h1>Liste des cours</h1>
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
				<a href="/cours" class="primary-color">Cours</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<?php echo $matiere;?>
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="row-fluid sidebar-right">
			<div class="span9 blog-summary primary-column">
				<?php
				if (!empty($listeCours)){
					foreach ($listeCours as $cours) {
				?>
				<article class="entry-post">
					<header class="entry-header">
						<h3 class="entry-title primary-color"><a  href="/cours/<?php echo $matiere;?>/<?php echo $cours['id']?>"><?php echo $cours['titre']?></a></h3>
						<div class="byline">
							<i class="e-icon-pencil"></i> <?php echo ucfirst($cours['auteur']);?> &nbsp;&nbsp; <i class="e-icon-clock"></i> <abbr class="published" title="<?php echo "Le ".$cours['dateAjout']->format('d/m/Y à H\hi');?>"><?php echo $cours['dateAjout']->format('d/m/Y');?></abbr> &nbsp;&nbsp; <i class="e-icon-chat"></i> <?php echo count($comments->getListOf($cours['id']));?> commentaire<?php echo count($comments->getListOf($cours['id'])) > 1 ? "s" : "";?>
						</div>
						<div class="entry-meta">
							<i class="e-icon-folder"></i> <a href="/cours/<?php echo $matiere;?>"><?php echo $matiere;?></a>
						</div>
					</header>
					
					<div class="entry-content">
						<p><?php echo $cours['description'];?></p>
						<p class="text-right"><a class="btn btn-primary btn-small custom-btn"  href="/cours/<?php echo $matiere;?>/<?php echo $cours['id']?>">Lire &rarr;</a>
					</div>
								
					<footer class="entry-footer">
						<span class="blog date">
							<span class="month"><?php echo $cours['dateAjout']->format('M');?></span>
							<span class="day"><?php echo $cours['dateAjout']->format('d');?></span>
							<span class="year"><?php echo $cours['dateAjout']->format('Y');?></span>
						</span> 
					</footer>
				</article>
				<?php
					}
				} else {
					echo "</br></br><h2>Il n'y a pas encore de cours dans cette section</h2>";
				}
				?>
			</div>
			<!-- / .span9 .blog-summary-->
			<?php
			include 'sidebar.php';
			?>
		</div>
	</div>
</div>