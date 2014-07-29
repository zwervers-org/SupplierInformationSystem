<?php
$tablename = "maanden";

#delete table after input
$droptable = false;

if ($droptable = true){
	$drop = "DROP TABLE IF EXISTS '".$tablename."'" ;
	mysql_query ($drop) or (showSQLError($drop,mysql_error(),'Fout met database.')) ;				
}

#change the column names!
$make = "CREATE TABLE '".$tablename."' id INT(2) AUTO_INCREMENT PRIMARY KEY, maand VARCHAR(3), kwartaal INT(1))";
mysql_query($make) or (showSQLError($make,mysql_error(),'Fout met database.')) ;

$mc = 1;
$m = "";

# begin input
while ($mc <= 12){
	$k = 1;
	
	switch ($mc){
		case 1:
			$m = "jan";
			break;
		case 2:
			$m = "feb";
			break;
		case 3:
			$m = "maa";
			break;
		case 4:
			$m = "apr";
			break;
		case 5:
			$m = "mei";
			break;
		case 6:
			$m = "jun";
			break;
		case 7:
			$m = "jul";
			break;
		case 8:
			$m = "aug";
			break;
		case 9:
			$m = "sep";
			break;
		case 10:
			$m = "okt";
			break;
		case 11:
			$m = "nov";
			break;
		case 12:
			$m = "dec";
			break;
		}

#per product per kwarter of a month		
	while ($k <= 4){		
		$input = "INSERT INTO '".$tablename."' 
			(maand, kwartaal)
			VALUES
			('".$m."', '".$k."')";
		mysql_query($input) or (showSQLError($input,mysql_error(),'Fout met database.')) ;
		$k = $k + 1;
	}
}
#end input

if ($droptable = true){
	$drop = "DROP TABLE IF EXISTS '".$tablename."'" ;
	mysql_query ($drop) or (showSQLError($drop,mysql_error(),'Fout met database.')) ;				
}
?>