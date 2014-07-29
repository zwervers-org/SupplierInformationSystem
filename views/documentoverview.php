<?php

$selectdoc = 	"SELECT * 
				FROM leverancier, document 
				WHERE document.levid = leverancier.levid 
				ORDER BY levname ASC";
$resultdoc = mysql_query($selectdoc);

echo '<table align="center">
<form method="post" action="index.php?page=document&change=yes">';

echo '
<tr>';
if(in_array($username, $moderator) OR in_array($username, $admin)){echo '<th rowspan=2></th>';}
echo '<th rowspan=2>Leverancier</th>
<th colspan=4>Document</th>
<th colspan=6>Certificaat</th>
<th colspan=5>Analyse</th>
<th rowspan=2>Opm.</th>
</tr>';

echo '
	<tr>
	<th>Supply Proto- col</th><th>Registra- tion Form</th><th>Copper Declaration</th><th>Ander</th>
	<th>Global GAP</th> <th>Biologisch</th><th>Hygiene</th><th>Bio Suisse</th><th>N.O.P</th><th>Overig</th>
	<th>Grond</th><th>Water</th><th>Blad</th><th colspan=2>Product</th>
	</tr>';

while ($row = mysql_fetch_array($resultdoc)) {
	//query for product list
	$selectlev = "SELECT proname
						FROM product
						JOIN document 
							ON document.docid = '".$row['docid']."'
						JOIN prodoc
							ON prodoc.proid = product.proid AND prodoc.docid = document.docid
						ORDER BY proname ASC";
	$resultlev = mysql_query($selectlev);
	$num_rows = mysql_num_rows($resultlev);
	
	//if > 10 -> one picture
	if ($num_rows > 10) {
	$num_rows = 11;}
	else {
	$num_rows = $num_rows;}
	
	//Get color and text for the documents
	//Document
	$supply = overview('doc', $row['supply'], $row['supplydate']);
	$regf = overview('doc', $row['regform'], $row['regfdate']);
	$copper = overview('doc', $row['copper'], $row['copdate']);
	
	//Certificate
	$gg = overview('cert', $row['gg'], $row['ggdate']);
	$bio = overview('cert', $row['bio'], $row['biodate']);
	$ifs = overview('cert', $row['ifs'], $row['ifsdate']);
	$bios = overview('cert', $row['bios'], $row['biosdate']);
	$nop = overview('cert', $row['nop'], $row['nopdate']);
	
	//Analyze
	$grond = overview('anal', $row['grond'], '');
	$water = overview('anal', $row['water'], '');
	$blad = overview('anal', $row['blad'], '');
	
	//get extra info image
	$infodoc = info($row['othdoc']);
	$infocert = info($row['othcert']);
	$infopro = info($row['othpro']);
	$infoopm = info($row['opmerking']);
	
	//make table
		echo '<tr><td><center>';
		if(in_array($username, $moderator) OR in_array($username, $admin)){
		echo '<input type="radio" onchange="this.form.submit()" name="doc_id" value= ',$row['docid'], '></td><td>';}
        //if extern link is yes show link
		//if there is a link to synergy show hyperlink
			if($link=="yes" && $row['synergy'] !== ""){echo'<a href="'.$row['synergy'].'">'.$row['levname'].'</a>';}
			else {echo $row['levname'];}
	//Documenten	
		echo '</center></td><td bgcolor='.$supply.'
			</td><td bgcolor='.$regf.'
			</td><td bgcolor='.$copper.'
			</td><td>';
			echo $infodoc;
			
	//Certificaten
		echo '</td><td bgcolor='.$gg.'
			</td><td bgcolor='.$bio.'
			</td><td bgcolor='.$ifs.'
			</td><td bgcolor='.$bios.'
			</td><td bgcolor='.$nop.'
			</td><td>';
			echo $infocert;
	
	//Analyses		
		echo '</td><td bgcolor='.$grond.'
			</td><td bgcolor='.$water.'
			</td><td bgcolor='.$blad.'
			</td><td>
				<img align="middle" class="nr'.$num_rows.'" alt="for '.$num_rows.' products" 
					src="./image/trans.gif" width="20px" height="22px">
				<span>';
			 echo '<table>';
			//make list of products
			while ($pro = mysql_fetch_array($resultlev)) {
				echo '<tr><td class="opsomming">';
					echo $pro['proname'];
				echo '</td></tr>';
				}
			echo '</table>';
			echo '</span></td><td>';
			echo $infopro;
			echo '</td><td>';
			echo $infoopm;
		echo '</td></tr>';
    }
echo '</table></form>';