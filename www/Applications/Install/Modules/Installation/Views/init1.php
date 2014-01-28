<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Vérifications <span class="pull-right">Etape 1/4</span></h3>
			</div>
			<div class="panel-body">
				<p>
					L'assistant va vérifier que les conditions d'installations sont remplies :
				</p>
				<ul >
					<li>
						PHP 5.2
						<span class="pull-right">
							<?php echo $php;?>
						</span>
					</li>
					<li>
						Apache mod_rewrite
						<span class="pull-right">
							<?php echo $mod;?>
						</span>
					</li>
					<li>
						/Applications/Admin/ est accessible en éciture
						<span class="pull-right">
							<?php echo $dir['admin'];?>
						</span>
					</li>
					<li>
						/Applications/Frontend/ est accessible en éciture
						<span class="pull-right">
							<?php echo $dir['frontend'];?>
						</span>
					</li>
					<li>
						/Applications/Prof/ est accessible en éciture
						<span class="pull-right">
							<?php echo $dir['prof'];?>
						</span>
					</li>
					<li>
						/Applications/Admin/AdminApplication.back.class.php est accessible en éciture
						<span class="pull-right">
							<?php echo $app['admin'];?>
						</span>
					</li>
					<li>
						/Applications/Frontend/FrontendApplication.back.class.php est accessible en éciture
						<span class="pull-right">
							<?php echo $app['frontend'];?>
						</span>
					</li>
					<li>
						/Applications/Prof/ProfApplication.back.class.php est accessible en éciture
						<span class="pull-right">
							<?php echo $app['prof'];?>
						</span>
					</li>
					<li>
						/Applications/Admin/Config est accessible en éciture
						<span class="pull-right">
							<?php echo $conf['admin'];?>
						</span>
					</li>
					<li>
						/Applications/Frontend/Config est accessible en éciture
						<span class="pull-right">
							<?php echo $conf['frontend'];?>
						</span>
					</li>
					<li>
						/Applications/Prof/Config est accessible en éciture
						<span class="pull-right">
							<?php echo $conf['prof'];?>
						</span>
					</li>
				</ul>
				<?php
				if(!empty($message)) echo $message;
				?>
			</div>
			<div class="panel-footer">
				<form role="check" class="form-inline" method="post">
					<button name="previous" class="btn btn-default">Retour</button>
					<button name="next" class="btn btn-primary pull-right" <?php echo isset($next) ? $next : "";?>>Suivant</button>
				</form>
			</div>
		</div>
	</div>
</div>