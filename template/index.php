<?php 

echo'<div id="kop">';

include($address."/template/header.php");
	
 echo '</div>

  <div id="menuframe">';
	
include($address."/template/menu.php");

  echo '</div>

<div id="body">';

include ($address.'/script/error_verwerken.php');

include($bodypage);

echo '</div>

<div id="voet">
	&copy; 2013 Zwervers.org</div>

</div>';


