<?php
$selectbesch = "SELECT product.proname, beschikbaarheid.*, leverancier.levname, inkoper.inkname, landen.*
				FROM probesch, product, beschikbaarheid, leverancier, landen, inkoper
				WHERE product.proid = probesch.proid 
				AND probesch.beschid = beschikbaarheid.beschid 
				AND probesch.levid = leverancier.levid
				AND leverancier.landid = landen.landid
				AND leverancier.inkid = inkoper.inkid
				AND inkoper.inkname = '".$_GET['ink']."'
				ORDER BY proname ASC";	
$resultbesch = mysql_query($selectbesch);

echo '	<link rel="stylesheet" href="./template/availability.css" type="text/css">';

echo '<table align="center">';
#echo '<form method="post" action="index.php?page=beschikbaarheid&change=yes">
#		<input type="hidden" name="formtype" value="besch_change">';

echo '
<tr>
<th colspan="50">
			<h1>Inkoper overzicht van '.$_GET['ink'].'</h1>
		</th>	</tr>
<th id="change"></th>
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

	$procheck = "";
$month = makemonth();
	
while ($row = mysql_fetch_array($resultbesch)) {
	echo '<tr><td id="change">';
	#echo '<input type="radio" onchange="this.form.submit()" name="beschid" value= ',$row['beschid'], '>';
	echo '</td><td id="product"><a href="index.php?page=levoverview&lev='.$row['levname'].'">'.$row['levname'].'</a></td>';	
	
	#colspan count
		$nr = 0;
	#supplier check
		$check = "";
	#supplier count
		$supcount = 0;
	#set first supplier/time part as true
		$first = true;

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
	
if ($resultbesch === false) 
{
    echo showSQLError($selectbesch,mysql_error(),'Fout met database.');
}	
echo '</table></form>';
?>