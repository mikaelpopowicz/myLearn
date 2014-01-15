<form action="" method="post">
	<p>
		<?php if (isset($erreurs) && in_array(\Library\Entities\News::AUTEUR_INVALIDE, $erreurs)) echo 'L\'auteur est invalide.<br />'; ?>
			<label>Auteur</label>
			<input type="text" name="auteur" value="<?php if (isset($news)) echo $news['auteur']; ?>" /><br />
     
			<?php if (isset($erreurs) && in_array(\Library\Entities\News::TITRE_INVALIDE, $erreurs)) echo 'Le titre est invalide.<br />'; ?>
				<label>Titre</label><input type="text" name="titre" value="<?php if (isset($news)) echo $news['titre']; ?>" /><br />
     
				<?php if (isset($erreurs) && in_array(\Library\Entities\News::CONTENU_INVALIDE, $erreurs)) echo 'Le contenu est invalide.<br />'; ?>
					<label>Contenu</label><textarea rows="8" cols="60" name="contenu"><?php if (isset($news)) echo $news['contenu']; ?></textarea><br />
					<?php
					if(isset($news) && !$news->isNew())
					{
						?>
						<input type="hidden" name="id" value="<?php echo $news['id']; ?>" />
						<input type="submit" value="Modifier" name="modifier" />
						<?php
					}
					else
					{
						?>
						<input type="submit" value="Ajouter" />
						<?php
					}
					?>
				</p>
			</form>