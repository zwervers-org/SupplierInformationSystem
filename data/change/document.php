<?php
//execute the form
if (isset($_GET['del'])){
	if ($_GET['del'] == 'no'){
	$action = 'change';
	$docid = $_POST['doc_id'];
	$aproid = $_POST['pro_id'];
	
		//change data in document
	$query = "UPDATE document
			SET supply = '".$_POST['supply']."', supplydate = '".$_POST['supplydate']."', 
				regform = '".$_POST['regform']."', regfdate = '".$_POST['regfdate']."', 
				copper = '".$_POST['copper']."', copdate = '".$_POST['copdate']."', othdoc = '".$_POST['othdoc']."',
			gg = '".$_POST['gg']."', ggdate = '".$_POST['ggdate']."',
				bio = '".$_POST['bio']."', biodate = '".$_POST['biodate']."',
				ifs = '".$_POST['ifs']."', ifsdate = '".$_POST['ifsdate']."',
				bios = '".$_POST['bios']."', biosdate = '".$_POST['biosdate']."',
				nop = '".$_POST['nop']."', nopdate = '".$_POST['nopdate']."', othcert = '".$_POST['othcert']."',
			grond = '".$_POST['grond']."', water = '".$_POST['water']."', 
				blad = '".$_POST['blad']."', othpro = '".$_POST['othpro']."',
			opmerking = '".$_POST['opmerking']."', synergy = '".$_POST['synergy']."'
			WHERE docid = '".$docid."'";


//declare in the order variable
	$send = mysql_query($query);
	
echo '</br>send: '.$send;
	if ($send == 1){
	$i = count($aproid)-1;
	echo '</br> i count= '.$i;
	
	//clear connection table
		$querycomb = "DELETE FROM prodoc WHERE docid = '".$docid."'";
		mysql_query($querycomb);
	echo '</br>cleared connection table';
	
	//put data in connection table
	if ($i >= 0){
		while ($i >= 0) {
		
			echo '</br> i= '.$i;
		
			$proid = $aproid[$i];

			$querypro = "INSERT INTO prodoc (proid, docid) VALUES ('".$proid."', '".$docid."')";
			$sendpro = mysql_query($querypro);

				if ($sendpro == false){
					echo showSQLError($querypro,mysql_error(),'Fout: page='.$_GET['page'].'& action='.$action.' & function='.$i.'|sendpro.');}

			$i = $i -1;
		}
	echo '</br>finish inut connection table';}
	else{'</br>No input into connection table';}
	}
	else{
	echo 'ERROR SEND';
	break;}
}

	else {
	$action = 'del';
	$query = "DELETE FROM document WHERE docid = '" .$docid. "'";
	mysql_query($query);
	$querypro = "DELETE FROM prodoc WHERE docid = '" .$docid. "'";
	mysql_query($query);
	}
	
if ($send == false){
		echo showSQLError($query,mysql_error(),'Fout: page='.$_GET['page'].'& action='.$action.' & function=send.');}

elseif ($i >= 0){		
	if ($sendpro == false){
				echo showSQLError($querypro,mysql_error(),'Fout: page='.$_GET['page'].'& action='.$action.' & function=sendpro.');}}
else {
	echo '<meta http-equiv="refresh" content="0;URL=./index.php?page=documentoverview&action='.$action.'">';}
}

