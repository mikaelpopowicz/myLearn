<div class="page-header">
	<h1>Mon premier module</h1>
</div>

<div class="main-content">
	<div class="container">
		<h2>test</h2>
		<form method="post" >
			<p>
			    <input type="text" name ="nb1" />
				<input type="text" name ="nb2" >
			    <input type="submit" value="Valider" name="valider" />
			
			</p>
		</form>
		<?php echo isset($message) ? $message :"" ?>
		<table class="table">
			<thead>
				<th>Nom</th>
				<th>Prenom</th>
				<th>Identifiant</th>
				<th>Matiere </th>
				
			</thead>
			<tbody>
				<?php
				foreach ($lesprofs as $key) {
					echo '<tr>';
					echo '<td>';
					echo $key->Nom();
					echo '</td>';
					echo '<td>';
					echo $key->Prenom();
					
					echo '</td>';
					echo '<td>';
					echo $key->id();
					echo '</td>';
					
					echo '<td>';
					echo $key->matiere()->libelle();
					echo '</td>';
					echo '</tr>';
					
					
				}
				?>
			</tbody>
		</table>
	</div>
</div>