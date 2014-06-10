<div class="page-header">
	<h1>Mon premier module</h1>
</div>

<div class="main-content">
	<div class="container">
		<h2>test</h2>
	
		 
		<table>
			<thead>
				<th>Libelle</th>
				<th>Icone</th>
			</thead>
			<tbody>
				<?php
				foreach ($liste as $key )
				 {
					 echo "<tr>";
					 echo "<td>".$key->libelle()."</td>";
					 echo "<td>".$key->icon()."</td>";
					 echo "</tr>";
				}
				
				?>
			</tbody>
		</table>
	</div>
</div>