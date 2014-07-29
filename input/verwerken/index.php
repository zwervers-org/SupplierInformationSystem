<?php

include ('./admin/include.php');

if (!isset($_SESSION)){

	$bodypage = $address."/input/login.php";
}

else {
	
		$username = $_SESSION['username'];

		$welkom = "Welkom ". $username;
		
	
	if (!empty($_GET)){
		
		if (isset($_GET['error'])){
			
			if ($_SERVER['QUERY_STRING'] == "error=".$_GET['error']){
	
				$bodypage = $address."/views/documentoverzicht.php";
			}
			
			else {
				
				$bodypage = $address."/views/documentoverzicht.php";
			}
		}
		
		elseif (in_array($_GET['page'], $DataEntry)) {		
		$bodypage= $address.'/template/form.php';
		}
		
		else {
		$bodypage= $address.'/input/'.$_GET['page'].'.php';
		}
	}
	
	else {	
			$bodypage = $address."/views/documentoverzicht.php";
			}

}

if (isset($_GET['error'])){
	if ($_GET['error'] == "0"){
			$title = 'Error logging in';
		}
	Else {
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
		}
	}
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

echo '<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<meta name="keywords" content="OTC-organics, otc, overzicht, documenten, leverancier" />

	<meta name="description" content="OTC overzichten" />

	<link rel="stylesheet" href="./template/basis.css" type="text/css">
		
	<title>'.$title.'</title>
	
	<script type="text/javascript" src="./script/forms.js"></script>
	
	</head>';

echo '<body>

  <div id="kader">';
  
  include ("./template/index.php");

  echo'</div>

</body>

</html>';

?>