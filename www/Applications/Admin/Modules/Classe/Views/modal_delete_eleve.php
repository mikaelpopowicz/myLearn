<form method="post" action="/admin/classes/<?php echo $classe->id();?>/supprimer-eleve">
	<div class="modal fade" id="modalDeleteEleve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Suppression d'élève(s)</h4>
				</div>
				<div class="modal-body">
					<p>Êtes-vous sur de vouloir supprimer l'(es) élève(s) suivant(s) :</p>
					<ul>
						<?php
						$i = 0;
						foreach($delete as $suppr) {
							echo '<li class="text-danger">'.$suppr['eleve']->nom().'</li>';
							echo '<input type="hidden" name="suppr_'.$i.'" value="'.base64_encode(serialize($suppr['etre'])).'">';
							$i += 1;
						}
						?>
					</ul>
					<input type="hidden" name="count" value="<?php echo count($delete);?>">
					<input type="hidden" name="classe" value="<?php echo $classe->id();?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply fa-fw"></i> Annuler</button>
					<button type="submit" name="del_eleve" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Supprimer</button>
				</div>
			</div>
		</div>
	</div>
</form>