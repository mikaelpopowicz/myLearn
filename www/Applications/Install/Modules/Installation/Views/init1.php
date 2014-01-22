<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Vérifications <span class="pull-right">Etape 1/3</span></h3>
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
						/Applications/Frontend/Config est accessible en éciture
						<span class="pull-right">
							<?php echo $conf;?>
						</span>
					</li>
				</ul>
			</div>
			<div class="panel-footer">
				<form role="check" class="form-inline" method="post">
					<button name="previous" class="btn btn-default">Retour</button>
					<button class="btn btn-primary pull-right">Suivant</button>
				</form>
			</div>
		</div>
	</div>
</div>