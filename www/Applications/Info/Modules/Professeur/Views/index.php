<title>
	<?php
	echo isset($title) ? $title : "Titre";
	?>
</title>

<h1>Paul la fripolle</h1>
<form method="POST">
	<input type="text" name="test">
	<input type="text" name="test1">
	<button type="submit" name="buttonTest">
	Valider
	</button>
</form>
<?php

echo isset($test) ? $test : "";
foreach ($toto as $key => $value) {
	echo '<br>' . $key . ' - ' . $value;
};
	
?>