<div class="page-header">
	<h1>Cours</h1>
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
				<a href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.$classe->uri();?>" class="primary-color"><?php echo $classe->libelle()." - Session ".$classe->session()->session();?></a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<a href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.$classe->uri()."/".$matiere->uri();?>" class="primary-color"><?php echo $matiere->libelle();?></a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<?php echo $cours->titre();?>
			</li>
		</ul>
	</div>
</div>
<div class="main-content">
	<div class="container">
		<div class="row-fluid sidebar-right">
			<div class="span9 blog-detail primary-column">
				<!--begin primary-column-->
				<article class="entry-post">
					<header class="entry-header">
						<h1 class="primary-color"><?php echo $cours->titre();?></h1>
						<div class="byline">
							<i class="e-icon-pencil"></i> <?php echo ucfirst($cours->auteur()->nom()).' '.ucfirst($cours->auteur()->prenom());?> &nbsp;&nbsp; <i class="e-icon-clock"></i> <abbr class="published" title="<?php echo "Le ".$cours['dateAjout']->format('d/m/Y à H\hi');?>"><?php echo $cours['dateAjout']->format('d/m/Y');?></abbr> &nbsp;&nbsp; <a href="#view-comments" class="scrollto"><i class="e-icon-chat"></i> <?php echo count($cours->commentaires())?> commentaire<?php echo count($cours->commentaires()) > 1 ? "s" : "";?></a> &nbsp;&nbsp; <i class="e-icon-eye"></i> <?php echo count($cours->vues())?> visite<?php echo count($cours->vues()) > 1 ? "s" : "";?>
						</div>
						<div class="entry-meta">
							<i class="e-icon-folder"></i> <a href="/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.$classe->uri()."/".$matiere->uri();?>"><?php echo $matiere->libelle();?></a>
						</div>
					</header>
					<!--end entry-header-->
								
					<div class="entry-content">
						<?php echo $cours->contenu();?>
					</div>
					<!--end entry-content-->
								
					<footer class="entry-footer">
						<span class="blog date">
							<span class="month"><?php echo $cours['dateAjout']->format('M');?></span>
							<span class="day"><?php echo $cours['dateAjout']->format('d');?></span>
							<span class="year"><?php echo $cours['dateAjout']->format('Y');?></span>
						</span> 
						<!--close date--> 
					</footer>
					<!--end entry-footer--> 
								
				</article>
				<!--end entry-post -->
						
				<br><br>
				<!--begin comments section-->
				<section id="view-comments" class="entry-comments clearfix">
					<h3 class="short_headline"><span><?php echo count($cours->commentaires())?> Commentaires <a href="#comment-form" class="scrollto"> &middot; Faire un commentaire</a></span></h3>
					<!--begin comments-->
					<ul>
						<?php
						$comments = $cours->commentaires();
						if(isset($comments) && is_array($comments) && count($comments) > 0) {
							foreach($comments as $comment) {
						?>
						<!--grand parent-->
						<li id="comment-1"><!--parent-->
							<footer class="comment-meta">
								<div class="comment-meta">
									<span class="comment-author">
										<cite>
											<?php echo ucfirst($comment->auteur()->nom()).' '.ucfirst($comment->auteur()->prenom());?>
										</cite>
									</span>
									<time class="published">
										<?php echo $comment['dateCommentaire']->format('\L\e d/m/Y à H\hi')?>
									</time>
									
								</div>
								<?php
								if($comment->auteur()->id() == $user->getAttribute('id'))
								{
								?>
								<div class="pull-right">
									<a href="/cours/supprimer-commentaire-<?php echo $comment->id()?>" class="btn btn-danger"><i class="fa fa-trash-o"></i> </a>
								</div>
								<?php
								}
								?>
								
							</footer>
							<div class="text">
								<?php echo $comment['commentaire'];?>
							</div>
						</li>
						<!-- close parent li-->
						<?php
							}
						}
						?>
					</ul>
					<!-- close grandparent ul--> 
					<!-- End Comments --> 
					

					
					<!-- Begin Comments Form -->
					<div id="comment-form">
						<h3>Laisser un commentaire</h3>
						<form class="comment_form" method="post">
								<span class="inputwrapper">
									<label for="message">Message :</label>
									<textarea name="message" id="message" rows="5" cols="30" ></textarea>
								</span>
							<input type="submit" value="Envoyer message" class="btn btn-primary" name="comment" />
						</form>
					</div>
					<!-- End Comment Form -->
					
				</section>
				<!--close comment section-->		
			</div>
			<?php
			include ('sidebar.php');
			?>
		</div>
	</div>
</div>