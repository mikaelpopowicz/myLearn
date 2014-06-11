<form method="post" action="/professeur/devoirs/<?php echo $devoir->id()?>" enctype="multipart/form-data">
	<div class="modal fade" id="AddPiece" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Ajouter une pièce jointe</h4>
				</div>
				<div class="modal-body">
					<input type="file" name="piece" id="piece">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply fa-fw"></i> Annuler</button>
					<button type="submit" name="ajout_piece" class="btn btn-success"><i class="fa fa-plus-square-o fa-fw"></i> Ajouter</button>
				</div>
			</div>
		</div>
	</div>
</form>