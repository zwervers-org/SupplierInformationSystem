<?php
 $diradd = $address.'/data/add/';
  $contentsadd = scandir($diradd);
    if ($contentsadd) {
		unset ($contentsadd[0] , $contentsadd[1]);	
    }
	echo '<ul>';
    foreach($contentsadd as $k => $v ) {
	
	$pos = strrpos($v, '.');
	$name = substr($v, 0, $pos - 0);
	if (in_array($name, $DataEntry)){
      echo '<li><a href="index.php?page='.$name.'">'.ucfirst($name).'</a></li>';}
	}
        echo "</ul>";
?>