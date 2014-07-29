<?php 

$selectpro = "SELECT * from producten ORDER BY pro_name";
$resultpro = mysql_query($selectpro);

$selectland = "SELECT * from landen";
$resultland = mysql_query($selectland);

$selecttijd = "SELECT * from beschikbaarheid";
$resulttijd = mysql_query($selecttijd);

$selectink = "SELECT * from inkoper";
$resultink = mysql_query($selectink);

$selectlev ="SELECT * from leverancier";
$resultlev = mysql_query($selectlev);

$selectbesch ="SELECT * from beschikbaarheid, besch_pro_land, producten
				WERE beschikbaarheid.besch_id = besch_pro_land.besch_id";
$resultbesch = mysql_query($selectbesch);

$selectsql = $selectlev OR $selectink OR $selecttijd OR $selectland OR $selectpro;
$resultsql = $resultlev OR $resultink OR $resulttijd OR $resultland OR $resultpro;
//Table starting tag and header cells
echo 
'<html><table cellspacing="0">
        <tr>
		<th>Producten</th>

		<th colspan=4>januari</th>
		<th colspan=4>februari</th>
		<th colspan=4>maart</th>
		<th colspan=4>april</th>
		<th colspan=4>mei</th>
		<th colspan=4>juni</th>
		<th colspan=4>juli</th>
		<th colspan=4>augustus</th>
		<th colspan=4>september</th>
		<th colspan=4>oktober</th>
		<th colspan=4>november</th>
		<th colspan=4>december</th>
        </tr>';
while($pro = mysql_fetch_array($resultpro)){
//Display the results in different cells

	echo '<tr><td class="producten">';
      echo $pro['pro_name'];
    echo '</td>';
}
while($row = mysql_fetch_array($resultbesch)){
	//Display the results in different cells
  echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar1_jan'] == 'on') {echo '#00703C';}
	
  echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar2_jan'] == 'on') {echo '#00703C';}
  
	echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar3_jan'] == 'on') {echo '#00703C';}
	
  echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar4_jan'] == 'on') {echo '#00703C';}
	
	  echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar1_feb'] == 'on') {echo '#00703C';}
	
  echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar2_feb'] == 'on') {echo '#00703C';}
  
	echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar3_feb'] == 'on') {echo '#00703C';}
	
  echo '<td class="kwarielen" bgcolor=';
	if ($row['kwar4_feb'] == 'on') {echo '#00703C';}
	
  echo '</td></tr>';
}
echo '</table></html>';

if ($resultsql === false) 
{
    echo showSQLError($selectsql,mysql_error(),'Fout met database.');
}
?>
