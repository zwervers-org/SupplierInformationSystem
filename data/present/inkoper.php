<?php

	$selectink = "SELECT * FROM inkoper ORDER BY  inkid ASC";
	$resultink = mysql_query($selectink);
	
echo '
<table align="center">
	<form method="post" action="index.php?page=inkoper&change=yes">
		<tr>	<th colspan=4>
			<h1>Aanwezige inkopers</h1>
		</th>	</tr>
		<tr>	<th>
			Change
		</th>	<th>
			ID
		</th>	<th>
			Naam
		</th>	<th>
			Leverancier - land
		</th>	</tr>';
	
		while ($row = mysql_fetch_array($resultink)) {
	//prepare leverancier selection
			$selectlev = "SELECT levname, landname
						FROM leverancier, landen
						WHERE ('".$row['inkid']."' = leverancier.inkid AND leverancier.landid = landen.landid)
						ORDER BY levname ASC";
			$resultlev = mysql_query($selectlev);
			
	echo '
		<tr>	<td width="50px">
			<center>
				<input type="radio" onchange="this.form.submit()" name="ink_id" required value= ',$row['inkid'],'>
			</center>
		</td>	<td>
			<center>';
				echo $row['inkid'] ;
	echo '
			</center>
		</td>	<td>' ;	
			echo $row['inkname'] ;
	echo '
		</td>	<td class="opsomming">';
			while ($lev = mysql_fetch_array($resultlev)) {		
				echo '<p>';
					echo $lev['levname'].' - '.$lev['landname'];
				echo '</p>';
			}
	echo '
		</td>	</tr>';
	   }
	echo '
	</form>
</table>';	
?>