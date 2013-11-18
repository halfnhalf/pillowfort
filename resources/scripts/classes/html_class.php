
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
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/head_markup.html';
				break;
		
			case 'front_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/front_page_markup.html';
				break;

			case 'post':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/post_markup.html';
				break;

			case 'logo':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/logo_markup.html';
				break;
			case 'register_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/register_markup.html';
				break;

			case 'login_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/login_markup.html';
				break;

			case 'admin_page':
				include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/admin_markup.html';
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
		$this->content = NULL;

			$this->content=$this->content.'<body>';
				
				switch ($type) {
					case 'posts':
					case 'posts_page':
					case 'posts_admin':
						$posts = $_SERVER['DOCUMENT_ROOT'].'/database/posts.txt';
						$this->handle = fopen($posts, 'r');

						while($line = fgets($this->handle)) {
							$postId = explode('::', $line); //[0] = title, [1] = id, [2] = link, [3] = type, [4] = hidden
	
							foreach ($postId as $element)
								$element = str_replace("\r\n", "", $element);
	
							switch ($type) {
								case 'posts':
									if(!isset($postId[4]))
										$this->content = $this->content.'<tr><td><a href="/post/'.$postId[1].'/">'.$postId[0].'</a></td></tr>';
									break;

								case 'posts_admin':
									$this->content = $this->content.'<tr><td><a href="/post/'.$postId[1].'/">'.$postId[0].'</a><form id="submit" action="/admin/remove/" method="post"><input type="hidden" name="id" value='.$postId[1].'><input type="hidden" name="type" value="posts"><input type="submit" name="submit" value="Remove"></form></td></tr>';
									break;
	
								case 'posts_page':
									$this->content=$this->content.generatePostContent($postId, $data);
									break;
							}
						}
						fclose($this->handle);
						break;

					case 'account_panel':
						if (!isset($_SESSION))
							session_start();

						$this->handle = fopen($_SERVER['DOCUMENT_ROOT'].'/resources/markup/account_panel/assets.html', 'r');
						while($assets[] = fgets($this->handle)) {}
						fclose($this->handle);

						/****************************************/
						/* assets[0] = logoutButton
						/* assets[1] = register and login buttons
						/* assets[2] = admin button
						/* assets[3] = account button
						/****************************************/

						if (isset ($_SESSION['userString'])) {
							$this->content = '<p id="accountPanel">'.$_SESSION['userString'].'</p>';
							$this->content = $this->content.$assets[0];

							switch ($_SESSION['userLevel']) {
								case '2': 
									$this->content = $this->content.$assets[2];
									break;

								case '1':
									$this->content = $this->content.$assets[3];
									break;
							}
						}

						else //no one is logged in
							$this->content = $assets[1];

					break;

					case 'accounts': //list the accounts with admin options to remove
						$accounts = $_SERVER['DOCUMENT_ROOT'].'/database/accounts.txt';
						$this->handle = fopen($accounts, 'r');

						while($line = fgets($this->handle)) {
							$credentials = explode('::', $line);

							foreach ($credentials as $element)
								$element = str_replace("\r\n", "", $element);

							$this->content = $this->content.'<tr><td>'.$credentials[0].'<form action="/admin/remove/" method="post"><input type="hidden" name="username" value='.$credentials[0].'><input type="hidden" name="type" value="accounts"><input type="submit" name="submit" value="Remove"></form>'.'</td></tr>';
					}

					break;
				}

					//$this->content = $this->content.'</body>';
					return $this->content;	
	}
}
?>
