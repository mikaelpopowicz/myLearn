<form method="post" action="/professeur/devoirs/supprimer">
	<div class="modal fade" id="modalDeleteDevoir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Suppression de devoir(s)</h4>
				</div>
				<div class="modal-body">
					<p>Êtes-vous sur de vouloir supprimer le(s) devoir(s) suivant(s) :</p>
			<ul>
				<?php
				$i = 0;
				foreach($delete as $suppr) {
					echo '<li class="text-danger">'.$suppr->libelle().'</li>';
					echo '<input type="hidden" name="suppr_'.$i.'" value="'.base64_encode(serialize($suppr)).'">';
					$i += 1;
				}
				?>
			</ul>
			<input type="hidden" name="count" value="<?php echo count($delete);?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply fa-fw"></i> Annuler</button>
					<button type="submit" name="valider_suppression" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Supprimer</button>
				</div>
			</div>
		</div>
	</div>
</form>