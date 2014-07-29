<?php
if (isset($_GET['del'])){

	if ($_GET['del'] == 'no'){

	$action = 'change';
	$query = "UPDATE product SET proname = '".$_POST['pro_name']."', proart = '".$_POST['pro_art']."' WHERE proid = '".$_POST['pro_id']."'";
	$send = mysql_query($query);
	
	//clear connection table
		$querycomb = "DELETE FROM levpro WHERE proid = '".$_POST['pro_id']."'";
		$sendcomb = mysql_query($querycomb);
		
	//put data in connection table
	$alev_id = $_POST['lev_id'];

	$i = count($alev_id)-1;

		while ($i >= 0) {

			$lev_id = $alev_id[$i];

			$querynew = "INSERT INTO levpro (levid, proid) VALUES ('".$lev_id."', '".$_POST['pro_id']."')";
			$levpronew = mysql_query($querynew);

				if ($levpronew == false) 
				{
					echo 'leverancier id = '.$lev_id;
					echo '</br>last iserted id = '.mysql_insert_id();
					echo showSQLError($querynew,mysql_error(),'Fout met database.');
					break;
				}

			$i = $i -1;
		}
	}
	
	else {
	$action = 'del';
	$query = "DELETE FROM product WHERE proid = '" .$_POST['pro_id']. "'";
	mysql_query($query);
	$send=true;
	$querycomb = "DELETE FROM levpro WHERE proid = '".$_POST['pro_id']."'";
	mysql_query($querycomb);
	}

	if ($send == false){
		echo showSQLError($query,mysql_error(),'Fout met database.');}
	elseif ($levpronew == false){
		echo 'ERROR CONNECTION TABLE';}

	else{
		echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action='.$action.'">';
		}
	}

//make table to change
else{

	$proid = $_POST['pro_id'];

	//get product to change
$querypro = "SELECT * 
					FROM product
					WHERE proid = '".$proid."'";
$sendpro = mysql_query($querypro);

	while ($prochange = mysql_fetch_array($sendpro)){

	//get selected suppliers
		$querylev = "SELECT levname
						FROM leverancier
						JOIN product ON '".$proid."' = product.proid 
						JOIN levpro	ON product.proid = levpro.proid 
							AND levpro.levid = leverancier.levid";
		$sendlev = mysql_query($querylev);		

	echo '<table><tr>
	<th colspan=2><h1>'.ucfirst($_GET['page']).' wijzigen</h1></th>
  	</tr>	<tr>
      <table border="0">
        <form action="index.php?page='.$_GET['page'].'&change=yes&del=no" method="post" name="'.$_GET['page'].'change">
		<tr>	<th>ID</th>	<td>
			<input type="text" name="pro_id-dis" value="'.$prochange['proid'].'" disabled>
			<input type="hidden" name="pro_id" value="'.$prochange['proid'].'"></td>
		</tr>
		<tr>	<th>Naam</th>	<td>
			<input type="text" name="pro_name" value="'.$prochange['proname'].'">    
			<input type="checkbox" name="pro_art" value="'.$prochange['proart'].'"> Artikel groep?
		</td>		</tr>';
		
		//array of selected suppliers
		$levnames = "";
		while ($levname = mysql_fetch_array($sendlev)){
		$levnames[] = $levname['levname'];}
		
//dropdown leverancier
	echo '<th>Leverancier</th>
          <td><select size="10" Name="lev_id[]" multiple required>';

				$select= $levnames;

                if (isset ($select)&&$select == ""){

				$select=array();
            }

                $list=mysql_query("SELECT * FROM leverancier ORDER BY levname ASC");

            while($row_list=mysql_fetch_assoc($list)){

                    echo '<option value="'.$row_list['levid'], '"' ;
						if(in_array($row_list['levname'], $select)){echo "selected";}
                    	echo'>';
                    echo $row_list['levname'];

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