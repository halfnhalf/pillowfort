<?php
ini_set('display_errors', 'On');
require_once $_SERVER['DOCUMENT_ROOT']."/resources/scripts/classes/html_class.php";
$H = new Html();

if($_SERVER['HTTP_REFERER'] eq "andrewcarnes.com")
	header("Location: http://www.reddit.com");
//output standard template
$H->template($attributes = array('head','logo','front_page','footer'));
?>