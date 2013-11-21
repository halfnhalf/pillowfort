<?php
 	ini_set('display_errors', 'On');
 	require_once $_SERVER['DOCUMENT_ROOT']."/resources/scripts/classes/html_class.php";
 	$H = new Html();
  	
  	$H->template($attributes = array('head','logo'));

  	if(isset($_SESSION['userLevel'])) {
  		if($H->levelCheck($_SESSION['userLevel']) > 1) 
 			$H->template($attributes = array('admin_page'));

 		else 
 			$H->generateError("You must be an admin to access this page.");
 	}
 	else {
 		echo '<div class="container">'.'';
            $H->generateError("You must be logged in to access this page.");
        echo '</div>'.'';
    }
$H->template($attributes = array('footer'));
?>



