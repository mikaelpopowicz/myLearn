<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en" dir="ltr"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en" dir="ltr"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" dir="ltr"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" dir="ltr" lang="en"><!--<![endif]-->
<head>
		<title>
			<?php
			echo isset($title) ? $title : "Titre";
			?>
		</title>
		
		<!-- Meta Data ================ -->
		<meta charset="UTF-8"/>
		<meta content="Fill this in with your information" name="description"/>
		
		<!--- highly suggested that you un-comment this on a live site -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">


		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta content="yes" name="apple-mobile-web-app-capable"/>
		
		<!-- CSS ================ -->
		<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="/assets/css/docs.css" rel="stylesheet" type="text/css"/>
		<link href="/assets/css/theme.reset.min.css" rel="stylesheet" type="text/css"/>
		<link href="/assets/css/style.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="/js/sh/styles/shCoreDjango.css">
		<link type="text/css" rel="stylesheet" href="/js/sh/styles/shThemeDjango.css"/>
		
		
		<link rel="stylesheet" type="text/css" media="print" href="/assets/css/print.css" />		

		<!-- Icons ================ put your icons and favicons below -->
		<!--http://mathiasbynens.be/notes/touch-icons-->
		<link rel="shortcut icon" href="/images/favicon.png">

		<script>window.jQuery || document.write('<script src="/assets/js/jquery-1.9.1.min.js"><\/script>')</script>

		<!-- Add to HEAD after style sheet http://modernizr.com/docs/#installing  ================ -->
		<script src="/assets/js/modernizr.custom.js?v=2.6.2"></script>

		
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">Your browser is over 12 years old. You are using an <strong>outdated</strong> browser. Please <a href="http://www.google.com/chrome/intl/en/landing_chrome.html">upgrade your browser</a>.</p>
<![endif]--> 

	<!-- begin accesibility skip to nav skip content -->
	<ul class="visuallyhidden" id="top">
		<li><a href="#nav" title="Skip to navigation" accesskey="n">Skip to navigation</a></li>
		<li><a href="#page" title="Skip to content" accesskey="c">Skip to content</a></li>
	</ul>
	<!-- end /.visuallyhidden accesibility--> 

	<!-- begin .header-->
	<header class="header clearfix">
 

		<!-- mobile navigation trigger-->
		<h5 class="mobile_nav"><a href="javascript:void(0)">&nbsp;<span></span> </a> </h5>

		<!--******this uses the bootstrap navbar menus but with added support for submenus (they are dropping these in 3.0 and their support in 2X was crap).
		I modified the JS, added some script, and adjusted the css.
		I commented and separeated the html so you can apply it to your site/menu system easier. Note the additional classes for this theme.
		*******-->
		<div id="nav">
			<!--accesibility-->
			<div class="navbar secondary-menu">
				<div class="container">
					<div class="navbar-inner">
						<div class="nav-collapse collapse">
							<ul class="nav accordmobile pull-right"><!--accordmobile comes in when the browser is at 979px and below, it fixes bugs with bootstrap's toggles of multiple level dropdowns which they are dropping support for and they had lousy support in 2x-->
								<?php
								if($user->isAuthenticated()) {	
								?>
								<!--begin .dropdown .parent -->
								<li class="dropdown parent"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mon compte <i class="e-icon-cog"></i></a>
									<ul class="dropdown-menu">
										<li class="current-user">
											<a href="/membre/mon-profil">
												<?php
												$img = is_file("/img/avatar/avatar-".$user->getAttribute('id').".jpeg") ? "/img/avatar/avatar-".$user->getAttribute('id') : "/img/avatar/default.png";
												?>
												<img class="avatar" src="<?php echo $img;?>" alt="<?php echo $user->getAttribute('username')?>">
												<div class="name">
													<b class="fullname"><?php echo $user->getAttribute("username");?></b><br>
													<small> Modifier mon profil </small>
												</div>
											</a>
										</li>
										<li class="divider"></li>
										<li><a href="/cours/ecrire-un-cours">Ecrire un cours</a></li>
										<li class="divider"></li>
										<li><a href="/membre/ma-configuration">Configuration</a></li>
										<li>
											<a href="/connexion/logout/<?php echo $_SERVER['REQUEST_URI'];?>">Déconnexion</a>
										</li>
									</ul><!--close .dropdown-menu -->
								</li><!--close .dropdown .parent -->
								
								<?php
								} else {
								?>
								<li><a href="/inscription">Devenir membre <i class="e-icon-pencil"></i></a></li>
								<?php
								}
								?>
												
								<li class="divider-vertical"></li>
										
								<li class="search-wrapper">
									<form action="someaction.php" method="post">
										<div id="search-trigger">
											<i class="e-icon-search"></i>
										</div>
										<input placeholder="Rechercher" type="text">
									</form>
								</li>
							</ul><!-- close nav accordmobile-->
						</div>
						<!--/.nav-collapse -->
					</div>
					<!-- /.navbar-inner -->
				</div>
				<!--/.container -->
			</div>
			<!-- /.navbar -->
		
			<div class="container">
				<div class="navbar primary-menu">
					<div class="navbar-inner">
						<div class="nav-collapse collapse">
							<ul class="nav accordmobile">
								<li class="<?php echo $class_accueil;?>"><a href="/">Accueil</a></li>
								<li class="dropdown parent <?php echo $class_cours;?>">
									<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Cours <i class="e-icon-down-open-mini"></i></a>
									<ul class="dropdown-menu">
										<?php
										foreach ($matieres as $key) {
											$class = "class_".$key['libelle'];
											echo '<li class="'.$$class.'"><a href="/cours/'.$key->libelle().'">'.$key->libelle().'</a></li>';
										}
										?>
									</ul>
								</li>
								<li class="<?php echo $class_tutos;?>"><a href="/tutos">Tutos</a></li>
								<li class="<?php echo $class_contact;?>"><a href="/contact">Contact</a></li>
							</ul>
						</div>
						<!--/.nav-collapse -->
					</div>
					<!-- /.navbar-inner -->
				</div>
				<!-- /.navbar --> 

				<div id="logo" class="text-logo">
					<h2><a href="/"><span>my</span>Learn</a></h2>
					<!--
					<object class="logo-svg" data="/assets/images/logo.svg" type="image/svg+xml">
					</object>
					<img src="/assets/images/logo.png" alt="Corporate-Elegance Responsive Retina Ready Portfolio Business"/><.no-svg fallback-->
				</div> 
				<!-- end #logo --> 
				<!-- ******* print stuff --><div class="print">Phone, name of company etc., for printing</div>
			</div>
			<!-- /.container --> 
		</div>
		<!--close #nav-->
 
	</header><!-- close /.header --> 

	<!-- begin #page - the container for everything but header -->
	<div id="page" class="clearfix">
		<!--== CONTENU DE LA PAGE ==-->
		<?php
		echo isset($content) ? $content : "";
		//echo '<pre>';print_r($_SESSION);echo '</pre>';
		?>
		<!--== FIN DU CONTENU DE LA PAGE ==-->	
		

		<!--change this to your stuff-->
		<section class="footer-credits">
			<div class="container">
				<ul class="clearfix">
					<li>© 2013 myLearn. All rights reserved.</li>
					<li><a href="#">Conditions d'utilisation</a></li>
					<li><a href="#">Politique de confidentialité</a></li>
					<li><a href="#">Plus d'informations</a></li>
				</ul>
			</div>
			<!--close footer-credits container--> 
		</section>
		<!--close section .footer-credits--> 
		<span class="backToTop"><a href=""><i class="e-icon-up-open-big"></i></a></span>
	</div>
	<!-- close #page-->
	<!--=== Includes modal ===-->
	<?php
	if (isset($includes)) {
		foreach ($includes as $include) {
			echo '<pre>'.$include.'</pre>';
			include $include;
		}
	}
	?>
	<!--===  End Includes modal ===-->

	<!-- JS General Site COMBINE AND COMPRESS WHEN YOU FIGURE OUT WHAT YOU WANT TO USE comes with unpacked versions ================ --> 
	<script src='/assets/js/theme-menu.js'></script><!-- menu --> 
	<script src='/assets/js/jquery.easing-1.3.min.js'></script><!-- easing --> 
	<script src='/assets/js/bootstrap.min.js'></script><!-- bootstrap / custom.js loads --> 
	<script src='/assets/js/jquery.easytabs.min.js'></script><!-- tabs/testimonials custom.js / loads --> 
	<script src='/assets/js/slide-to-top-accordion.min.js'></script><!-- slide to top accordion toggle / custom.js loads --> 
	<script src='/assets/js/bootstrap-progressbar.min.js'></script><!-- progress bar loading in page --> 

	<!-- Fancy Box and Isotope ================ 
	<script src='/assets/js/jquery.isotope.min.js'></script><!--filter masonry script AND loading> 
	<script src='/assets/js/fancybox/source/custom-fancybox-combined.js' defer></script><!--all fancy box buttons, media, helpers, thumbs AND loading--> 

	<!-- Sliders ================ 
	<script src='/assets/js/jquery.flexslider.min.js'></script><!--flexslider (twitter, blog, portfolio, full width) AND loading > 
	<script src='/assets/js/lemmon-slider.min.js'></script><!-- variable width image slider AND loading -->
	
	<!-- Noty ================ -->
	<script src='/assets/js/noty/packaged/jquery.noty.packaged.min.js'></script>
	
	<!-- Highlight ================ -->
	<script src="/js/sh/scripts/shCore.js"></script>
	<script src="/js/sh/scripts/shBrushJScript.js"></script>
	<script src="/js/sh/scripts/shBrushCpp.js"></script>
	<script src="/js/sh/scripts/shBrushPhp.js"></script>
	<script src="/js/sh/scripts/shBrushXml.js"></script>
	<script src="/js/sh/scripts/shBrushSql.js"></script>
	<script src="/js/sh/scripts/shBrushJava.js"></script>
	<script type="text/javascript">
	     SyntaxHighlighter.all()
	</script>

	<!-- TinyMce ================ -->
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

	<!--initialize scripts / custom scripts--> 
	<script src='/assets/js/custom.js'></script>
	
	
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