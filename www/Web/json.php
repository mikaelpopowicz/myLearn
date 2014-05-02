<?php
$start = microtime(true);
//echo "<script>alert('Coucou'),</script>";
require '../Library/autoload.php';
if(file_exists('../Applications/Json/JsonApplication.class.php') && file_exists('../Applications/Json/Config/app.xml')) {
	$app = new Applications\Json\JsonApplication($start);
	$app->run();
} else {
	$app = new Applications\Install\InstallApplication($start);
	$app->run();
}
?>