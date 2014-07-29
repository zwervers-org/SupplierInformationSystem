<?php
if(basename($_SERVER['PHP_SELF']) == "include.php") {
	header("location: ./../index.php");
}

include($address.'/script/functions.php');

include ($address.'/admin/db_connect.php');

include($address.'/script/error.php');

?>
