<?php
$selectbesch = "SELECT product.proname, beschikbaarheid.*, leverancier.levname, inkoper.inkname, landen.*
				FROM probesch, product, beschikbaarheid, leverancier, landen, inkoper
				WHERE product.proid = probesch.proid 
				AND probesch.beschid = beschikbaarheid.beschid 
				AND probesch.levid = leverancier.levid
				AND leverancier.landid = landen.landid
				AND leverancier.inkid = inkoper.inkid
				ORDER BY proname ASC";	
$resultbesch = mysql_query($selectbesch);

$month = makemonth();

echo '	<link rel="stylesheet" href="./template/availability.css" type="text/css">';

echo '<table align="center">
<form method="post" action="index.php?page=beschikbaarheid&change=yes">
		<input type="hidden" name="formtype" value="besch_change">';

echo '
<tr>
<th id="product">Product</th>
<th id="month" colspan=4>Januari</th>
<th id="month" colspan=4>Februari</th>
<th id="month" colspan=4>Maart</th> 
<th id="month" colspan=4>April</th> 
<th id="month" colspan=4>Mei</th> 
<th id="month" colspan=4>Juni</th> 
<th id="month" colspan=4>Juli</th> 
<th id="month" colspan=4>Augustus</th> 
<th id="month" colspan=4>September</th> 
<th id="month" colspan=4>Oktober</th> 
<th id="month" colspan=4>November</th> 
<th id="month" colspan=4>December</th> 
</tr>';

#make array to count number of unique products
while ($row = mysql_fetch_array($resultbesch)) {
$pronames[] = $row['proname'];
$unique = array_count_values($pronames);
}
mysql_data_seek($resultbesch, 0);

$procheck = "";
$month = makemonth();

while ($row = mysql_fetch_array($resultbesch)) {
	echo '<tr><td id="product"><a href="index.php?page=prooverview&pro='.$row['proname'].'">'.$row['proname'].'</a></td>';	
	
	#colspan count
		$nr = 0;
	#supplier check
		$check = "";
	#more suppliers
		$moresups = false;
	#set first supplier/time part as true
		$first = true;
	#counter for suppliers
		$supcount = 0;

	#set other values in error mode
		$leverancier = array();
		$landid = array();
		$land = array();
		$inkoper = array();
	
		foreach ($month as $k => $v){
			if ($row['kwar'.$v] == 'on') {	#product available
				if ($leverancier <> $check){	#new time part
					if ($first = false)	{	#second supplier/time part in product row
						$supcount = $supcount + 1;
					}
					
				#counter for time part range
					$nr = 1;
					$leverancier[$supcount] = $row['levname'];
					$landid[$supcount] = $row['landid'];
					$land[$supcount] = $row['landname'];
					$inkoper[$supcount] = $row['inkname'];
					$check = $leverancier;
					$first = false;
				}
					
				elseif ($leverancier = $check){
				$nr = $nr + 1;
				}
				
				else	{ #problem with check
					echo 'There is a problem with the check variable';
				}
			}
			
			elseif ($nr > 0)	{ #finish supplier
				echo besch($leverancier, $landid, $land, $inkoper, $nr, $supcount);
				$nr = 0;
				echo '<td></td>';
			}
			
			else	{	#no info
				echo '<td></td>';
			}
		}
		if ($nr > 0)	{ #finish supplier
			echo besch($leverancier, $landid, $land, $inkoper, $nr, $supcount);
			$nr = 0;
		}
		echo '</tr>';
	}
	
if ($resultbesch === false) {
    echo showSQLError($selectbesch,mysql_error(),'Fout met database.');}	
echo '</table></form>';
?>