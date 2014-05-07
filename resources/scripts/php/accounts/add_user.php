<?php
ini_set('display_errors', 'On');
$accounts = $_SERVER['DOCUMENT_ROOT'].'/database/accounts.txt';
$handle = fopen($accounts,'a');
$username = $_POST["username"];
if  (preg_match('/^[A-Za-z0-9 _.,!"?]{1,15}$/', $username)) {
    while($line = fgets($handle)) {
        $credentials = explode('::', $line);
        echo $credentials[0].' '.$username;
        if(strcmp($credentials[0], $username) == 0) {
            echo "Username already exists";
            leave();
        }
    }
    fwrite($handle, "\r\n".htmlspecialchars($_POST["username"])."::".$_POST["password"]."::".$_POST["email"]."::1");
    echo "success";

    leave();
}
echo "Registration failed";
leave();

function leave() {
    header( "refresh:1;url=../../" );
    global $handle;
    fclose($handle);
    exit();
}
return;
?>