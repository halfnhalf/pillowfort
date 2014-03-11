<?php
//Created by Zachary Clute
//Functions as the main backend for the html class
class Backend {

	function generateComments($postId) {
	    $comments = $_SERVER['DOCUMENT_ROOT'].'/database/comments/'.$postId[1].'.txt';
	    $content = NULL;
	    $handle = fopen($comments, 'r');
	    while($line = fgets($handle)) {
	        $commentElements = explode('::', $line); //0 = author, 1 = comment 2 = date
	        $content = $content.'<div class="well"><h4>'.$commentElements[0].' on '.$commentElements[2].'</h4><p>'.htmlspecialchars($commentElements[1]).'</p></div>';
	    }
	    return $content;
	}

	function generatePostContent($postId) {
            $content='<div class="panel-heading">
                        <h3 class="panel-title">'.$postId[0].' by '.$postId[4].'</h3></div>';

		$postId[3] = str_replace("\r\n", "", $postId[3]); //shouldn't need to be here because of previous foreach but for somereason that doesn't work
        $content=$content.'<div class="panel-body">
        ';
		switch ($postId[3]) {
			case 'text_area':
				$content = $content.htmlspecialchars($postId[2]);//escape html special characters to prevent xss
				break;
			
			case 'image_link':
				$size = getimagesize("".$postId[2]);
	
				if($size[0] > 800 || $size[1] > 800) //scale the image if it's too big
					$content = $content.'<img src='.$postId[2].' width="70%" height="70%" />';
	
				else
					$content = $content.'<img src="'.$postId[2].'"/>';
	
				break;
            case 'link':
                $content = $content.'<a href="'.$postId[2].'"/>Click Me</a>';
                break;
		}
        $content=$content.'</div>';

	return $content;
	}

	function submitNotice($notice) {
		$notice_file = $_SERVER['DOCUMENT_ROOT'].'/database/notices.txt';		
		$notice = $notice."\r\n".file_get_contents($notice_file);
		file_put_contents($notice_file, $notice);
		header( "refresh:0;url=../" );
		exit();
		}
}
?>