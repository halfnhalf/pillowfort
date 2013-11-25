<?php 
ini_set('display_errors', 'On');
$content = NULL;
if  (preg_match('/^[A-Za-z0-9 _.,!"?]{5,35}$/', $_POST["title"]))  {
    session_start();
	$posts = $_SERVER['DOCUMENT_ROOT'].'/database/posts.txt';
	$handle = fopen($posts, 'a') ;
	$textarea = str_replace("\r\n", "", $_POST["textarea"]);
    $postIdString = substr(MD5(microtime()), 0, 9);
    $author = $_SESSION['userString'];
    $title = $_POST["title"];
    $link = $_POST["link"];

	switch ($link) {
		case NULL:
			fwrite($handle, $title."::".$postIdString."::".$textarea."::text_area::".$author."\r\n");
            $content = 'success!';
			break;

		default:
			if($textarea != NULL) {
				echo "You may only submit data for one field";
				break ;
			}
			fwrite($handle, $title."::".$postIdString."::".$link."::image_link::".$author."\r\n");//currently only supports images
			$content = 'success!';
			break;
	}
	fclose($handle);
    $commentsFile = $_SERVER['DOCUMENT_ROOT'].'/database/comments/'.$postIdString.'.txt';
    file_put_contents($commentsFile, '');
    chmod($commentsFile, 0777);
}

else
	$content = 'invalid input';

header( "refresh:1;url=../../" );
echo $content;
exit();
?>