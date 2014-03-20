<?php
require '../Library/autoload.php';
if(file_exists('../Applications/Admin/AdminApplication.class.php')) {
	$app = new Applications\Admin\AdminApplication;
	$app->run();
} else {
	$app = new Applications\Install\InstallApplication;
	$app->run();
}
?>