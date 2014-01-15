<?php
require '../Library/autoload.php';
 
$app = new Applications\Frontend\FrontendApplication;
$app->run();
?>
<h2>Bienvenue sur la page d'inscription de coachme</h2>
<form>
	<p>Veuillez choisir votre fonction au sein de ce site</p>
	<select name="choix">
		<option value="Coach">Coach </option1>
		<option value="Elève">Eleve </option2>
	</select>
	<input type="submit"NAME=nom VALUE="Valider">
</form>