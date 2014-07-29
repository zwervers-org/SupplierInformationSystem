<?php

//add data to sql
if (isset($_POST['ink_name'])){
//inserting data in inkoper
$ordernew = "INSERT INTO inkoper 
			(inkname)
			VALUES
			('$_POST[ink_name]')";

//declare in the order variable
$resultnew = mysql_query($ordernew);	//order executes

if ($resultnew == false) 
{
    echo showSQLError($ordernew,mysql_error(),'Fout met database.');
}

else {
	echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action=add">';
}
}

//Show table to at or change
else {
show:
	echo '<table align="center">
	<tr>	<th colspan=2>
		<h1>'.ucfirst($_GET['page']).' toevoegen</h1>
	</th>  	</tr>
        <form action="index.php?page='.$_GET['page'].'" method="post" name="'.$_GET['page'].'add">
	<tr>	<th>
		Naam
	</th>	<td>
		<input type="text" name="ink_name" size="40" required>
	</td>	</tr>
	<tr>	<td colspan=2>
		<right>
			<input type="Submit" value="Toevoegen">
		</right>
	</td>	</tr>
	</form>
	</table>';
}
?>