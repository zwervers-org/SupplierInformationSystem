<?php
echo '<div id="formframe">';
	if (isset($_GET['action'])){
	//is there a result of change/del/add
	echo '<div id=action>';
	include("action.php");
	echo'</div>';
	}

	// list of diverent formtypes
	echo '<div id="formlist">';
	if (!in_array($_GET['page'], $nopresent)){
		if (in_array($username, $admin) or in_array($username, $moderator)){
			echo'<h1 class="click" onclick="return showHide(present);">Display existing data</h1>';
	}}	
	echo '<h1>Available forms</h1>';
	include($address.'/template/formlist.php');
	echo '</div>';

	//select the right data entry form
	if (isset($_GET['change'])) {
		if ($_GET['change'] = "yes") {
			
			//change data entry form
			echo '<div id="change">';
			include('./data/change/'.$_GET['page'].'.php');
			echo '</div>';
		}
	}
	else{
		//add data entry form
		echo '<div id="add">';
		if ($_GET['page'] !== 'form'){
		include($address.'/data/add/'.$_GET['page'].'.php');
		echo '</div>';
	}
	//present entry data
			echo '<div id="present" style="display:none;">';
			include($address.'/data/present/'.$_GET['page'].'.php');}
			echo '</div>';
echo '</div>';