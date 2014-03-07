<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/resources/scripts/classes/html_class.php';
	ini_set('display_errors', 'On');
    session_start();
    $H = new Html();

	if($H->levelCheck($_SESSION["userLevel"]) > 1) {
		if(isset($_POST['username']))
			$username = $_POST['username'];

		else if(isset($_POST['id']))
			$id = $_POST['id'];

		else if(isset($_POST['notice']))
			$notice = $_POST['notice'];

		$type = $_POST['type'];
	}

	else {
		header('Location:/404');
		exit();
	}
    echo $type;
	$accounts = $_SERVER['DOCUMENT_ROOT'].'/database/accounts.txt';
	$posts = $_SERVER['DOCUMENT_ROOT'].'/database/posts.txt';
    $notices = $_SERVER['DOCUMENT_ROOT'].'/database/notices.txt';
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

        case 'notices':
            $handle = fopen($notices, 'r');
            break;
	}


	while($line = fgets($handle)) {
		$elementId = explode('::', $line);//[0] = title, [1] = id, [2] = link, [3] = type, [4] = hidden; user::pass::email::level
        /*foreach ($elementId as $element)
            $element = str_replace("\r\n", "", $element);
        $elementId[0] = str_replace("\r\n", "", $elementId[0]);*/

        switch($type) {
            case 'posts':
                if (strcmp($id , $elementId[1]) != 0)
    	            fwrite($temp_handle, $line);
                break;
            case 'accounts':
                if (strcmp($username , $elementId[0]) != 0)
                    fwrite($temp_handle, $line);
                break;
            case 'notices':
                if (strcmp($line , $notice) != 0)
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

        case 'notices':
            unlink($notices);
            rename($temp, $_SERVER['DOCUMENT_ROOT'].'/database/notices.txt');
            break;
	}
    //unlink($_SERVER['DOCUMENT_ROOT'].'/database/comments/'.$id.'.txt');
	echo "success";
	file_put_contents($temp, '');
	chmod($temp, 0777);
	header( "refresh:0;url=../" );
?>