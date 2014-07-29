<?php
	$selectland = "SELECT *
					FROM landen
					ORDER BY landname ASC"; 
	$resultland = mysql_query($selectland);
	
	//Aanwezige landen
echo'<table align="center">
		<form method="post" action="index.php?page='.$_GET['page'].'&change=yes">
  <tr>
<th colspan=4><h1>Aanwezige landen</h1></th>
	</tr>
		<tr><th>Change</th><th>ID</th><th>Land</th><th>Leveranciers</th></tr>';

	while ($row = mysql_fetch_array($resultland)) {
		$selectlev = "SELECT levname
					FROM leverancier
					JOIN landen 
						ON leverancier.landid = '".$row['landid']."' AND leverancier.landid = landen.landid
					ORDER BY levname ASC";
	$resultlev = mysql_query($selectlev);
		
		echo '<tr><td id="present" class="change">
			<input type="radio" onchange="this.form.submit()" name="land_id" required value= ',$row['landid'], '>
			</td>';
    echo '<td id="present">';
		
    	echo $row['landid'] ;
	echo '</td><td id="present">' ;
		
		echo $row['landname'] ;
	echo '</td><td id="present"><table>';
		
		while ($lev = mysql_fetch_array($resultlev)) {	
		echo '<tr><td class="opsomming">';
			echo $lev['levname'] ;
		echo '</td></tr>';
		}
	echo '</table></td></tr>';
   }
  echo '</table></form>';

?>