<?php
ini_set('display_errors', 'On');
session_start();

$content = NULL;

if(isset($_SESSION['userString']))
    $author = $_SESSION['userString'];
else {
    echo "You must be logged in to comment";
    header( "refresh:2;url=../../" );
    exit();
}
$id = $_POST['id'];
$comment = str_replace("\r\n", "", $_POST['textarea']);
$commentFile = $_SERVER['DOCUMENT_ROOT'].'/database/comments/'.$id.'.txt';

if  (strlen($comment) < 500) {
    $comment = $author."::".$comment."\r\n".file_get_contents($commentFile);
    file_put_contents($commentFile, $comment);
}
header( "refresh:0;url=../" );
exit();
?>