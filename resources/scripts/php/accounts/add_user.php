<?php
	ini_set('display_errors', 'On');
	$accounts = $_SERVER['DOCUMENT_ROOT'].'/database/accounts.txt';
	$handle = fopen($accounts,'a');

	fwrite($handle, "\r\n".htmlspecialchars($_POST["username"])."::".$_POST["password"]."::".$_POST["email"]."::1");

	echo "success";
	header( "refresh:1;url=../../" );
?>