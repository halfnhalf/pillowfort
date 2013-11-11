<?php
 	ini_set('display_errors', 'On');
 	require_once $_SERVER['DOCUMENT_ROOT']."/resources/scripts/classes/html_class.php";
 	$H = new Html();
  
  	//output standard template
 	$H->template($attributes = array('head','logo','register_page'));
?>