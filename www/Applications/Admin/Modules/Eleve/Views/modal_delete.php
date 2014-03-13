<form method="post" action="/admin/eleves/supprimer">
	<div class="modal fade" id="modalDeleteEleve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Suppression d'élève(s)</h4>
				</div>
				<div class="modal-body">
					<p class="text-danger"><strong>ATTENTION, la suppression d'un élève entraine la supression de tous ses devoirs, ainsi que les cours dont il est l'auteur !</strong><p>
					<p>Êtes-vous sur de vouloir supprimer l'(es) élève(s) suivant(s) :</p>
			<ul>
				<?php
				$i = 0;
				foreach($delete as $suppr) {
					echo '<li class="text-danger">'.$suppr->nom().'</li>';
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