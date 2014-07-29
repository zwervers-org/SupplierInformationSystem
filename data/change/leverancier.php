<?php
if (isset($_GET['del'])){

	if ($_GET['del'] == 'no'){

	$action = 'change';
	$query = "UPDATE leverancier SET levname = '".$_POST['lev_name']."', inkid = '".$_POST['ink_id']."',
		landid = '".$_POST['land_id']."'
		WHERE levid = '".$_POST['lev_id']."'";
	$send = mysql_query($query);
	
	//clear connection table
	$querylp = "DELETE FROM levpro WHERE levid = '" .$_POST['lev_id']. "'";
	$sendlp = mysql_query($querylp);
	
	//put data in connection table
	$apro_id = $_POST['pro_id'];

	$i = count($apro_id)-1;

		while ($i >= 0) {

			$pro_id = $apro_id[$i];
	echo 'product id = '.$pro_id;
			$query = "INSERT INTO levpro (levid, proid) VALUES ('".$_POST['lev_id']."', '".$pro_id."')";
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
	
	else {
	$action = 'del';
	$query = "DELETE FROM leverancier WHERE levid = '" .$_POST['lev_id']. "'";
	$send = mysql_query($query);
	
	$querylp = "DELETE FROM levpro WHERE levid = '" .$_POST['lev_id']. "'";
	$sendlp = mysql_query($querylp);
	}
	
	if ($send == false){
		echo showSQLError($query,mysql_error(),'Fout met database.');}
	elseif ($sendlp == false){
		echo showSQLError($querylp,mysql_error(),'Fout met database.');}
	elseif($levpro == false){
		}
	else{
		echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action='.$action.'">';
	}}

//make table to change
else{

	//get supplier to change
$query = "SELECT * 
					FROM leverancier
					WHERE levid = '".$_POST['lev_id']."'";
$send = mysql_query($query);

	while ($get = mysql_fetch_array($send)){		
//get selected products
		$querypro = "SELECT *
						FROM product
						JOIN leverancier ON '".$_POST['lev_id']."' = leverancier.levid 
						JOIN levpro	ON leverancier.levid = levpro.levid 
							AND levpro.proid = product.proid";
		$sendpro = mysql_query($querypro);
	
//make table
	echo '<table><tr>
	<th colspan=2><h1>'.ucfirst($_GET['page']).' wijzigen</h1></th>
  	</tr>	<tr>
      <table border="0">
        <form action="index.php?page='.$_GET['page'].'&change=yes&del=no" method="post" name="'.$_GET['page'].'change">
		<tr>	<th>ID</th>	<td>
			<input type="text" name="lev_id-dis" value="'.$get['levid'].'" disabled>
			<input type="hidden" name="lev_id" value="'.$get['levid'].'"></td>
		</tr>
		<tr>	<th>Naam</th>	<td>
			<input type="text" name="lev_name" value="'.$get['levname'].'"></td>
		</tr>';
		
//dropdown inkoper
	echo '<th>Inkoper</th>
          <td><select size="1" Name="ink_id" required>';

				$select=$get['inkid'];

                if (isset ($select)&&$select == ""){

				$select="";
            }

                $list=mysql_query("SELECT * FROM inkoper ORDER BY inkname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="'; 
						echo $row_list['inkid'], '"' ;
						if($row_list['inkid'] == $select){echo "selected";}
                    	echo'>';
                    echo $row_list['inkname'];

                    echo'</option>';

                }

           echo ' </select></td></tr>';

//dropdown landen
	echo '<th>Land</th>
          <td><select size="1" Name="land_id" required>';

				$select=$get['landid'];

                if (isset ($select)&&$select == ""){

				$select="";
            }

                $list=mysql_query("SELECT * FROM landen ORDER BY landname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="'; 
						echo $row_list['landid'], '"' ;
						if($row_list['landid'] == $select){echo "selected";}
                    	echo'>';
                    echo $row_list['landname'];

                    echo'</option>';

                }
           echo ' </select></td></tr>';

//array of selected suppliers
		$proids = "";
		while ($proid = mysql_fetch_array($sendpro)){
		$proids[] = $proid['proid'];}
		   
//dropdown producten
	echo '<th>Producten</th>
          <td><select size="10" Name="pro_id[]" required multiple>';

			$select= $proids;

			if (isset ($select)&&$select == ""){

			$select=array();
			}

                $list=mysql_query("SELECT * FROM product ORDER BY proname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="'; 
						echo $row_list['proid'], '"' ;
						if(in_array($row_list['proid'], $select)){echo "selected";}
                    	echo'>';
                    echo $row_list['proname'];

                    echo'</option>';

                }
           echo ' </select>
		   Holt ctrl-key for multiple selection
		   </td></tr>
		   <tr><td>
			<button align="right" formmethod="post" type="submit" formaction=./index.php?page='.$_GET['page'].'&change=yes&del=no>
					Wijzigen</button>
			<button align="center" formmethod="post" type="submit" formaction=./index.php?page='.$_GET['page'].'&change=yes&del=yes>
					Verwijderen</button>
			</td></tr>';
	}
echo '	</table>
			</table>
       		 </form>';}
?>