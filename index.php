<?php
	include('./admin/baseURL.php');
	include ($address.'/admin/include.php');

if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {

session_start();
}

else {
sec_session_start();
}

//if (!isset($_SESSION['username']) OR !isset($_COOKIE['username'])){
if (login_check($sec_login) == false) {
	
	$bodypage = $address."/input/login.php";
	$title = "Login";
	//echo '<SCRIPT LANGUAGE="JavaScript">window.alert("Session is NOT set")</SCRIPT>';
}

else {
	include ($address.'/admin/config.php');
		$welkom = "Welkom ". $username;
		
	//set body
	if (!empty($_GET)){
		
		if (isset($_GET['error'])){
			
			if ($_SERVER['QUERY_STRING'] == "error=".$_GET['error']){
	
				$bodypage = $address."/views/documentoverview.php";
			}
		}
		elseif ($_GET['page'] == 'form'){
		$bodypage= $address.'/template/form.php';}
		
		elseif (in_array($_GET['page'], $AllEntry)) {		
		$bodypage= $address.'/template/form.php';}
		
		elseif (in_array($_GET['page'], $AllOverview)){
		$bodypage= $address.'/views/'.$_GET['page'].'.php';}
		
		else {
		$bodypage= $address.'/input/'.$_GET['page'].'.php';}
	}
	
	else {	
			$bodypage = $address."/views/documentoverview.php";
	}

	//set title
	if (isset($_GET['error'])){
		if ($_GET['error'] == "0"){
				$title = 'Error logging in';
		}
		else {
			$title =  $_GET['error'];
		}
	}
	elseif (isset($_GET['page'])){
		if (in_array($_GET['page'], $DataEntry)){
			if (isset($_POST['change'])){
				$title = ucfirst($_GET['page'].' wijzigen');
			}
			else { 
				$title =  ucfirst($_GET['page'].' toevoegen');
		}}
		else {
			switch ($_GET['page']){
			case 'forgot':
				$title = "Forgot password";
				break;
			default:
				$title =  ucfirst($_GET['page']);
				break;
		}}
	}
	elseif ($_SERVER['QUERY_STRING'] == ""){
		$title = 'Home page';
	}
	else{
			$pos = strrpos($_SERVER['QUERY_STRING'], '&');
			$DelGet = substr($_SERVER['QUERY_STRING'], 0, $pos - 0);
			if ($DelGet == ""){
			$name = $_SERVER['QUERY_STRING'];
			}
			else{ 
				$name = $DelGet;
			}
			$title =  ucfirst($name);
	} 
}
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
echo '<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<meta name="keywords" content="OTC-organics, otc, overzicht, documenten, leverancier" />

	<meta name="description" content="OTC overzichten" />

	<link rel="stylesheet" href="./template/body.css" type="text/css">
	<link rel="stylesheet" href="./template/menu.css" type="text/css">	
		
	<title>'.$title.'</title>
	
	<script type="text/javascript" src="./script/forms.js"></script>
	<script type="text/javascript" src="./script/sha512.js"></script>
	
	</head>';

echo '<body>

  <div id="kader">';
  
  include ("./template/index.php");

  echo'</div>

</body>

</html>';

?>