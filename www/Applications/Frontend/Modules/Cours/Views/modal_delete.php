<div id="modalDeleteCours" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalDeleteCours" aria-hidden="true">
	<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Supprimer de cours</h3>
	</div>
	<div class="modal-body">
		<p>Êtes-vous sur de vouloir supprimer le(s) cours suivant(s) :</p>
		<ul>
			<?php
			$i = 0;
			foreach($delete as $suppr) {
				echo '<li class="text-danger">'.$suppr['titre'].'</li>';
				echo '<input type="hidden" name="suppr_'.$i.'" value="'.base64_encode(serialize($suppr)).'">';
				$i += 1;
			}
			?>
		</ul>
		<input type="hidden" name="count" value="<?php echo count($delete);?>">
	</div>
	<div class="modal-footer">
		<form method="post" action="/membre/supprimer-un-">
				<button class="btn" data-dismiss="modal">Annuler</button>
				<button name="submit" type="submit" class="btn btn-danger">Supprimer</button>
			</form>
	</div>
</div>