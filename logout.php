<?php
function sec_session_start() {
        $session_name = 'otc-organics-session'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id.
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(true); // regenerated the session, delete the old one.     
}

if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
	session_start();
}
else {
	sec_session_start();
}
// Unset all session values
$_SESSION = array();
// get session parameters 
$params = session_get_cookie_params();
// Delete the actual cookie.
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// unset cookies
if (isset($_COOKIE['user_id'], $_COOKIE['login_string'])) {
        unset($_COOKIE['user_id']);
		unset($_COOKIE['login_string']);
		
		setcookie('user_id', "", -3600, '/', $_SERVER['SERVER_NAME'], false, true);
        setcookie('login_string', "", -3600, '/', $_SERVER['SERVER_NAME'], false, true);
	//echo '<SCRIPT LANGUAGE="JavaScript">window.alert('.$_COOKIE['user_id'].'"<id-string>"'.$_COOKIE['login_string'].')</SCRIPT>';
}

// Destroy session
session_destroy();
//exit('logout stop');

echo '<meta http-equiv="refresh" content="0;URL=./index.php">';

?>