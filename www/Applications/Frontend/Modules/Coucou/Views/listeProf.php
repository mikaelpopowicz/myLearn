<div class="page-header">
	<h1>Mon premier module</h1>
</div>

<div class="main-content">
	<div class="container">
		<h2>test</h2>
		<table>
			<thead>
				<th>nom</th>
				<th>prenom</th>
			</thead>
			<tbody>
				<?php
				foreach ($liste as $key )
				 {
					 echo "<tr>";
					 echo "<td>".$key->nom()."</td>";
					 echo "<td>".$key->prenom()."</td>";
					 echo "</tr>";
				}
				
				?>
			</tbody>
		</table>
		<?php echo '<pre>';print_r($test);echo '</pre>';?>
	</div>
</div>