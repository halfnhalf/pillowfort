<?php
function generatePostContent($postId, $data) {
	if (strcmp($data, $postId[1]) == 0) {
		$content='<title>'.$postId[0].'</title><p>POST: '.$postId[0].'</p>';
		
		$postId[3] = str_replace("\r\n", "", $postId[3]); //shouldn't need to be here because of previous foreach but for somereason that doesn't work
		switch ($postId[3]) {
			case 'text_area':
				$content = $content.'<p>'.htmlspecialchars($postId[2]).'</p>';//escape html special characters to prevent xss
				break;
			
			case 'image_link':
				$size = getimagesize("".$postId[2]);
	
				if($size[0] > 800 || $size[1] > 800) //scale the image if it's too big
					$content = $content.'<img src='.$postId[2].' width="70%" height="70%" />';
	
				else
					$content = $content.'<img src="'.$postId[2].'" />';
	
				break;
		}
	return $content;
	}
}
?>