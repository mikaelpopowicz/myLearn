
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title><?php echo isset($title) ? $title : "" ;?></title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">
  </head>

  <body>

	  <?php
	  echo $content;
	  ?>
	  
  	<!-- Bootstrap core JavaScript ================ -->
  	<!-- Placed at the end of the document so the pages load faster -->
  	<script src="/js/jquery-1.7.2.min.js"></script>
  	<script src="/js/bootstrap.min.js"></script>
  	<!-- Noty ================ -->
  	<script src='/assets/js/noty/packaged/jquery.noty.packaged.min.js'></script>
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
