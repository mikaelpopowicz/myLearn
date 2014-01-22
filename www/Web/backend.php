<?php
require '../Library/autoload.php';
if(file_exists('../Applications/Frontend/Config/app.xml')) {
	$app = new Applications\Backend\BackendApplication;
	if($app->config()->get('installed') == 'true') {
		$app->run();
	} else {
		$app = NULL;
		$app = new Applications\Install\InstallApplication;
		$app->run();
	}
} else {
	$app = new Applications\Install\InstallApplication;
	$app->run();
}
?>