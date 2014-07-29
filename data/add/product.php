<?php

//add data to sql
if (isset($_POST['pro_name'])){

$ordernew = "INSERT INTO product 
			(proname)
			VALUES
			('$_POST[pro_name]')";

$nametoget = $_POST['pro_name'];

//make new product
$productnew = mysql_query($ordernew);	//order executes

//get new id number	
$pro_id = mysql_insert_id();

//put data in connection table
$alev_id = $_POST['lev_id'];

$i = count($alev_id)-1;

while ($i >= 0) {

	$lev_id = $alev_id[$i];

	$querynew = "INSERT INTO levpro (levid, proid) VALUES ('".$lev_id."', '".$pro_id."')";
	$levpronew = mysql_query($querynew);

		if ($levpronew == false) 
		{
			echo showSQLError($querynew,mysql_error(),'Fout met database.');
		}

	$i = $i -1;
}

if ($productnew == false) {
    echo showSQLError($productnew,mysql_error(),'Fout met database.');}
elseif ($pro_id == false) {
    echo showSQLError($get_id,mysql_error(),'Fout met database.');}
elseif($levpronew == false){
		}
else {
	echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action=add">';
}
}

//make table to insert data
else {
echo '
<table align="center">
	<form action="index.php?page='.$_GET['page'].'" method="post" name="'.$_GET['page'].' add">
		<tr>	<th colspan=2>
			<h1>'.ucfirst($_GET['page']).' toevoegen</h1>
		</th>	</tr>
		<tr>	<th>
			Naam	
		</th>	<td>
			<input type="text" name="pro_name" size="40">
		</td>	</tr>
<!--dropdown leverancier-->
		<tr>	<th>
			Leverancier
		</th>	<td>
			<select size="10" Name="lev_id[]" required multiple>';
			  
                $list=mysql_query("SELECT * FROM leverancier ORDER BY levname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="',$row_list['levid'],'">';

                    echo $row_list['levname'];

                    echo'</option>';

			}

echo ' 
			</select>
			Holt ctrl-key for multiple selection
		</td>	</tr>
		<tr>	<td colspan=2>
			<right>
				<input type="Submit" name="Submit" value="Toevoegen">
			</right>
		</td>	</tr>
	</form>
</table>';
}
?>