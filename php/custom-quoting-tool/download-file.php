<?php
session_start();
require_once "assets/authcookiesessionvalidate.php";
if(!$isLoggedIn) {
    header("Location: /login/");
} else {
	$path = urldecode($_GET["file"]);
	$name = preg_replace("/[^a-z0-9\_\-\.]/i", '', urldecode($_GET["name"]));
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$name);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($path));
	ob_clean();
	flush();
	readfile($path);
	exit;
}
?>