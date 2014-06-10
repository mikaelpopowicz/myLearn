<form method="POST">
	<input type="text" name="batman" />
	<button type="submit" name="blabla">Valider</button>
</form>
<?php
echo isset($texte) ? $texte : "";
if(isset($objet))
{
	echo '<pre>';
	print_r($objet);
	echo '</pre>';
	
	if(isset($erreur) && is_array($erreur) && in_array(\Library\Entities\Test::TITRE_INVALIDE, $erreur))
	{
		echo 'Titre invalide';
	}
}

?>