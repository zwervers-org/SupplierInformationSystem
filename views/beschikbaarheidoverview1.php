<?php
$selectbesch = "SELECT product.proname
				FROM probesch, product, beschikbaarheid
				WHERE product.proid = probesch.proid 
				AND probesch.beschid = beschikbaarheid.beschid 
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
//mysql_data_seek($resultbesch, 0);

$procheck = "";
$month = makemonth();	

for ($c = 0; $c < count($unique); $c ++){
	//print the product
	echo '<tr><td id="product"><a href="index.php?page=prooverview&pro='.key($unique).'">'.key($unique).'</a></td>';
	
	//Get information from the product
#	$selectproinf = "SELECT product.proid, leverancier.levname, inkoper.inkname, landen.*
#				FROM probesch, product, beschikbaarheid, leverancier, landen, inkoper
#				WHERE product.proname = ".key($unique)."
#				AND product.proid = probesch.proid
#				AND probesch.levid = leverancier.levid
#				AND leverancier.landid = landen.landid
#				AND leverancier.inkid = inkoper.inkid
#				ORDER BY ".OrderBy()."";	
#	$resultproinf = mysql_query($selectbesch);
	
	$combined = combinetable(key($unique));
	
	#colspan count
		$nr = 1;
	#previous suppliers check
		$prevsupp = "";
	#set other values in error mode
		$leverancier = array();
		$landid = array();
		$land = array();
		$inkoper = array();
	
	echo "<br><br>product: ".key($unique)."</br>";
	print_r($combined);
	
	foreach ($month as $k => $v){
		echo '</br> month: kwar'.$v;
		if ($combined['kwar'.$v] > -1) {	#product available
			if ($combined['kwar'.$v] !== $prevsupp){ #new suppliers available
				if (!$prevsupp){ #check if previous moth had suppliers
				#first finish previous month
					echo '<td colspan = '.$nr.' bgcolor=#00703C>';

					for($c = 0; $c < count($leverancier); $c++){
						#first land information in cel
						if ($c == 0){
							echo'<a href="index.php?page=landoverview&land='.$land[$c].'">'.$landid[$c].'</a><span>';
						}
						
						echo '<p>Leverancier: <a href="index.php?page=levoverview&lev='.$leverancier[$c].'">'.$leverancier[$c].'</a> -
							<a href="index.php?page=landoverview&land='.$land[$c].'">'.$land[$c].'</a></p>
							<p>Inkoper: <a href="index.php?page=inkoverview&ink='.$inkoper[$c].'">'.$inkoper[$c].'</a></p>';
					}
					echo '</span></td>';
				
				$nr = 1;#reset column count
				}
			
			#make list of individual suppliers
				$suppliers = explode(',', $combined['kwar'.$v]);
			
			#set the suppliers view for next month
				$prevsupp = $combined['kwar'.$v];

			#counter for time part range	
				$nr = 1;
			
			#put information of the supplier/product in an array
				foreach ($suppliers as $a => $b){
					$ProInfo = GetInfo(key($unique), $b);
					
						echo '</br>';
						print_r($ProInfo);
						echo '</br>';
					
					$leverancier[$a] = $ProInfo['levname'];
					$landid[$a] = $ProInfo['landid'];
					$land[$a] = $ProInfo['landname'];
					$inkoper[$a] = $ProInfo['inkname'];
				}
			}
			
			elseif ($combined['kwar'.$v] == $prevsupp){ #same suppliers in this month
			#next column
				$nr = $nr +1;
				echo '   '.$nr;
			}
			
			else { #no suppliers in this month
			echo 'no sup';
				if (!$prevsupp){ #check if there where suppliers in the previous month
				echo 'prevsupp not empty';
				#first finish previous month
					echo '<td colspan = '.$nr.' bgcolor=#00703C>';

					for($c = 0; $c < count($leverancier); $c++){
						#first land information in cel
						if ($c == 0){
							echo'<a href="index.php?page=landoverview&land='.$land[$c].'">'.$landid[$c].'</a><span>';
						}
						
						echo '<p>Leverancier: <a href="index.php?page=levoverview&lev='.$leverancier[$c].'">'.$leverancier[$c].'</a> -
							<a href="index.php?page=landoverview&land='.$land[$c].'">'.$land[$c].'</a></p>
							<p>Inkoper: <a href="index.php?page=inkoverview&ink='.$inkoper[$c].'">'.$inkoper[$c].'</a></p>';
					}
					echo '</span></td>';
				
					$nr = 1; #reset column count
					$prevsupp = ""; #reset previous supplier
				}
				echo '<td></td>';
				
			}
		}
		else{ #product is not available
			$nr = 1; #reset column count
			$prevsupp = ""; #reset previous supplier
					
			echo '<td></td>';
		}
	}
	
	
	
next($unique);
}
	exit ("<br><br>end new script");
	//EXIT OLD SCRIPT BELOW
