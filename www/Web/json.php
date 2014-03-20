<?php
require '../Library/autoload.php';
if(file_exists('../Applications/Json/JsonApplication.class.php')) {
	$app = new Applications\Json\JsonApplication;
	$app->run();
} else {
	$app = new Applications\Install\InstallApplication;
	$app->run();
}
?>