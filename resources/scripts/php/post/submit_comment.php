<?php
ini_set('display_errors', 'On');
$content = NULL;
$author = $_POST['author'];
$id = $_POST['id'];
$comment = $_POST['textarea'];
$commentFile = $_SERVER['DOCUMENT_ROOT'].'/database/comments/'.$id.'.txt';
$handle = fopen($commentFile, 'a') ;
$comment = str_replace("\r\n", "", $comment);

if  (strlen($comment) < 500) {
    fwrite($handle, $author."::".$comment."\r\n");
    fclose($handle);
}
header( "refresh:0;url=../" );
exit();
?>