while ($row = mysql_fetch_array($resultbesch)) {
	if ($procheck <> $row['proname']){
	echo '<tr><td id="product"><a href="index.php?page=prooverview&pro='.$row['proname'].'">'.$row['proname'].'</a></td>';	
	
	#colspan count
		$nr = 0;
	#previous suppliers check
		$prevsupp = "";
	#set first supplier/time part as true
		$first = 0;
	#counter for suppliers
		$supcount = 0;
	#set other values in error mode
		$leverancier = array();
		$landid = array();
		$land = array();
		$inkoper = array();
	
	
		$combined = combinetable($row['proname']);
		
		$procheck = $row['proname'];	#dubbele producten 1x meenemen

	foreach ($month as $k => $v){
		if (!empty($combined['kwar'.$v])) {	#product available
			#echo $combined['kwar'.$v];
			#echo '<br>kwar'.$v;
				if ($combined['kwar'.$v] <> $prevsupp){
					#echo 'supplier = '.$combined['kwar'.$v].'prevsupp = '.$prevsupp.'first0 = '.$first.'<br>';
					
					if ($first > 0){
						#echo 'supplier = '.$combined['kwar'.$v].'supplier = '.$prevsupp.'first1 = '.$first.'<br>';
						if ($nr > 0){
						echo '<td colspan = '.$nr.' bgcolor=#00703C>';
						}
						foreach($leverancier as $c => $d){
							if ($c < 1){
								echo'<a href="index.php?page=landoverview&land='.$land[$c].'">'.$landid[$c].'</a><span>';
							}
								#echo MakeTableBesch($leverancier[$c], $landid[$c], $land[$c], $inkoper[$c]);
								echo '<p>Leverancier: <a href="index.php?page=levoverview&lev='.$leverancier[$c].'">'.$leverancier[$c].'</a> -
									<a href="index.php?page=landoverview&land='.$land[$c].'">'.$land[$c].'</a></p>
									<p>Inkoper: <a href="index.php?page=inkoverview&ink='.$inkoper[$c].'">'.$inkoper[$c].'</a></p>';
						}
						echo '</span></td>';
					}
					
					#make list of individual suppliers
						$suppliers = explode(',', $combined['kwar'.$v]);
					
					#only count if suppliers sty the same
						$prevsupp = $combined['kwar'.$v];
						#echo 'prevsupp = '.$prevsupp.'</br>';
						#echo 'product = '.$row['proname'].'</br>';
					#counter for time part range	
						$nr = 1;
					#first time for the product
						$first = 1;

						foreach ($suppliers as $a => $b){
							$ProInfo = GetInfo($row['proid'], $b);
							#print_r($ProInfo);
							#echo '</br>';
							$leverancier[$a] = $ProInfo['levname'];
							$landid[$a] = $ProInfo['landid'];
							$land[$a] = $ProInfo['landname'];
							$inkoper[$a] = $ProInfo['inkname'];
							$supcount = $a;
						}
						#print_r($leverancier);
						#echo 'supcount = '.$supcount.'</br>';
				}
			
				elseif ($combined['kwar'.$v] = $prevsupp) {
					$nr = $nr + 1;
					#echo '</br>nr = '.$nr;
				}
			
				else	{ #problem with check
						#echo 'There is a problem with the check variable';
						echo 'failt | '.$prevsupp.' | '.$combined['kwar'.$v].'</br>';
					}
			}
			
		elseif ($nr > 0)	{ #finish supplier first -> get information in table
			echo '<td colspan = '.$nr.' bgcolor=#00703C>';
			foreach($leverancier as $c => $d){
				if ($c < 1){
					echo'<a href="index.php?page=landoverview&land='.$land[$c].'">'.$landid[$c].'</a><span>';
				}
					#echo MakeTableBesch($leverancier[$c], $landid[$c], $land[$c], $inkoper[$c]);
					echo '<p>Leverancier: <a href="index.php?page=levoverview&lev='.$leverancier[$c].'">'.$leverancier[$c].'</a> -
						<a href="index.php?page=landoverview&land='.$land[$c].'">'.$land[$c].'</a></p>
						<p>Inkoper: <a href="index.php?page=inkoverview&ink='.$inkoper[$c].'">'.$inkoper[$c].'</a></p>';
			}
			echo '</span></td>';

			$nr = 0;
			$prevsupp = '';
			#echo '<td></td>';
		}
		
		else	{	#no info
			echo '<td></td>';
			$prevsupp = '';
			$nr = 0;
		}
	}
	echo '</tr>';
	}
}
	
if ($resultbesch === false) {
    echo showSQLError($selectbesch,mysql_error(),'Fout met database.');}	
echo '</table></form>';

?>