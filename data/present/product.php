<?php
	
$selectpro = "SELECT * 
				FROM product 
				ORDER BY proname ASC";
$resultpro = mysql_query($selectpro);
	
	echo '
<table align="center">
	<form method="POST" action="index.php?page=product&change=yes">
		<tr>	<th colspan=3>
			<h1>Aanwezige producten</h1>
		</th>	</tr>
			Change
		<tr>	<th>
		</th>	<th>
			Naam
		</th>	<th>
			Leveranciers
		</th>	</tr>';
		
		while ($row = mysql_fetch_array($resultpro)) {
	//prepare leverancier selection
			$selectlev = "SELECT levname
						FROM leverancier
						JOIN product ON '".$row['proid']."' = product.proid 
						JOIN levpro	ON product.proid = levpro.proid 
							AND levpro.levid = leverancier.levid
						ORDER BY levname ASC";
			$resultlev = mysql_query($selectlev);
			
echo '
		<tr>	<td id="present" class="change">
				<input type="radio" onchange="this.form.submit()" name="pro_id" required value= '.$row['proid'].'>
		</td>	';
		#if $row['proart'] = true {
		#echo '<td id="present" colspan=2>';
		#	echo $row['proname'];
		#}
		#else {
		echo '<td id="present">';
			echo $row['proname'];
		
		echo '</td><td id="present"><table>';
			while ($lev = mysql_fetch_array($resultlev)) {	
				echo '<tr><td class="opsomming">';
					echo $lev['levname'] ;
				echo '</td></tr>';
			}
		#}
echo '</table></td></tr>';
	}
echo '
	</form>
</table>';
?>