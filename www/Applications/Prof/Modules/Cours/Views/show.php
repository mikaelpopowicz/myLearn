<div class="row">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li><a href="/professeur">Accueil</a></li>
			<li><a href="/professeur/cours/<?php echo str_replace('/','-',$classe->session()->session()).'/'.$classe->uri()?>"><?php echo $classe->libelle().' - '.$classe->session()->session()?></a></li>
			<li class="active"><?php echo $cours->titre();?></li>
		</ol>
	</div>
</div>
<section id="cours">
	<h1 class="text-primary">
		<?php echo $cours->titre();?>
	</h1>
	<div>
		<i class="fa fa-pencil"></i>&nbsp; <?php echo $cours->auteur()->nom().' '.$cours->auteur()->prenom();?>
		&nbsp;&nbsp;&nbsp;
		<i class="fa fa-clock-o"></i>&nbsp; <?php echo $cours->dateAjout()->format('d/m/Y');?>
	</div>
	<br/>
	<div>
		<?php echo $cours->contenu();?>
	</div>
</section>
<section id="view-comments" class="clearfix">
	<h3 class="text-primary"><span><?php echo count($cours->commentaires())?> Commentaires <a href="#comment-form" class="scrollto"> &middot; Faire un commentaire</a></span></h3>
	<!--begin comments-->
	<?php
	$comments = $cours->commentaires();
	if(isset($comments) && is_array($comments) && count($comments) > 0) {
		foreach($comments as $comment) {
	?>
	<!-- begin parent div-->
	<div>
		<p>
			<cite class="text-info">
				<?php echo ucfirst($comment->auteur()->nom()).' '.ucfirst($comment->auteur()->prenom());?>
			</cite>
			<small class="text-muted">
				<?php echo $comment['dateCommentaire']->format('\L\e d/m/Y à H\hi')?>
			</small>
			<?php
			if($comment->auteur()->id() == $user->getAttribute('id'))
			{
			?>
			<span>
				<a href="/cours/supprimer-commentaire-<?php echo $comment->id()?>" class="btn btn-danger"><i class="fa fa-trash-o"></i> </a>
			</span>
			<?php
			}
			?>
		</p>
		<p>
			<?php echo $comment['commentaire'];?>
		</p>
	</div>
	<!-- close parent div-->
	<?php
		}
	}
	?>
	<!-- End Comments --> 
	

	
	<!-- Begin Comments Form -->
	<div id="comment-form">
		<h3 class="text-info">Laisser un commentaire</h3>
		<form class="form" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-sm-8">
						<label for="exampleInputEmail1">Message</label>
						<textarea class="form-control" rows="5" name="message"></textarea>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<input type="submit" value="Envoyer message" class="btn btn-primary" name="comment" />
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- End Comment Form -->
	
</section>
<!--close comment section-->