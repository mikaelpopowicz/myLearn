<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Enregistrement <span class="pull-right">Etape 4/4</span></h3>
			</div>
			<div class="panel-body">
				<p>
					Enregistrement des donnée :
				</p>
				<ul >
					<li>
						Fichier de configuration
						<span class="pull-right">
							<?php echo $conf;?>
						</span>
					</li>
					<li>
						Base de donnée
						<span class="pull-right">
							<?php echo $db;?>
						</span>
					</li>
				</ul>
				<?php
				if(!empty($message) && isset($message)) echo $message;
				?>
			</div>
			<div class="panel-footer">
				<form role="check" class="form-inline" method="post">
					<button name="previous" class="btn btn-default">Retour</button>
					<button name="finish" class="btn btn-primary pull-right" <?php echo isset($next) ? $next : "";?>>Terminer</button>
				</form>
			</div>
		</div>
	</div>
</div>