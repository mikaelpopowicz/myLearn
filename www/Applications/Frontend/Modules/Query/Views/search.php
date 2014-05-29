<div class="page-header">
	<h1>Résultat(s) de la recherche</h1>
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
				<a href="/search" class="primary-color">Recherche</a>
			</li>
			<li class="primary-color">
				/
			</li>
			<li>
				Résultat(s) pour "<?php echo isset($original) ? $original : "" ?>"
			</li>
		</ul>
	</div>
</div>
<div class="main-content container">
	<?php
	if(isset($result) && is_array($result))
	{
	?>
		<h2 class="text-success"><?php echo count($result);?> résultat<?php echo count($result) > 1 ? 's' : '' ?> pour "<?php echo isset($original) ? $original : "" ?>" :</h2>
		<dl>
			<?php
			foreach ($result as $cours) {
				echo "\n\t<dt><h4><a class='primary-color' href='/cours/".str_replace('/','-',$cours->classe()->session()->session())."/".$cours->classe()->uri()."/".$cours->matiere()->uri()."/".$cours->uri()."'>".$cours->titre()."</a> &nbsp;&nbsp; <small>".$cours->classe()->libelle()." - ".$cours->classe()->session()->session()." | ".$cours->matiere()->libelle()."</small></h4></dt>";
				echo "\n\t<dd><dl class='dl-horizontal'><dt>Description</dt><dd>".$cours->description()."<dd/></dl></dd>";
			}	
			?>
		</dl>
		
		
	<?php
	}
	else if(isset($erreur))
	{
	?>
	<h2 class="text-error">Aucun résultat pour "<?php echo isset($original) ? $original : "" ?>"</h2>
	<?php
	}
	?>
	<div class="form-signin">
		<h3 class="short_headline text-center"><span>Faire une autre recherche</span></h3>
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
</div>