<?php
if(basename($_SERVER['PHP_SELF']) == "config.php") {
	header("location: ./../index.php");
}
//set root address in baseURL.php

$username = $_SESSION['username'];

//set users
	$admin = array(
		"Anko", "Test123");

	$moderator = array(
		"Test123", "Erwin");

//set data entry document names
	$AllEntry = array(
		"inkoper", "document", "leverancier", "land", "product", "beschikbaarheid");
		// 0		1			2				3		4			5

//set overviews names
	$AllOverview = array(
		"documentoverview", "beschikbaarheidoverview", "landoverview", "levoverview", "prooverview", "inkoverview");
		// 0					1							2				3				4			5
		
//available documententries and overviews for administrator
	if (in_array($username, $admin)){
	$DataEntry=$AllEntry;
	$DocOverview=$AllOverview;
	//enable or disable extern links
	$link="yes";
	}
  
//available documententries and overviews for moderator
	elseif (in_array($username, $moderator)){
	unset($AllEntry[5], $AllOverview[1]);
	$DataEntry=$AllEntry;
	$DocOverview=$AllOverview;
	//enable or disable extern links
	$link="no";
	}
 
//available documententries and overviews for user
	else{
	unset($AllOverview[1], $AllOverview[2], $AllOverview[3], $AllOverview[4], $AllOverview[5]);
	$DataEntry=array("");
	$DocOverview=$AllOverview;
	//enable or disable extern links
	$link="no";
	}

//don't show present data on the following data entry pages
	$nopresent = array('document', 'beschikbaarheid', 'form');
?>