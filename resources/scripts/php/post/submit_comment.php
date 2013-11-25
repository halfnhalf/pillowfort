<?php
ini_set('display_errors', 'On');
session_start();

$content = NULL;
$author = $_SESSION['userString'];
$id = $_POST['id'];
$comment = $_POST['textarea'];
$comment = str_replace("\r\n", "", $comment);
$commentFile = $_SERVER['DOCUMENT_ROOT'].'/database/comments/'.$id.'.txt';
$handle = fopen($commentFile, 'a') ;

if  (strlen($comment) < 500) {
    fwrite($handle, $author."::".$comment."\r\n");
    fclose($handle);
}
header( "refresh:0;url=../" );
exit();
?>