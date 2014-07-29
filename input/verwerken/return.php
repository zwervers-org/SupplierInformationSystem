<?php

$result = $_GET[result];
$koppeling = $_GET[koppeling];

if($koppeling AND $result == "1"){
	
	header("Location: ./../index.php?error=0"); /* Redirect browser */
}
else if($koppeling AND $result == ""){
	header("Location: ./../index.php?error=1");
}
else if($koppeling AND $result > "1"){
	header("Location: ./../index.php?error=2");
}
else{
	header("Location: ./../index.php?error=3");	
}

?>
