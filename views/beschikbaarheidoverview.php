<html>
<head>
<title>Beschikbaarheid overzicht</title>
</head>
<body>

<?php

$selectbesch = "SELECT * FROM besch_pro_land, beschikbaarheid, producten, landen 
				WHERE beschikbaarheid.pro_id = producten.pro_id 
				ORDER BY pro_name ASC";
$resultbesch = mysql_query($selectbesch);

echo '<table align="center">
<form method="post" action="index.php?create-change_beschikbaarheid">
		<input type="hidden" name="formtype" value="besch_change">';

echo '
<tr>
<th rowspan=2><input type="submit" name="submit" value="Change"></th>
<th rowspan=2>Product</th>
<th widht="10px" colspan=4>Januari</th>
<th widht="10px"colspan=4>Februari</th>
<th widht="10px"colspan=4>Maart</th> 
<th widht="10px"colspan=4>April</th> 
<th widht="10px"colspan=4>Mei</th> 
<th widht="10px"colspan=4>Juni</th> 
<th widht="10px"colspan=4>Juli</th> 
<th widht="10px"colspan=4>Augustus</th> 
<th widht="10px"colspan=4>September</th> 
<th widht="10px"colspan=4>Oktober</th> 
<th widht="10px"colspan=4>November</th> 
<th widht="10px"colspan=4>December</th> 
</tr>';

echo '<!--
	<tr>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	<th></th><th></th><th></th><th></th>
	</tr>--!>';

while ($row = mysql_fetch_array($resultbesch)) {
		echo '<tr><td><center>';
		echo '<input type="radio" name="besch_id" value= ',$row['besch_id'], '></td><td>';
        echo $row['pro_name'];
		
	echo '</center></td><td bgcolor=';
				if ($row['kwar1_jan'] == 'on') {echo '#00703C';}
        
		echo '></td><td bgcolor=';
				if ($row['kwar2_jan'] == 'on') {echo '#00703C';}
		
		echo '></td><td bgcolor=';
				if ($row['kwar3_jan'] == 'on') {echo '#00703C';}
        
		echo '></td><td bgcolor=';
				if ($row['kwar4_jan'] == 'on') {echo '#00703C';}
        
		echo '></td><td bgcolor=';
				if ($row['kwar1_feb'] == 'on') {echo '#00703C';}
        
		echo '></td><td bgcolor=';
				if ($row['kwar2_feb'] == 'on') {echo '#00703C';}
        
		echo '></td><td bgcolor=';
				if ($row['kwar3_feb'] == 'on') {echo '#00703C';}
        
		echo '></td><td bgcolor=';
				if ($row['kwar4_feb'] == 'on') {echo '#00703C';}
        
    }
if ($resultbesch === false) 
{
    echo showSQLError($selectbesch,mysql_error(),'Fout met database.');
}	
echo '</table></from>';