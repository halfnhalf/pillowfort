<?php
 	ini_set('display_errors', 'On');
 	require_once $_SERVER['DOCUMENT_ROOT']."/resources/scripts/classes/html_class.php";
 	$H = new Html();
  	
  	$H->template($attributes = array('head','logo'));

  	if(isset($_SESSION['userLevel'])) {
  		if($H->levelCheck($_SESSION['userLevel']) > 1) 
 			$H->template($attributes = array('admin_page'));

 		else 
 			echo "You must be an admin to access this page.";
 	}
 	else
 		echo "Please Log In"

?>
