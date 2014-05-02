<?php
$start = microtime(true);
require '../Library/autoload.php';
require '../Library/PHPMailer/class.phpmailer.php';
if(file_exists('../Applications/Admin/AdminApplication.class.php') && file_exists('../Applications/Admin/Config/app.xml')) {
	$app = new Applications\Admin\AdminApplication($start);
	$app->run();
} else {
	$app = new Applications\Install\InstallApplication;
	$app->run();
}
?>