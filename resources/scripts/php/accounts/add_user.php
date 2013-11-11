<?php
	ini_set('display_errors', 'On');
	$accounts = $_SERVER['DOCUMENT_ROOT'].'/database/accounts.txt';
	$handle = fopen($accounts,'a');

	fwrite($handle, "\r\n".htmlspecialchars($_POST["username"])."::".$_POST["password"]."::".$_POST["email"]);

	echo "success";
	header('Location:'.$_SERVER['HTTP_REFERER']);
?>