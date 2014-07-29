<?php
if(basename($_SERVER['PHP_SELF']) == "baseURL.php") {
	header("location: ./../index.php");
}

//set document root
	$address = $_SERVER['DOCUMENT_ROOT'].'/New';

?>
