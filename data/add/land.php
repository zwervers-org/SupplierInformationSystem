<?php

//add data to sql
if (isset($_POST['land_name'])){
//inserting data in landen
$query = "INSERT INTO landen 
			(landid, landname)
			VALUES
			('$_POST[land_id]', '$_POST[land_name]')";
//declare in the order variable
$send = mysql_query($query);	//order executes


if ($send == false) {
    echo 'query: '.$query.' | resultaat: '.$send;
	echo showSQLError($query,mysql_error(),'Fout met database.');
}

else {
	//echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action=add">';
}
}

//show the table to add new data
else {
show:
	echo '<table>
	<tr>	<th colspan="2">
		<h1>'.ucfirst($_GET['page']).' toevoegen</h1>
	</th>	</tr>
		<form action="index.php?page='.$_GET['page'].'" method="post">
			<tr>	<th>
				Land ID
			</th>	<td>
				<input type="text" name="land_id" maxlength="2" required>	 Voorbeeld: NL (<a href="http://nl.wikipedia.org/wiki/ISO_3166-1#ISO-landcodes" target="_blank">ISO 3166-1</a>) 
			</td>	</tr>
			<tr>	<th>
				Land
			</th>	<td>
				<input type="text" name="land_name" size="40" required>
			</td>	</tr>
			<tr>	<td colspan="2">
				<right>
			<input type="submit" name="landen" value="Toevoegen">
				</right>
			</td>	</tr>
		</form>
	</table>';
	}
?>