<?php
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
?>