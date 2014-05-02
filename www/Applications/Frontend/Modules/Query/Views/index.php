<div class="page-header">
	<h1>Faire une recherche</h1>
</div>
<div class="strip primary">
	<div class="container">
		<ul class="inline">
			<li>
				<a href="/" class="primary-color">Accueil</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				Recherche
			</li>
		</ul>
	</div>
</div>
<div class="main-content container">
	<div class="form-signin">
		<h3 class="short_headline text-center"><span>Recherche</span></h3>
		<form method="post">
			<fieldset>
				<input type="text" class="input-block-level search-query" name="query" placeholder="Votre recherche" autofocus>
				<br/><br/>
				<button class="btn custom-btn btn-primary btn-large" type="submit">
					<i class="icon-lock"></i> Go
				</button>
			</fieldset>
		</form>
	</div>
	<?php
	echo isset($query) ? $query : "";
	?>
</div>