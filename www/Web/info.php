<?php
$start = microtime(true);
require '../Library/autoload.php';
if(file_exists('../Applications/Info/InfoApplication.class.php') && file_exists('../Applications/Info/Config/app.xml')) {
	$app = new Applications\Info\InfoApplication($start);
	$app->run();
} else {
	$app = new Applications\Install\InstallApplication;
	$app->run();
}
?>