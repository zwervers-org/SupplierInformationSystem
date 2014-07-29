<?php

$selectdoc = 	"SELECT * 
				FROM leverancier, document 
				WHERE document.levid = leverancier.levid 
				ORDER BY levname ASC";
$resultdoc = mysql_query($selectdoc);

echo '	<link rel="stylesheet" href="./template/documents.css" type="text/css">

<table>
<thead>
<form method="post" action="index.php?page=document&change=yes">';

echo '
<tr>
<th id="change" rowspan=2></th>
<th id="lev" rowspan=2>Leverancier</th>
<th id="doc" colspan=4>Document</th>
<th id="cert" colspan=6>Certificaat</th>
<th id="ana" colspan=5>Analyse</th>
<th id="opm" rowspan=2>Opm.</th>
</tr>';

echo '
<tr>
	<th id="supply">Supply Protocol</th><th id="reg">Registra- tion Form</th><th id="copper">Copper Declaration</th><th id="ander">Ander</th>
	<th id="gg">Global GAP</th><th id="bio">Biologisch</th><th id="hygiene">Hygiene</th><th id="bios">Bio Suisse</th><th id="nop">N.O.P</th><th id="overig">Overig</th>
	<th id="grond">Grond</th><th id="water">Water</th><th id="blad">Blad</th><th id="prod" colspan=2>Product</th>
	</tr>
	</thead><tbody>'; 

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
		echo '<tr><td  id="change"><center>';
		if(in_array($username, $moderator) OR in_array($username, $admin)){
		echo '<input type="radio" onchange="this.form.submit()" name="doc_id" value= ',$row['docid'], '></td><td id="lev">';}
        //if extern link is yes show link
		//if there is a link to synergy show hyperlink
			if($link=="yes" && $row['synergy'] !== ""){echo'<a href="'.$row['synergy'].'">'.$row['levname'].'</a>';}
			else {echo $row['levname'];}
	//Documenten	
		echo '</center></td><td id="supply" bgcolor='.$supply.'
			</td><td id="reg" bgcolor='.$regf.'
			</td><td id="copper" bgcolor='.$copper.'
			</td><td id="ander" class="popup">';
			echo $infodoc;
			
	//Certificaten
		echo '</td><td id="gg" bgcolor='.$gg.'
			</td><td id="bio" bgcolor='.$bio.'
			</td><td id="hygiene" bgcolor='.$ifs.'
			</td><td id="bios" bgcolor='.$bios.'
			</td><td id="nop" bgcolor='.$nop.'
			</td><td id="overig" class="popup">';
			echo $infocert;
	
	//Analyses		
		echo '</td><td id="grond" bgcolor='.$grond.'
			</td><td id="water" bgcolor='.$water.'
			</td><td id="blad" bgcolor='.$blad.'
			</td><td id="prod1" class="popup">
				<img align="middle" class="nr'.$num_rows.'" alt="for '.$num_rows.' products" 
					src="./image/trans.gif" width="20px" height="22px">
				<span>';
			 echo '<table><tbody class="popup">';
			
			//make list of products
			while ($pro = mysql_fetch_array($resultlev)) {
				echo '<tr><td class="opsomming">';
					echo $pro['proname'];
				echo '</td></tr>';
				}
			echo '</tbody></table>';
			echo '</span></td><td id="prod2" class="popup">';
			echo $infopro;
			echo '</td><td id="opm" class="popup">';
			echo $infoopm;
		echo '</td></tr>';
    }
echo '</tbody>
<thead>
<tr>
<th id="change" rowspan=2></th>
<th id="lev" rowspan=2>Leverancier</th>
	<th id="supply">Supply Protocol</th><th id="reg">Registra- tion Form</th><th id="copper">Copper Declaration</th><th id="ander">Ander</th>
	<th id="gg">Global GAP</th><th id="bio">Biologisch</th><th id="hygiene">Hygiene</th><th id="bios">Bio Suisse</th><th id="nop">N.O.P</th><th id="overig">Overig</th>
	<th id="grond">Grond</th><th id="water">Water</th><th id="blad">Blad</th><th id="prod" colspan=2>Product</th>
	<th id="opm" rowspan=2>Opm.</th>
</tr>
<th id="doc" colspan=4>Document</th>
<th id="cert" colspan=6>Certificaat</th>
<th id="ana" colspan=5>Analyse</th>

</tr>

	</thead></table></form>';