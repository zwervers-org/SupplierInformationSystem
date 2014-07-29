<?php

if(!isset($_POST['email'])){
if (basename($_SERVER['PHP_SELF']) == "login.php") {
	header("location: ./../../index.php");
}}

include './include.php';

if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
//echo 'IE select';
session_start();
}
else{
sec_session_start(); // Our custom secure way of starting a php session. 
}

if (!isset($_POST['remember'])){
$remember = "no";
}

else{
$remember = $_POST['remember'];
}

if(isset($_POST['email'], $_POST['p'])) { 
   $email = $_POST['email'];
   $password = $_POST['p']; // The hashed password.
   
	if(login($email, $password, $remember, $sec_login) !== true) {    
		// Login failed
		$return = login($email, $password, $remember, $sec_login);
		switch ($return){
			case 1:
			//echo '<script>alert("'.$email.' is locked")</script>';
			echo '<meta http-equiv="refresh" content="0;URL=./../../index.php?page=inlog&LogInError=1">';
			break;
			
			case 2:
			//echo '<script>alert("'.$email.' has an other password")</script>';
			echo '<meta http-equiv="refresh" content="0;URL=./../../index.php?page=inlog&LogInError=2">';
			break;
			
			case 3:
			//echo '<script>alert("'.$email.' not exists")</script>';
			echo '<meta http-equiv="refresh" content="0;URL=./../../index.php?page=inlog&LogInError=3">';
			break;
		}
		//echo '<meta http-equiv="refresh" content="0;URL=./../../index.php?page=inlog">';
	}
	
   else {
		// Login success
		$username = $_SESSION['username'];
	   //echo '<script>alert("Welkom: ', $username ,'")</script>';
	   echo '<meta http-equiv="refresh" content="0;URL=./../../index.php">';
   }
} 

else { 
   // The correct POST variables were not sent to this page.
   //echo 'incorrect request';
   echo '<meta http-equiv="refresh" content="0;URL=./../../index.php?page=inlog&LogInError=L0">';
}
?>