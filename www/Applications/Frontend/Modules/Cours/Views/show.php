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
				<a href="/cours/<?php echo $matiere;?>" class="primary-color"><?php echo $matiere;?></a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				<?php echo $cours['titre'];?>
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
						<h1 class="primary-color"><?php echo $cours['titre'];?></h1>
						<div class="byline">
							<i class="e-icon-pencil"></i> <?php echo ucfirst($cours['auteur']);?> &nbsp;&nbsp; <i class="e-icon-clock"></i> <abbr class="published" title="<?php echo "Le ".$cours['dateAjout']->format('d/m/Y à H\hi');?>"><?php echo $cours['dateAjout']->format('d/m/Y');?></abbr> &nbsp;&nbsp; <a href="#view-comments" class="scrollto"><i class="e-icon-chat"></i> <?php echo count($comments)?> comments</a>
						</div>
						<div class="entry-meta">
							<i class="e-icon-folder"></i> <a href="/cours/<?php echo $matiere;?>"><?php echo $matiere;?></a>
						</div>
					</header>
					<!--end entry-header-->
								
					<div class="entry-content">
						<?php echo $cours['contenu'];?>
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
					<h3 class="short_headline"><span><?php echo count($comments)?> Commentaires <a href="#comment-form" class="scrollto"> &middot; Faire un commentaire</a></span></h3>
					<!--begin comments-->
					<ul>
						<?php
						if(isset($comments) && count($comments) > 0) {
							foreach($comments as $comment) {
								$test = $byteController->getUnique($comment['auteur']);
								//echo '<pre>';print_r($test);echo '</pre>';
						?>
						<!--grand parent-->
						<li id="comment-1"><!--parent-->
							<footer class="comment-meta">
								<a href="#" rel="external nofollow" title="<?php echo ucfirst($byteController->getUnique($comment['auteur'])['username']);?>">
									<img alt="<?php echo $byteController->getUnique($comment['auteur'])['username'];?>" src="/demo/kathy.jpg" class="avatar" />
								</a>
								<div class="comment-meta">
									<span class="comment-author vcard">
										<cite title="LinkURLofauthor">
											<a href="#" title="Kathy" class="url" rel="external nofollow">
												<?php echo ucfirst($byteController->getUnique($comment['auteur'])['username']);?>
											</a>
										</cite>
									</span>
									<time class="published">
										<?php echo $comment['dateCommentaire']->format('\L\e d/m/Y à H\hi')?>
									</time>
								</div>
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
						<?php
						if($user->isAuthenticated()) {
							$nameValue = $user->getAttribute('username');
							$emailValue = $user->getAttribute('email');
						?>
						<h3>Laisser un commentaire</h3>
						<p>Les champs marqués du signe <span class="text-error">*</span> sont obligatoires.</p>
						<form class="comment_form" method="post">
								<span class="inputwrapper name">
									<label for="name"><span class="text-error">*</span> Votre nom ou pseudo:</label>
									<input type="text" id="name" name="name" value="<?php echo $nameValue;?>" readonly />
								</span>
								<span class="inputwrapper email">
									<label for="email"><span class="text-error">*</span> Email:</label>
									<input type="email" id="email" name="email" value="<?php echo $emailValue;?>" readonly />
								</span>
								<span class="inputwrapper">
									<label for="message">Message :</label>
									<textarea name="message" id="message" rows="5" cols="30" ></textarea>
									<input type="hidden" value="<?php echo $user->getAttribute('id');?>" name="byte" />
								</span>

							<input type="submit" value="Envoyer message" class="btn btn-primary" name="comment" />
						</form>
						<?php
						} else {
							echo "<h2 class='text-error'>Vous devez être connecté pour laisser un commentaire</h2>";
						}
						?>
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