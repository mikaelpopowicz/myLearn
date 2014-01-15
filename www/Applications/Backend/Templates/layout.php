
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
	<link href="/assets/css/datatables.css" rel="stylesheet">
	
	<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
		selector: "textarea#contenu",
	    theme: "modern",
	    height: 500,
		content_css: "/assets/css/style.css",
		plugins: "code",
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
				<a class="navbar-brand" href="/admin">Mika-p | Admin</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="<?php echo $class_accueil;?>"><a href="/admin">Tableau de bord</a></li>
					<li class="<?php echo $class_cours;?>"><a href="/admin/cours">Cours</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Utilisateurs <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/admin/user/listing">Listing</a></li>
							<li><a href="/admin/user/acl">Gérer les droits</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class=""><a href="/admin/logout">Déconnexion</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
		
		<?php
		echo $content;
		?>

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
	<script src="/js/jquery-1.7.2.min.js"></script>
	<script src="/js/jquery.uniform.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/holder.js"></script>
	<!-- Noty ================ -->
	<script src='/assets/js/noty/packaged/jquery.noty.packaged.min.js'></script>
	<script src='/assets/js/jquery.dataTables.js'></script>
	<script src='/assets/js/datatables.js'></script>
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
