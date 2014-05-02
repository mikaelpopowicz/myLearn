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
	<link href="/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>		
	<div class="jumbotron">
		<div class="container">
			<h1>Installation de <span class="text-info">myLearn</span></h1>
			<p>Un problème ? Consulter notre <a href="http://mylearn.cpm-web.fr/faq">FAQ</a></p>
		</div>
	</div>
	<div class="container">
		<!--=== Content ===-->
		<?php
		echo $content;
		?>
		<!--=== End Content ===-->
	</div> <!-- div.container -->
	
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
	<script src='/assets/js/jquery.dataTables.js'></script>
	<script src='/assets/js/datatables.js'></script>
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
