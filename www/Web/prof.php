<?php
$start = microtime(true);
require '../Library/autoload.php';
require '../Library/PHPMailer/class.phpmailer.php';
if(file_exists('../Applications/Prof/ProfApplication.class.php')) {
	$app = new Applications\Prof\ProfApplication($start);
	$app->run();
} else {
	$app = new Applications\Install\InstallApplication($start);
	$app->run();
}
?>