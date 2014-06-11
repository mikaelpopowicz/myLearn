<?php
namespace Library;

class Mailer extends \Library\ApplicationComponent
{
	private $mail;
	private $sujet;
	private $titre;
	private $message;
	private $team;
	private $contact;
	private $phpmail;
	private $host;
	private $port;
	private $security;
	private $username;
	private $password;
	private $sender;
	
	public function __construct($app) {
		parent::__construct($app);
		
		$this->setTeam($app->config()->get('conf_nom'));
		$this->setContact($app->config()->get('conf_contact'));
		$this->setHost($app->config()->get('smtp_host'));
		$this->setPort($app->config()->get('smtp_port'));
		$this->setSecurity($app->config()->get('smtp_security'));
		$this->setUsername($app->config()->get('smtp_user'));
		$this->setPassword($app->config()->get('smtp_pass'));
		$this->setSender($app->config()->get('conf_email'));
		$this->phpmail = new \PHPMailer(true);
		$this->phpmail->IsSMTP();
	}
	
	public function setMail($mail) {
		$this->mail = $mail;
	}
	
	public function setSujet($sujet) {
		$this->sujet = $sujet;
	}

	public function setLigne($ligne) {
		$this->ligne = $ligne;
	}

	public function setTeam($team) {
		$this->team = $team;
	}

	public function setContact($contact) {
		$this->contact = $contact;
	}
	
	public function setHost($host)
	{
		$this->host = $host;
	}
	
	public function setPort($port)
	{
		$this->port = $port;
	}
	
