
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
                break;

            case 'footer':
                include $_SERVER['DOCUMENT_ROOT'].'/resources/markup/footer_markup.html';
                break;
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

	function isLoggedIn() {
		if (isset($_SESSION['userString']))
			return true;
		return false;
	}

    function generateError($message) {
        $this->content = '<div class="alert alert-danger" id="warningMessage">'.$message.'</div>';
        $this->outputContent($this->content);
    }

	function generate($type, $data = NULL, $content = NULL) { //generate dynamic data to be inserted into markup
		$registerLoginButtons = $_SERVER['DOCUMENT_ROOT'].'/resources/markup/account_panel/register_login.html';
		$adminLogoutButtons = $_SERVER['DOCUMENT_ROOT'].'/resources/markup/account_panel/admin_logout.html';
		$accountLogoutButtons = $_SERVER['DOCUMENT_ROOT'].'/resources/markup/account_panel/account_logout.html';
		$posts = $_SERVER['DOCUMENT_ROOT'].'/database/posts.txt';

		$this->content = NULL;				
		switch ($type) {
			case 'posts':
			case 'posts_page':
			case 'posts_admin':
				$this->handle = fopen($posts, 'r');
				while($line = fgets($this->handle)) {
					$postId = explode('::', $line); //[0] = title, [1] = id, [2] = link, [3] = type, [4] = hidden
					foreach ($postId as $element)
						$element = str_replace("\r\n", "", $element);

					switch ($type) {
						case 'posts':
							if(!isset($postId[4]))
								$this->content = $this->content.'<a href="/post/'.$postId[1].'/" class="list-group-item"><h4 class="list-group-item-heading">'.$postId[0].'</h4><p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></a>';
							break;

						case 'posts_admin':
							$this->content = $this->content.'<a href="/post/'.$postId[1].'/" class="list-group-item"><h4 class="list-group-item-heading">'.$postId[0].'</h4><p class="list-group-item-text"><form id="submit" action="/admin/remove/" method="post"><input type="hidden" name="id" value='.$postId[1].'><input type="hidden" name="type" value="posts"><button type="submit" class="btn btn-default btn-xs">Remove</button></form></p></a>';
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

				if (isset ($_SESSION['userString'])) {
					$this->content = '<body>'.$_SESSION['userString'].'</body>';
					switch ($_SESSION['userLevel']) {
						case '2': //user is an admin
							$this->content = $this->content.file_get_contents($adminLogoutButtons);
							break;

						case '1':
							$this->content = $this->content.file_get_contents($accountLogoutButtons);
							break;
					}
				}
				else //no one is logged in
					$this->content = $this->content.file_get_contents($registerLoginButtons);
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
		exit();	
	}
}
?>
