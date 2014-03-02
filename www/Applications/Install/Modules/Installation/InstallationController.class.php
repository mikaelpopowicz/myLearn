<?php
namespace Applications\Install\Modules\Installation;

class InstallationController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		if($request->getExists('lost')) {
			$this->app->httpresponse()->redirect('/');
		}
		$this->page->addVar('title', 'myLearn - Première installation');
	}
	
	public function executeInit1(\Library\HTTPRequest $request)
	{
		if($request->postExists('previous')) {
			$this->app->httpresponse()->redirect('/');
		}
		$this->page->addVar('title', 'myLearn - Vérifications');
		$erreur = array();
		
		$php = phpversion();
		$php = explode('.', $php);
		if ($php[0] >= 5 && $php[1] >= 2) {
			$php = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$php = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "php";
		}
		
		if (in_array ("mod_rewrite", apache_get_modules())) {
			$mod = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$mod = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "rewrite";
		}
		
		$conf = array();
		$conf['admin'] = is_writable("../Applications/Admin/Config/");
		if ($conf['admin']) {
			$conf['admin'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$conf['admin'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "admin";
		}
		$conf['frontend'] = is_writable("../Applications/Frontend/Config/");
		if ($conf['frontend']) {
			$conf['frontend'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$conf['frontend'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "frontend";
		}
		$conf['prof'] = is_writable("../Applications/Prof/Config/");
		if ($conf['prof']) {
			$conf['prof'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$conf['prof'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "prof";
		}
		
		$app = array();
		$app['admin'] = is_writable("../Applications/Admin/AdminApplication.back.class.php");
		if ($app['admin']) {
			$app['admin'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$app['admin'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "admin";
		}
		$app['frontend'] = is_writable("../Applications/Frontend/FrontendApplication.back.class.php");
		if ($app['frontend']) {
			$app['frontend'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$app['frontend'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "frontend";
		}
		$app['prof'] = is_writable("../Applications/Prof/ProfApplication.back.class.php");
		if ($app['prof']) {
			$app['prof'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$app['prof'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "prof";
		}
		
		$dir = array();
		$dir['admin'] = is_writable("../Applications/Admin/");
		if ($dir['admin']) {
			$dir['admin'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$dir['admin'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "admin";
		}
		$dir['frontend'] = is_writable("../Applications/Frontend/");
		if ($dir['frontend']) {
			$dir['frontend'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$dir['frontend'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "frontend";
		}
		$dir['prof'] = is_writable("../Applications/Prof/");
		if ($dir['prof']) {
			$dir['prof'] = '<span class="label label-success"><i class="fa fa-check"></i> </span>';
		} else {
			$dir['prof'] = '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
			$erreur[] = "prof";
		}
		
		if (empty($erreur)) {
			$this->page->addVar('next', '');
			if($request->postExists('next')) {
				$this->app->user()->setAttribute('step1', 'ok');
				$this->app->httpresponse()->redirect('/install-2');
			}
		} else {
			$this->page->addVar('next', 'disabled');
			$this->app->user()->setAttribute('step1', 'error');
		}
		
		
		
		$message = !empty($erreur) ? "<p><span class='text-danger'>Veuillez corriger les erreurs et recharger cette page</span></p>" : "";
		
		$this->page->addVar('php', $php);
		$this->page->addVar('conf', $conf);
		$this->page->addVar('app', $app);
		$this->page->addVar('dir', $dir);
		$this->page->addVar('message', $message);
		$this->page->addVar('mod', $mod);
	}
	
	public function executeInit2(\Library\HTTPRequest $request)
	{
		if($this->app->user()->getAttribute('step1') != 'ok') {
			$this->app->httpresponse()->redirect('/install-1');
		} else {
			//echo '<pre>';print_r($_SESSION);echo '</pre>';
			//echo '<pre>';print_r(unserialize(base64_decode($this->app->user()->getAttribute('bdd'))));echo '</pre>';
			if($this->app->user()->getAttribute('step2') == 'ok') {
				$this->page->addVar('bdd', unserialize(base64_decode($this->app->user()->getAttribute('bdd'))));
				$this->page->addVar('message', '<p><span class="text-success">Connexion réussie</span></p>');
				$this->page->addVar('next', '');
			} else {
				$this->page->addVar('next', 'disabled');
			}
			
			if($request->postExists('previous')) {
				$this->app->httpresponse()->redirect('/install-1');
			}
			
			if($request->postExists('next')) {
				$this->app->httpresponse()->redirect('/install-3');
			}
			
			if($request->postExists('connexion')) {
				$bdd = array(
					"hote" => $request->postData('hote'),
					"base" => $request->postData('base'),
					"user" => $request->postData('user'),
					"password" => $request->postData('password')
				);
				$erreur = array();
				foreach ($bdd as $donnee => $value) {
					if(empty($value)) {
						$erreur[] = $donnee;
						$this->app->user()->setAttribute('step2', 'error');
					}
				}
				if(empty($erreur)) {
					try {
						$dbh = new \PDO('mysql:host='.$bdd['hote'].';dbname='.$bdd['base'], $bdd['user'], $bdd['password']);
						$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
					} catch (\PDOException $e) {
						$erreur[] = "bdd";
						$this->app->user()->setAttribute('step2', 'error');
						$this->page->addVar('message', '<p><span class="text-danger">Connexion échouée, veuillez vérifier les informations</span></p>');
						$this->app->user()->setAttribute('bdd', NULL);
					}
					if(empty($erreur)) {
						$this->app->user()->setAttribute('step2', 'ok');
						$this->app->user()->setAttribute('bdd', base64_encode(serialize($bdd)));
						$this->page->addVar('next', '');
						$this->page->addVar('message', '<p><span class="text-success">Connexion réussie</span></p>');
					} else {
						$this->page->addVar('next', 'disabled');
						$this->page->addVar('erreur', $erreur);
					}
				} else {
					$this->page->addVar('next', 'disabled');
					$this->page->addVar('erreur', $erreur);
				}
				$this->page->addVar('bdd', $bdd);
			}
		}
				
		$this->page->addVar('title', 'myLearn - Informations BDD');		
	}
	
	public function executeInit3(\Library\HTTPRequest $request)
	{
		if($this->app->user()->getAttribute('step1') == 'ok') {
			if($this->app->user()->getAttribute('step2') == 'ok') {
				if($this->app->user()->getAttribute('step3') == 'ok') {
					$this->page->addVar('infos', unserialize(base64_decode($this->app->user()->getAttribute('infos'))));
					//echo '<pre>';print_r(unserialize(base64_decode($this->app->user()->getAttribute('infos'))));echo '</pre>';
				}
				if($request->postExists('previous')) {
					$this->app->httpresponse()->redirect('/install-2');
				}
			
				if($request->postExists('next')) {
					$infos = array(
						"nom" => $request->postData('nom'),
						"description" => $request->postData('description'),
						"email" => $request->postData('email'),
						"contact" => $request->postData('contact')
					);
					$erreur = array();
					foreach ($infos as $donnee => $value) {
						if(empty($value)) {
							$erreur[] = $donnee;
							$this->app->user()->setAttribute('step3', 'error');
							$this->app->user()->setAttribute('infos', NULL);
						}
					}
					if(empty($erreur)) {
						$this->app->user()->setAttribute('step3', 'ok');
						$this->app->user()->setAttribute('infos', base64_encode(serialize($infos)));
						$this->app->httpresponse()->redirect('/install-4');
					} else {
						$this->page->addVar('infos', $infos);
						$this->page->addVar('erreur', $erreur);
					}
				}
				
			} else {
				$this->app->httpresponse()->redirect('/install-2');
			}
		} else {
			$this->app->httpresponse()->redirect('/install-1');
		}
	}
	
	public function executeInit4(\Library\HTTPRequest $request)
	{
		if($this->app->user()->getAttribute('step1') == 'ok') {
			if($this->app->user()->getAttribute('step2') == 'ok') {
				if($this->app->user()->getAttribute('step3') == 'ok') {
					if($request->postExists('finish')) {
						$this->app->user()->delUser();
						$this->app->user()->setFlash('<script>noty({type: "success", layout: "top", text: "<strong>Installation terminée !</strong>"});</script>');
						$this->app->httpresponse()->redirect('/');
					}
					
					$this->page->addVar('finish', 'disabled');
					$erreur = array();
					$date = new \DateTime(date('Y-m-d'));					
					$bdd = unserialize(base64_decode($this->app->user()->getAttribute('bdd')));
					$infos = unserialize(base64_decode($this->app->user()->getAttribute('infos')));
					$cle_taille = mcrypt_module_get_algo_key_size(MCRYPT_3DES);
					$iv_taille = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_NOFB);
					$iv = mcrypt_create_iv($iv_taille, MCRYPT_RAND);
					$app = array();
					$app[] = fopen('../Applications/Frontend/Config/app.xml', 'w+');
					$app[] = fopen('../Applications/Admin/Config/app.xml', 'w+');
					$app[] = fopen('../Applications/Prof/Config/app.xml', 'w+');
					$str = '<?xml version="1.0" encoding="utf-8" ?>
<definitions>
	<define var="db_host" value="'.$bdd['hote'].'" />
	<define var="db_name" value="'.$bdd['base'].'" />
	<define var="db_user" value="'.$bdd['user'].'" />
	<define var="db_user_pass" value="'.$bdd['password'].'" />
	<define var="conf_nom" value="'.$infos['nom'].'" />
	<define var="conf_description" value="'.$infos['description'].'" />
	<define var="conf_email" value="'.$infos['email'].'" />
	<define var="conf_contact" value="'.$infos['contact'].'" />
	<define var="conf_date" value="'.$date->format('d/m/Y').'" />
	<define var="cryp_key_ln" value="'.$cle_taille.'" />
	<define var="cryp_iv" value="'.base64_encode($iv).'" />
	<define var="installed" value="true" />
</definitions>';
					$put = array();
					$dir = array('Frontend', 'Admin', 'Prof');
					for($i = 0; $i < 3; $i++) {
						$put[$i] = fwrite($app[$i], "$str");
						if ($put[$i]) {
						    @chmod("../Applications/".$dir[$i]."/Config/app.xml", 0755);
						} else {
							$erreur[] = "infos";
						}
						fclose($app[$i]);
						rename("../Applications/".$dir[$i]."/".$dir[$i]."Application.back.class.php", "../Applications/".$dir[$i]."/".$dir[$i]."Application.class.php");
					}
					$str1 = "";
					$pdo1 = fopen('../Applications/Install/Modules/Installation/mylearn.sql', 'r');
					while (!feof($pdo1)) {
						$str1 .= fgets($pdo1, 12040);
					}
					fclose($pdo1);
					/*
					$dba = new \PDO('mysql:host='.$bdd['hote'].';dbname=information_schema', $bdd['user'], $bdd['password']);
					$dba->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
					$query = $dba->query("DELETE FROM TABLES WHERE TABLE_NAME = 'mylearn'");
					*/
					$dbh = new \PDO('mysql:host='.$bdd['hote'].';dbname='.$bdd['base'], $bdd['user'], $bdd['password']);
					$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
					$sql1 = $dbh->exec($str1);
					if(!isset($sql1)) {
						$erreur[] = "bdd";
					}
					//echo '<pre>';print_r($str2);echo '</pre>';
					$conf = !in_array('infos', $erreur) ? '<span class="label label-success"><i class="fa fa-check"></i> </span>' : '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
					$db = !in_array('bdd', $erreur) ? '<span class="label label-success"><i class="fa fa-check"></i> </span>' : '<span class="label label-danger"><i class="fa fa-times"></i> </span>';
					
					if(empty($erreur)) {
						$this->page->addVar('finish', '');
						$message = "<p><span class='text-success'>Installation réussie</span></p><p>Pour votre première connexion veuillez utiliser le login <strong><span class='text-info'>admin</span></strong> et le mot de passe <strong><span class='text-info'>admin</span></strong></p>";
					} else {
						$message = "<p><span class='text-danger'>L'installation à échouée. Veuillez supprimer la BDD et recommencer !</span></p>";
					}
					
					$this->page->addVar('conf', $conf);
					$this->page->addVar('db', $db);
					$this->page->addVar('message', $message);
					
					if($request->postExists('previous')) {
						$this->app->httpresponse()->redirect('/install-3');
					}
					
				} else {
					$this->app->httpresponse()->redirect('/install-3');
				}
			} else {
				$this->app->httpresponse()->redirect('/install-2');
			}
		} else {
			$this->app->httpresponse()->redirect('/install-1');
		}
	}
}
?>