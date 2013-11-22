<?php
	ini_set('display_errors', 'On');

	if(isset($_POST['type']) && (isset($_POST['username']) || isset($_POST['id']))) {
		if(isset($_POST['username']))
			$username = $_POST['username'];

		else if(isset($_POST['id']))
			$id = $_POST['id'];

		$type = $_POST['type'];
	}

	else {
		header('Location:/404');
		exit();
	}
    echo $type;
	$accounts = $_SERVER['DOCUMENT_ROOT'].'/database/accounts.txt';
	$posts = $_SERVER['DOCUMENT_ROOT'].'/database/posts.txt';
	$temp = $_SERVER['DOCUMENT_ROOT'].'/database/temp_posts.txt';
	$temp_handle = fopen($temp, 'a');
	$handle = NULL;

	switch ($type) {
		case 'posts':
			$handle = fopen($posts, 'r');
			break;

		case 'accounts':
			$handle = fopen($accounts, 'r');
			break;
	}


	while($line = fgets($handle)) {
		$postId = explode('::', $line);//[0] = title, [1] = id, [2] = link, [3] = type, [4] = hidden
        foreach ($postId as $element)
            $element = str_replace("\r\n", "", $element);

        switch ($type) {
            case 'posts':
		        if (strcmp($id , $postId[1]) != 0)
			        fwrite($temp_handle, $line);
            break;
            case 'accounts':
                if (strcmp($id, $postId[0]) != 0)
                    fwrite($temp_handle, $line);
            break;
        }

	}

	switch ($type) {
		case 'posts':
			unlink($posts);
			rename($temp, $_SERVER['DOCUMENT_ROOT'].'/database/posts.txt');
			break;
		
		case 'accounts':
			unlink($accounts);
			rename($temp, $_SERVER['DOCUMENT_ROOT'].'/database/accounts.txt');
			break;
	}
	echo "success";
	file_put_contents($temp, '');
	chmod($temp, 0777);
	header( "refresh:0;url=../" );
?>