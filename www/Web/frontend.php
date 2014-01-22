<?php
require '../Library/autoload.php';
if(file_exists('../Applications/Frontend/Config/app.xml')) {
	$app = new Applications\Frontend\FrontendApplication;
	if($app->config()->get('installed') == 'true' || $app->user()->getAttribute('step1') == NULL || $app->user()->getAttribute('step2') == NULL || $app->user()->getAttribute('step3') == NULL) {
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