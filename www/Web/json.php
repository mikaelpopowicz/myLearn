<?php
$start = microtime(true);
require '../Library/autoload.php';
if(file_exists('../Applications/Json/JsonApplication.class.php') && file_exists('../Applications/Json/Config/app.xml')) {
	$app = new Applications\Json\JsonApplication($start);
	$app->run();
} else {
	require '../Library/PHPMailer/class.phpmailer.php';
	$app = new Applications\Install\InstallApplication($start);
	$app->run();
}
?>	