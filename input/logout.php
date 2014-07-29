<?php
//if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
	//session_start();
//}
//else {
//	sec_session_start();
//}
// Unset all session values
//$_SESSION = array();
// get session parameters 
//$params = session_get_cookie_params();
// Delete the actual cookie.
//setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

// Destroy session
session_destroy();
exit('logout stop');

echo '<meta http-equiv="refresh" content="0;URL=./index.php">';

?>