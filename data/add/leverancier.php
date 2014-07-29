<?php

//add data to sql
if (isset($_POST['lev_name'])){
//check if supplier exists
$query1 = "SELECT * FROM leverancier 
			WHERE levname = '".$_POST['lev_name']."'";

//declare in the order variable
$check = mysql_num_rows(mysql_query($query1));

if ($check){
//update information
	$action = 'change';
	$query = "UPDATE leverancier SET inkid = '".$_POST['ink_id']."',
		landid = '".$_POST['land_id']."'
		WHERE levname = '".$_POST['lev_name']."'";
	$send = mysql_query($query);
	
	
	$levid = mysql_fetch_array(mysql_query($query1));
	$levid = $levid['levid'];
	
	//clear connection table
	$querylp = "DELETE FROM levpro WHERE levid = '".$levid."'";
	$sendlp = mysql_query($querylp);
	
	//put data in connection table
	$apro_id = $_POST['pro_id'];

	$i = count($apro_id)-1;

		while ($i >= 0) {

			$pro_id = $apro_id[$i];
	echo 'product id = '.$pro_id;
			$query = "INSERT INTO levpro (levid, proid) VALUES ('".$levid."', '".$pro_id."')";
			$levpro = mysql_query($query);
			
			if ($levpro == false) 
				{
					echo 'product id = '.$pro_id;
					echo showSQLError($query,mysql_error(),'Fout met database.');
					break;
				}
			$i = $i -1;
		}
	}
	
	else{
	$action = 'add';
	$query = "INSERT INTO leverancier 
			(levname, inkid, landid)
			VALUES
			('$_POST[lev_name]', '$_POST[ink_id]', '$_POST[land_id]')";
	$send = mysql_query($query);
	}

//get new id number	
$lev_id = mysql_insert_id();

//put data in connection table
$apro_id = $_POST['pro_id'];

$i = count($apro_id)-1;

while ($i >= 0) {

	$pro_id = $apro_id[$i];

	$querynew = "INSERT INTO levpro (levid, proid) VALUES ('".$lev_id."', '".$pro_id."')";
	$levpronew = mysql_query($querynew);

		if ($levpronew == false) 
		{
			echo showSQLError($querynew,mysql_error(),'Fout met database.');
		}

	$i = $i -1;
}

if ($send == false) 
{
    echo showSQLError($query,mysql_error(),'Fout met database.');}
elseif($levpronew == false){
		}
else {
	echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action='.$action.'">';
}
}

// make table to add data
else {
show:
echo '
<table>
	<tr>	<th colspan=2>
		<h1>'.ucfirst($_GET['page']).' toevoegen</h1>
	</th>	</tr>
	<form method="post" action="index.php?page='.$_GET['page'].'">
        <tr>	<th>
			Naam
		</th>	<td>
			<input type="text" name="lev_name" size="40" required>
		</td>	</tr>	
		<tr>	<th>
			Kies inkoper
		</th>	<td>
			<select size="1" Name="ink_id" required><option value="">--- Select ---</option>';
			  
                $list=mysql_query("SELECT * FROM inkoper ORDER BY inkname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="', $row_list['inkid'], '">';

                    echo $row_list['inkname'];

                    echo'</option>';

			}
		echo '
			</select>	
		</td>	</tr>	
		<tr>	<th>
					Kies land
		</th>	<td>
			<select size="1" Name="land_id" required><option value="">--- Select ---</option>';

                $list=mysql_query("SELECT * FROM landen ORDER BY landname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="'; 
						echo $row_list['landid'], '">';
                    echo $row_list['landname'];

                    echo'</option>';

                }

        echo '
			</select>
		</td>	</tr>
		<tr>	<th>
			Kies producten
		</th>	<td>
			<select size="10" Name="pro_id[]" required multiple>
			<option value="">--- Select ---</option>';
			  
                $list=mysql_query("SELECT * FROM product ORDER BY proname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="', $row_list['proid'], '">';

                    echo $row_list['proname'];

                    echo'</option>';

			}
		echo '
			</select>
				Holt ctrl-key for multiple selection
		</td>	</tr>
		<tr>	<td colspan=2>
			<right>
				<input type="submit" name="leverancier" value="Submit">
			</right>
		</td>	</tr>
	</form>
</table>';
}
?>