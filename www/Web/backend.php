<?php
require '../Library/autoload.php';
if(file_exists('../Applications/Frontend/Config/app.xml')) {
	$app = new Applications\Backend\BackendApplication;
	$app->run();
} else {
	$app = new Applications\Install\InstallApplication;
	$app->run();
}