<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

	<title>
		<?php
		echo isset($title) ? $title : "Titre";
		?>
	</title>

	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/css/doc.css" rel="stylesheet">
	<link href="/css/navbar.css" rel="stylesheet">
	<link href="/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="/assets/css/font-awesome.css" rel="stylesheet">
	<link href="/css/bootstrap-select.css" rel="stylesheet">
	<link href="/css/datepicker.css" rel="stylesheet">
	<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
		selector: "textarea#contenu",
	    theme: "modern",
	    height: 500,
		content_css: "/assets/css/style.css",
		plugins: "code",
		invalid_elements : "script",
		extended_valid_elements: "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],img[href|src|name|title|onclick|align|alt|title|width|height|vspace|hspace],iframe[id|class|width|size|noshade|src|height|frameborder|border|marginwidth|marginheight|target|scrolling|allowtransparency],style[type]"
	 }); 
	</script>

	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
</head>
<body>
	<div class="container">

		<!-- Static navbar -->
		<div class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/admin">myLearn | Professeur</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown <?php echo isset($class_cours) ? $class_cours : "";?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Classes <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							
							if(isset($classes) && is_array($classes) && count($classes) > 0)
							{
								foreach ($classes as $classe) {
									$key = unserialize(base64_decode($classe));
									$css = "class_".$key->id()."_cl";
									$$css = isset($$css) ? $$css : "";
									echo "<li class='".$$css."'><a href='/professeur/cours/".str_replace("/","-",$key->session()->session())."/".$key->uri()."'>".$key->libelle()." - ".$key->session()->session()."</a></li>";
								}
							}
							else
							{
								echo "<li>Aucune classe disponible</li>";
							}
							/*
							foreach ($matieres as $key) {
								$class = "class_".$key['libelle'];
								echo '<li class="'.$$class.'"><a href="/cours/'.$key->libelle().'">'.$key->libelle().'</a></li>';
							}
							*/
							?>
						</ul>
					</li>
					<li class="<?php echo isset($class_perso) ? $class_perso : "" ;?>"><a href="/professeur/mes-cours">Mes cours</a></li>
					<li class="<?php echo isset($class_devoir) ? $class_devoir : "" ;?>"><a href="/professeur/devoirs">Devoirs</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="<?php echo isset($class_param) ? $class_param : "";?>"><a href="/professeur/parametres">Paramètres</a></li>
					<li class=""><a href="/connexion/logout//">Déconnexion</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
		
		<?php
		echo $content;
		?>
		<hr>
	  	<footer class="footer">
	  		<p class="text-muted">© 2014 . myLearn - Page executée en <?php echo $load->load()." ms";?></p>
	  	</footer>
	</div> <!-- /container -->
	
	<!--=== Includes modal ===-->
	<?php
	if (isset($includes)) {
		foreach ($includes as $include) {
			//echo '<pre>'.$include."</pre>";
			include $include;
		}
	}
	?>
	<!--===  End Includes modal ===-->

	<!-- Bootstrap core JavaScript ================ -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="/js/jquery-1.10.2.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src='/assets/js/noty/packaged/jquery.noty.packaged.min.js'></script>
	<script src='/js/dataTables/jquery.dataTables.js'></script>
	<script src='/js/dataTables/dataTables.bootstrap.js'></script>
	<script src='/js/bootstrap-datepicker.js'></script>
	<script src='/js/bootstrap-select.js'></script>
	<script src='/js/custom.js'></script>
	
	<!--=== JavaScript insert code ===-->
	<?php
	if (isset($js)) {
		foreach ($js as $javascript) {
			echo $javascript;
		}
	}
	if ($user->hasFlash()) echo $user->getFlash();?>
	<!--===  End JavaScript insert code ===-->
</body>
</html>
