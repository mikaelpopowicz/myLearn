<form method="post" action="/admin/classes/<?php echo $classe->id()?>">
	<div class="modal fade" id="AddEleve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Ajouter un élève</h4>
				</div>
				<div class="modal-body">
					<select multiple id="eleve" name="eleve[]" class="form-control selectpicker" data-live-search="true">
					<?php
					if(isset($allEleve) && is_array($allEleve)) {
						foreach ($allEleve as $eleve) {
							echo '<option value="'.$eleve->id().'">'.$eleve->nom().' '.$eleve->prenom().'</option>';
						}
					}
					?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply fa-fw"></i> Annuler</button>
					<button type="submit" name="ajout_eleve" class="btn btn-success"><i class="fa fa-plus-square-o fa-fw"></i> Ajouter</button>
				</div>
			</div>
		</div>
	</div>
</form>