	public function setSecurity($security)
	{
		if($security == "none")
		{
			$this->security = "";
		}
		else
		{
			$this->security = $security;
		}
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	public function setSender($sender)
	{
		$this->sender = $sender;
	}
	
	public function send()
	{
		$this->phpmail->IsHTML(true);
		$this->phpmail->CharSet		=	"utf-8";
		$this->phpmail->Subject		=	$this->sujet;
		$this->phpmail->Body		=	$this->message;
		$this->phpmail->Host		=	$this->host;
		$this->phpmail->SMTPDebug	=	0;
		$this->phpmail->SMTPAuth	=	true;
		$this->phpmail->SMTPSecure	=	$this->security;
		$this->phpmail->Port		=	$this->port;
		$this->phpmail->Username	=	$this->username;
		$this->phpmail->Password	=	$this->password;
		$this->phpmail->SetFrom($this->sender, "MyLearn");
		if(is_array($this->mail))
		{
			foreach ($this->mail as $mail) {
				$this->phpmail->AddAddress($mail);
			}
		}
		else
		{
			$this->phpmail->AddAddress($this->mail);
		}
		try {
			$this->phpmail->Send();
		} catch (\phpmailerException $e) {
			return $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
			return $e->getMessage(); //Boring error messages from anything else!
		}
		return true;
	}
	
	
	
	public function setMessage($titre, $message) {
		/*
		$this->message = $this->ligne."--".$this->boundary.$this->ligne;
		
		//=====Ajout du message au format HTML
		$this->message.= "Content-Type: text/html; charset=\"UTF-8\"".$this->ligne;
		$this->message.= "Content-Transfer-Encoding: 8bit".$this->ligne;
		*/
		
		$http = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "https" : "http";
		
		$string = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta name="viewport" content="width=device-width" />
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>Email</title>
				<style type="text/css">
				/* ------------------------------------- 
						GLOBAL 
				------------------------------------- */
				* { 
					margin:0;
					padding:0;
				}
				* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }

				img { 
					max-width: 100%; 
				}
				.collapse {
					margin:0;
					padding:0;
				}
				body {
					-webkit-font-smoothing:antialiased; 
					-webkit-text-size-adjust:none; 
					width: 100%!important; 
					height: 100%;
				}


				/* ------------------------------------- 
						ELEMENTS 
				------------------------------------- */
				a { color: #2BA6CB;}

				.btn {
					text-decoration:none;
					color: #FFF;
					background-color: #666;
					padding:10px 16px;
					font-weight:bold;
					margin-right:10px;
					text-align:center;
					cursor:pointer;
					display: inline-block;
				}

				p.callout {
					padding:15px;
					background-color:#ECF8FF;
					margin-bottom: 15px;
				}
				.callout a {
					font-weight:bold;
					color: #2BA6CB;
				}

				table.social {
				/* 	padding:15px; */
					background-color: #ebebeb;
	
				}
				.social .soc-btn {
					padding: 3px 7px;
					font-size:12px;
					margin-bottom:10px;
					text-decoration:none;
					color: #FFF;font-weight:bold;
					display:block;
					text-align:center;
				}
				a.fb { background-color: #3B5998!important; }
				a.tw { background-color: #1daced!important; }
				a.gp { background-color: #DB4A39!important; }
				a.ms { background-color: #000!important; }

				.sidebar .soc-btn { 
					display:block;
					width:100%;
				}

				/* ------------------------------------- 
						HEADER 
				------------------------------------- */
				table.head-wrap { width: 100%;}

				.header.container table td.logo { padding: 15px; }
				.header.container table td.label { padding: 15px; padding-left:0px;}


				/* ------------------------------------- 
						BODY 
				------------------------------------- */
				table.body-wrap { width: 100%;}


				/* ------------------------------------- 
						FOOTER 
				------------------------------------- */
				table.footer-wrap { width: 100%;	clear:both!important;
				}
				.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
				.footer-wrap .container td.content p {
					font-size:10px;
					font-weight: bold;
	
				}


				/* ------------------------------------- 
						TYPOGRAPHY 
				------------------------------------- */
				h1,h2,h3,h4,h5,h6 {
				font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
				}
				h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

				h1 { font-weight:200; font-size: 44px;}
				h2 { font-weight:200; font-size: 37px;}
				h3 { font-weight:500; font-size: 27px;}
				h4 { font-weight:500; font-size: 23px;}
				h5 { font-weight:900; font-size: 17px;}
				h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

				.collapse { margin:0!important;}

				p, ul { 
					margin-bottom: 10px; 
					font-weight: normal; 
					font-size:14px; 
					line-height:1.6;
				}
				p.lead { font-size:17px; }
				p.last { margin-bottom:0px;}

				ul li {
					margin-left:5px;
					list-style-position: inside;
				}

				/* ------------------------------------- 
						SIDEBAR 
				------------------------------------- */
				ul.sidebar {
					background:#ebebeb;
					display:block;
					list-style-type: none;
				}
				ul.sidebar li { display: block; margin:0;}
				ul.sidebar li a {
					text-decoration:none;
					color: #666;
					padding:10px 16px;
				/* 	font-weight:bold; */
					margin-right:10px;
				/* 	text-align:center; */
					cursor:pointer;
					border-bottom: 1px solid #777777;
					border-top: 1px solid #FFFFFF;
					display:block;
					margin:0;
				}
				ul.sidebar li a.last { border-bottom-width:0px;}
				ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



				/* --------------------------------------------------- 
						RESPONSIVENESS
						Nuke it from orbit. It\'s the only way to be sure. 
				------------------------------------------------------ */

				/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
				.container {
					display:block!important;
					max-width:600px!important;
					margin:0 auto!important; /* makes it centered */
					clear:both!important;
				}

				/* This should also be a block element, so that it will fill 100% of the .container */
				.content {
					padding:15px;
					max-width:600px;
					margin:0 auto;
					display:block; 
				}

				/* Let\'s make sure tables in the content area are 100% wide */
				.content table { width: 100%; }


				/* Odds and ends */
				.column {
					width: 300px;
					float:left;
				}
				.column tr td { padding: 15px; }
				.column-wrap { 
					padding:0!important; 
					margin:0 auto; 
					max-width:600px!important;
				}
				.column table { width:100%;}
				.social .column {
					width: 280px;
					min-width: 279px;
					float:left;
				}

				/* Be sure to place a .clear element after each set of columns, just to be safe */
				.clear { display: block; clear: both; }


				/* ------------------------------------------- 
						PHONE
						For clients that support media queries.
						Nothing fancy. 
				-------------------------------------------- */
				@media only screen and (max-width: 600px) {
	
					a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

					div[class="column"] { width: auto!important; float:none!important;}
	
					table.social div[class="column"] {
						width:auto!important;
					}

				}

				/* --------------------->>> Text Logo (text-logo.html) see info.html for instructions <<<---------------------*/
				#logo.text-logo h2 {
				    float: left;
				    color: #999;
				}
				#logo.text-logo {
				    margin: 0
				}
				#logo.text-logo h2 span {
					color:#57a;
				}
				#logo.text-logo h2 a {
				    text-decoration: none;
					color:#444;
				}
				</style>

			</head>
 
			<body bgcolor="#FFFFFF">

				<!-- HEADER -->
				<table class="head-wrap" bgcolor="#f2f3f7">
					<tr>
						<td></td>
						<td class="header container" >
				
								<div class="content">
								<table bgcolor="#f2f3f7">
									<tr>
										<td>
											<div id="logo" class="text-logo">
												<h2><a href="'.$http.'://'.$_SERVER['HTTP_HOST'].'"><span>my</span>Learn</a></h2>
											</div>
											</td>
										<td align="right"><h6 class="collapse">'.$titre.'</h6></td>
									</tr>
								</table>
								</div>
				
						</td>
						<td></td>
					</tr>
				</table><!-- /HEADER -->


				<!-- BODY -->
				<table class="body-wrap">
					<tr>
						<td></td>
						<td class="container" bgcolor="#FFFFFF">

							<div class="content">
							<table>
								<tr>
									<td>	
										'.$message.'		
										<!-- social & contact -->
										<table class="social" width="100%">
											<tr>
												<td>
									
													<!-- column 1 -->
													<table align="left" class="column">
														<tr>
															<td>				
												
																<h5 class="">Informations:</h5>
																<p class="">Ne répondez pas à cet email, aucune réponse ne sera traitée. Pour toutes demandes veuillez vous adresser à l\'adresse de contact</p>
						
												
															</td>
														</tr>
													</table><!-- /column 1 -->	
									
													<!-- column 2 -->
													<table align="left" class="column">
														<tr>
															<td>				
																			
																<h5 class="">Contacts:</h5>												
																<p>Email: <strong><a href="mailto:'.$this->contact.'">'.$this->contact.'</a></strong></p>
                
															</td>
														</tr>
													</table><!-- /column 2 -->
									
													<span class="clear"></span>	
									
												</td>
											</tr>
										</table><!-- /social & contact -->
						
									</td>
								</tr>
							</table>
							</div><!-- /content -->
									
						</td>
						<td></td>
					</tr>
				</table><!-- /BODY -->

				<!-- FOOTER -->
				<table class="footer-wrap">
					<tr>
						<td></td>
						<td class="container">
			
								<!-- content -->
								<div class="content">
								<table>
								<tr>
									<td align="center">
										<p>
											L\'équipe '.$this->team.'
										</p>
									</td>
								</tr>
							</table>
								</div><!-- /content -->
				
						</td>
						<td></td>
					</tr>
				</table><!-- /FOOTER -->

			</body>
			</html>';
		$this->message .= $string;
		/*
		//==========
		$this->message.= $this->ligne."--".$this->boundary."--".$this->ligne;
		$this->message.= $this->ligne."--".$this->boundary."--".$this->ligne;
		*/
	}
}
?>