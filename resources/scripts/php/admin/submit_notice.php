<?php
ini_set('display_errors', 'On');
$notices = $_SERVER['DOCUMENT_ROOT'].'/database/notices.txt';
$handle = fopen($notices, 'a');
$notice = $_POST["textarea"];

fwrite($handle, $notice."\r\n");
fclose($handle);
header( "refresh:0;url=../" );
exit();
?>