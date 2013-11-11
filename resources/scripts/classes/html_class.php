
<?php
/*Created by Zachary Clute
functions as the backend for pillowfort*/
include $_SERVER['DOCUMENT_ROOT'].'/resources/scripts/php/post/posts_page.php';

class Html {

	
	function template($attributes) {
			foreach ($attributes as $type)
				$this->default_output($type);
					
		//echo '</html>';
	}

	function default_output($type) {
		switch ($type) {
			case 'head':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/head_markup.php';
				break;
		
			case 'front_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/front_page_markup.php';
				break;

			case 'post':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/post_markup.php';
				break;

			case 'logo':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/logo_markup.php';
				break;
			case 'register_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/register_markup.php';
				break;

			case 'login_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/login_markup.php';
				break;

			case 'admin_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/admin_markup.php';
		}
		//exit();
	}

	function outputContent($content) {
		echo $this->content;
	}

	function levelCheck($level) {
		//session_start();
		return intval($level);
	}

	function generate($type, $data = NULL, $content = NULL) { //generate dynamic data to be inserted into markup
		//include $_SERVER['DOCUMENT_ROOT'].'/resources/scripts/php/post/posts_page.php';
		$posts = $_SERVER['DOCUMENT_ROOT'].'/database/posts.txt';
		$this->content = NULL;

			$this->content=$this->content.'<body>';
				$this->handle = fopen($posts, 'r'); //access the database
				
				switch ($type) {
					case 'posts':
					case 'posts_page':
						while($line = fgets($this->handle)) {
							$postId = explode('::', $line);
	
							foreach ($postId as $element)
								$element = str_replace("\r\n", "", $element);
	
							switch ($type) {
								case 'posts':
									$this->content = $this->content.'<tr><td><a href="/post/'.$postId[1].'/">'.$postId[0].'</a></td></tr>';
									break;
	
								case 'posts_page':
									$this->content=$this->content.generatePostContent($postId, $data);
									break;
							}
						}
					break;

					case 'account_panel': //i made a change
						if (!isset($_SESSION))
							session_start();

						if (isset ($_SESSION['userString'])) {
							$this->content = '<p id="register-login">'.$_SESSION['userString'];
							$this->content = $this->content.'<form id="register-login" action="/logout/"><input type="submit" value="Logout"></form>';

							switch ($_SESSION['userLevel']) {
								case '2': 
									$this->content = $this->content.'<form id="register-login" action="/admin/"><input type="submit" value="Admin"></form>';
						}
						}

						else
							$this->content = '<form id="register-login" action="/register/"><input type="submit" value="Register"></form><form id="register-login" action="/login/"><input type="submit" value="Login"></form>';

					break;
					}

					$this->content = $this->content.'</body>';
					fclose($this->handle);
					return $this->content;	
	}
}
?>
