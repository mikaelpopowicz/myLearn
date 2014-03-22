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
				<a href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.urlencode(str_replace(' ','-',$classe->libelle()));?>" class="primary-color"><?php echo $classe->libelle().' - Session '.$classe->session()->session();?></a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<?php echo $matiere->libelle();?>
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="row-fluid sidebar-right">
			<div class="span9 blog-summary primary-column">
				<?php
				if (isset($lesCours) && is_array($lesCours) && !empty($lesCours)){
					foreach ($lesCours as $cours) {
				?>
				<article class="entry-post">
					<header class="entry-header">
						<h3 class="entry-title primary-color"><a  href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.urlencode(str_replace(' ','-',$classe->libelle()))."/".$key->uriEncode($cours->matiere()->libelle())."/".$key->uriEncode($cours->titre());?>"><?php echo $cours->titre()?></a></h3>
						<div class="byline">
							<i class="e-icon-pencil"></i> <?php echo ucfirst($cours->auteur()->nom())." ".ucfirst($cours->auteur()->prenom());?> &nbsp;&nbsp; <i class="e-icon-clock"></i> <abbr class="published" title="<?php echo "Le ".$cours->dateAjout()->format('d/m/Y à H\hi');?>"><?php echo $cours->dateAjout()->format('d/m/Y');?></abbr> &nbsp;&nbsp; <i class="e-icon-chat"></i> <?php echo count($cours->commentaires())?> commentaire<?php echo count($cours->commentaires()) > 1 ? "s" : "";?>
						</div>
						<div class="entry-meta">
							<i class="e-icon-folder"></i> <a href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.urlencode(str_replace(' ','-',$classe->libelle()))."/".$key->uriEncode($cours->matiere()->libelle());?>"><?php echo $cours->matiere()->libelle();?></a>
						</div>
					</header>
					
					<div class="entry-content">
						<p><?php echo $cours->description();?></p>
						<p class="text-right"><a class="btn btn-primary btn-small custom-btn"  href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.urlencode(str_replace(' ','-',$classe->libelle()))."/".$key->uriEncode($cours->matiere()->libelle())."/".$key->uriEncode($cours->titre());?>"> Lire &rarr;</a>
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
					echo "</br></br><h2>Il n'y a pas encore de cours dans cette matière</h2>";
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