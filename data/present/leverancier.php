<?php
	$selectlev = 	"SELECT * 
					FROM leverancier
					LEFT JOIN landen ON leverancier.landid = landen.landid
					LEFT JOIN inkoper ON leverancier.inkid = inkoper.inkid
					ORDER BY levname ASC";
	$resultlev = mysql_query($selectlev);
	
echo '
<table align="center">
	<form method="post" action="index.php?page=leverancier&change=yes">
		<tr>	<th colspan=5>
			<h1>Aanwezige leveranciers:</h1>
		</th>	</tr>
		<tr>	<th>
			Change
		</th>	<th>
			Naam
		</th>	<th>
			Inkoper
		</th>	<th colspan="2">
			Land
		</th>	</tr>';
	
			while ($row = mysql_fetch_array($resultlev)) {
		echo '
				<tr>	<td>
					<center>
						<input type="radio" onchange="this.form.submit()" name="lev_id" required value= ',$row['levid'], '>
					</center>
				</td>	<td>';
					echo $row['levname'] ;
			echo '
				</td>	<td>' ;
					echo $row['inkname'] ;
			echo '
				</td>	<td>';
					echo $row['landid'] ;
			echo '
				</td>	<td>';
					echo $row['landname'] ;
			echo '
				</td>	</tr>';
			}
echo '
	</form>
</table>';
?>

