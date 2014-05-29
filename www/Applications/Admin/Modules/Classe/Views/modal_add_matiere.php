<form method="post" action="/admin/classes/<?php echo $classe->id()?>">
	<div class="modal fade" id="AddMatiere" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Ajouter une matière</h4>
				</div>
				<div class="modal-body">
					<select multiple id="matiere" name="matiere[]" class="form-control selectpicker" data-live-search="true">
					<?php
					if(isset($allMatiere) && is_array($allMatiere)) {
						foreach ($allMatiere as $matiere) {
							echo '<option value="'.$matiere->id().'" data-icon="fa '.$matiere->icon().'">'.$matiere->libelle().'</option>';
						}
					}
					?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply fa-fw"></i> Annuler</button>
					<button type="submit" name="ajout_matiere" class="btn btn-success"><i class="fa fa-plus-square-o fa-fw"></i> Ajouter</button>
				</div>
			</div>
		</div>
	</div>
</form>