<div class="page-header">
	<h1>Gestion des utilisateurs</h1>
</div>
<form method="post" class="form-horizontal">
	<div class="panel panel-info">

		<div class="panel-heading">
			<div class="pull-right">
				<button class="btn btn-xs btn-success" name="ajouter">
					<i class="fa fa-plus-square-o"></i>
					Ajouter
				</button>
				<button class="btn btn-xs btn-warning" name="modifier">
					<i class="fa fa-edit"></i>
					Modifier
				</button>
				<button class="btn btn-xs btn-danger" name="supprimer">
					<i class="fa fa-trash-o"></i>
					Supprimer
				</button>
			</div>
			<h3 class="panel-title"><i class="fa fa-users fa-lg"></i> Administrateurs</h3>
			<span class="pull-right">
		</div>

		<div class="panel-body">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<th>
						<input type="checkbox" id="checkAll">
					</th>
				</thead>
			</table>
		</div>

	</div>
</form>

<?php
foreach ($adm as $ad) {
	echo "<pre>";print_r($ad);echo "</pre>";
}
?>