//make table to inset data
else{
//get document data
	$querydoc = "SELECT *
						FROM document
						WHERE '".$_POST['doc_id']."' = docid";
	$senddoc = mysql_query($querydoc);	

//set supplier form selection
		// view on page
echo '<table border="0" align="center">
  <tr>
	<th colspan=4><h1>Documenten toevoegen aan leverancier</h1></th>
  </tr>
        <form method="post" action="index.php?page='.$_GET['page'].'&change=yes">
			<tr>';
			while ($doc = mysql_fetch_array($senddoc)){
			echo '<th colspan=2>Document ID: </th><th><input type="text" maxlength="4" readonly name="doc_id" value="'.$_POST['doc_id'].'"></th>
			<th>Date of issue/valid:</th>
			</tr>
			<tr>
			<th colspan=2>Kies leverancier</th>';

		
		echo '<body onload=DependDropList('.$doc['levid'].',"product")>';
		echo'<td><select size="1" required Name="lev_id" 
					onchange=DependDropList(this.value,"product")>
					<option value="">--- Select ---</option>';

			  $select = $doc['levid'];
				
                $list=mysql_query("select * from leverancier order by levname asc");

				while($row_list=mysql_fetch_assoc($list)){

						echo '<option value="'.$row_list['levid'].'"';
					
					if($row_list['levid'] == $select){echo 'selected';} 
						echo '>';

						echo $row_list['levname'];

						echo'</option>';

					}

			echo '
			
			</select></td>
			<td><button id="AddInfoLev" onclick=AddInfo("leverancier")>Nieuwe leverancier</button></td>
			</tr>
			<tr>
			  <th rowspan=4>Document</th>
				<th>Supply Protocol?</th>
				<td><input type="checkbox" value="on" name="supply"';
				if ($doc['supply'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="supplydate" value='.$doc['supplydate'].'></td>
			</tr>
			<tr>
				<th>Registration Form?</th>
				<td><input type="checkbox" value="on" name="regform"';
				if ($doc['regform'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="regfdate"value='.$doc['regfdate'].'></td>
			</tr>
			<tr>
				<th>Kopper verklaring?</th>
				<td><input type="checkbox" value="on" name="copper"';
				if ($doc['copper'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="copdate"value='.$doc['copdate'].'></td>
			</tr>
			<tr>
				<th>Ander document?</th>
				<td colspan=2><textarea rows=4 maxlenght=150 name="othdoc" style="width:315px">'.$doc['othdoc'].'</textarea></td>
			</tr>
			<tr>
			  <th rowspan=6>Certificaat</th>
				<th>Global GAP</th>
				<td><input type="checkbox" value="on" name="gg"';
				if ($doc['gg'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="ggdate" value='.$doc['ggdate'].'></td>
			</tr>
			<tr>
				<th>Biologisch?</th>
				<td><input type="checkbox" value="on" name="bio"';
				if ($doc['bio'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="biodate" value='.$doc['biodate'].'></td>
			</tr>
			<tr>
				<th>Hygiene?</th>
				<td><input type="checkbox" value="on" name="ifs"';
				if ($doc['ifs'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="ifsdate" value='.$doc['ifsdate'].'></td>
			</tr>
			<tr>
				<th>Bio Suisse?</th>
				<td><input type="checkbox" value="on" name="bios"';
				if ($doc['bios'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="biosdate" value='.$doc['biosdate'].'></td>
			</tr>
				<th>NOP?</th>
				<td><input type="checkbox" value="on" name="nop"';
				if ($doc['nop'] == 'on'){echo 'checked';} echo'></td>
				<td><input type="date" name="nopdate" value='.$doc['nopdate'].'></td>
			</tr>
			<tr>
				<th>Ander certificaat?</th>
				<td colspan="2"><textarea rows=4 maxlenght=150 name="othcert" style="width:315px">'.$doc['othcert'].'</textarea></td>
			</tr>
			<tr>
			  <th rowspan=5>Analyse</th>
				<th>Grond?</th>
				<td colspan=2><input type="checkbox" value="on" name="grond"';
				if ($doc['grond'] == 'on'){echo 'checked';} echo'></td>
			</tr>
			<tr>
				<th>Water?</th>
				<td colspan=2><input type="checkbox" value="on" name="water"';
				if ($doc['water'] == 'on'){echo 'checked';} echo'></td>
			</tr>
			<tr>
				<th>Blad?</th>
				<td colspan=2><input type="checkbox" value="on" name="blad"';
				if ($doc['blad'] == 'on'){echo 'checked';} echo'></td>
			</tr>
			<th>Kies producten</th>';
	//dropdown list product
		echo'<td>
				<select id="droplist" size="3" name="pro_id[]" multiple>
					<option value="">--- Select ---</option>
				</select>
			</td>
			<td><button id="AddInfoPro" onclick=AddInfo("product")>Nieuw product</button></td>
			</tr>
			<tr>
				<th>Ander product?</th>
				<td colspan="2"><textarea rows=4 maxlenght=150 name="othpro" style="width:315px">'.$doc['othpro'].'</textarea>
			</tr>
			<tr>
				<th>Opmerkingen</th>
				<td colspan="3"><textarea rows=4 maxlenght=250 name="opmerking" style="width:448px">'.$doc['opmerking'].'</textarea></td>
			</tr>
			<tr>
				<th>Synergy link</th>
				<td colspan="3"><textarea rows=2 maxlength=250 name="synergy" style="width:448px">'.$doc['synergy'].'</textarea></td>
			</tr>
			<tr>
				<td colspan=4>
					<button align="right" formmethod="post" type="submit" formaction=./index.php?page='.$_GET['page'].'&change=yes&del=no>
						Wijzigen</button>
					<button align="center" formmethod="post" type="submit" formaction=./index.php?page='.$_GET['page'].'&change=yes&del=yes>
						Verwijderen</button>
				</td>
			</tr>
		</form>
	</table>';}
}
?>