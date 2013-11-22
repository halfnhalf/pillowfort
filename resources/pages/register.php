<link rel="stylesheet" type="text/css" href="/resources/css/signin.css">
<?php
ini_set('display_errors', 'On');
require_once $_SERVER['DOCUMENT_ROOT']."/resources/scripts/classes/html_class.php";
$H = new Html();

//output standard template
$H->template($attributes = array('head','logo'));
?>

<div class="container">
<?php $H->generateError("DO NOT ENTER PRIVATE INFORMATION. NOTHING IS ENCRYPTED.");?>
</div>
<?php $H->template($attributes = array('register_page','footer'));?>