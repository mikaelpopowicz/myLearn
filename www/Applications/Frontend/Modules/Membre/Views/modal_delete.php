<form method="post" action="/cours/supprimer-un-cours">
	<div class="modal fade" id="modalDeleteCours" tabindex="-1" role="dialog" aria-labelledby="modalDeleteCours" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Suppression de cours</h4>
				</div>
				<div class="modal-body">
					<p>Êtes-vous sur de vouloir supprimer le(s) cours suivant(s) :</p>
					<ul>
						<?php
						$i = 0;
						foreach($delete as $suppr) {
							echo '<li class="text-error">'.$suppr['titre'].'</li>';
							echo '<input type="hidden" name="suppr_'.$i.'" value="'.base64_encode(serialize($suppr)).'">';
							$i += 1;
						}
						?>
					</ul>
					<input type="hidden" name="count" value="<?php echo count($delete);?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
					<button type="submit" class="btn btn-danger">Supprimer</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</form>