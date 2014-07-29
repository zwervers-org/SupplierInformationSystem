<?php
//execute the form
if (isset($_GET['del'])){
	if ($_GET['del'] == 'no'){
	$action = 'change';
	$query = "UPDATE landen SET landid = '".$_POST['land_id']."', landname = '".$_POST['land_name']."' WHERE landid = '".$_POST['landid_old']."'";
	$send = mysql_query($query);
	}
	
	else {
	$action = 'del';
	$query = "DELETE FROM landen WHERE landid = '" .$_POST['land_id']. "'";
	$send = mysql_query($query);
	}
	
if ($send == false){
		echo showSQLError($query,mysql_error(),'Fout met database.');}
else{
	echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action='.$action.'">';}
}

//change the information
else{

	$query = "SELECT * FROM landen WHERE landid = '" .$_POST['land_id']. "'";
	$send = mysql_query($query);
	
	while ($get = mysql_fetch_array($send)){
		
	echo '
	<table align="center">
			<tr>
				<th colspan=2><h1>'.ucfirst($_GET['page']).' wijzigen</h1></th>
			</tr>	
        <form action="index.php?page='.$_GET['page'].'&change=yes&del=no method="post" name="'.$_GET['page'].'change">
			<tr>
				<th>ID</th>
				<td><input type="text" name="land_id" maxlength="2" required value="'.$get['landid'].'">
				<input type="hidden" name="landid_old" value="'.$get['landid'].'"></td>
			</tr>
			<tr>
				<th>Naam</th>
				<td><input type="text" name="land_name" required value="'.$get['landname'].'" required>
			</tr>
			<tr>
				<td></td>
				<td>
					<button align="right" formmethod="post" type="submit" formaction=./index.php?page='.$_GET['page'].'&change=yes&del=no>
						Wijzigen</button>
					<button align="center" formmethod="post" type="submit" formaction=./index.php?page='.$_GET['page'].'&change=yes&del=yes>
						Verwijderen</button>
				</td>
			</tr>
		</form>
	</table>';
	}
}
?>