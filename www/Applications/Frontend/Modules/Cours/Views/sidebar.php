<section class="span3 sidebar secondary-column"> 
	<aside class="widget clearfix">
		<h5 class="short_headline"><span>Matières</span></h5>
		<ul class="navigation">
			<?php
			$matieres = $classe->matieres();
			if(isset($matieres) && is_array($matieres)) {
				foreach($matieres as $mat) {
					$active = $mat->id() == $matiere->id() ? "active" : "";
					echo "<li class='".$active."'><a href='/cours/".str_replace('/','-',$classe->session()->session())."/".$classe->uri()."/".$mat->uri()."'>".$mat['libelle']."</a>";
				}
			}
			?>
		</ul>
	</aside>

	<aside class="widget">
		<h5 class="short_headline"><span>Cours</span></h5>
		<div class="tab-pane">
			<div class="tabbable">
				<ul class="nav nav-pills">
					<li class="active"><a href="#latest" data-toggle="tab">Derniers</a></li>
					<li><a href="#popular" data-toggle="tab">Populaires</a></li>
				</ul>
				<div class="tab-content">
					<div id="latest" class="tab-pane active">
						<ul class="blogposts clearfix">
							<?php
							if(isset($special['last']) && is_array($special['last']) && !empty($special['last'])) {
								foreach($special['last'] as $last) {
									
							?>
							<!--required class-->
							<li>
								<a href="/cours/<?php echo str_replace('/','-',$last->classe()->session()->session()).'/'.$last->classe()->uri().'/'.$last->matiere()->uri().'/'.$last->uri()?>">
									<span class="date">
										<span class="month"><?php echo $last['dateAjout']->format('M');?></span>
										<span class="day"><?php echo $last['dateAjout']->format('d');?></span>
										<span class="year"><?php echo $last['dateAjout']->format('Y');?></span>
									</span>
									<h3><?php echo $last['titre'];?> - <?php echo $last->matiere()->libelle()?></h3>
									<p><?php echo substr($last['description'], 0, 50);?></p>
								</a>
							</li>
							<?php
								}
							} else {
								echo "<li><p class='text-info'>Aucun résultat</p></li>";
							}
							?>
						</ul>
					</div>
					<div id="popular" class="tab-pane">
						<ul class="blogposts clearfix">
							<?php
							if(isset($special['fav']) && is_array($special['fav']) && !empty($special['fav'])) {
								foreach($special['fav'] as $fav) {
									
							?>
							<!--required class-->
							<li>
								<a href="/cours/<?php echo str_replace('/','-',$fav->classe()->session()->session()).'/'.$fav->classe()->uri().'/'.$fav->matiere()->uri().'/'.$fav->uri()?>">
									<span class="date">
										<span class="month"><?php echo $fav['dateAjout']->format('M');?></span>
										<span class="day"><?php echo $fav['dateAjout']->format('d');?></span>
										<span class="year"><?php echo $fav['dateAjout']->format('Y');?></span>
									</span>
									<h3><?php echo $fav['titre'];?> - <?php echo $fav->matiere()->libelle()?></h3>
									<p><?php echo substr($fav['description'], 0, 50);?></p>
								</a>
							</li>
							<?php
								}
							} else {
								echo "<li><p class='text-info'>Aucun résultat</p></li>";
							}
							?>
						</ul>
					</div>
					<!--close #popular -->								
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.tabbable -->
		</div>
		<!-- /.tab-pane --> 
	</aside>
	<!-- close .widget containing blog tabs-->
</section>
<!--close section sidebar span3-->