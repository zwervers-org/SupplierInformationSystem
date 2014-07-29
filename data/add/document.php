<?php
//add data to sql
if (isset($_POST['lev_id'])){

$querydoc = "INSERT INTO document
			(levid, 
			supply, supplydate, regform, regfdate, copper, copdate, othdoc,
			gg, ggdate, bio, biodate, ifs, ifsdate, bios, biosdate, nop, nopdate, othcert,
			grond, water, blad, othpro, 
			opmerking, synergy)
			
	VALUES
			('$_POST[lev_id]',
			'$_POST[supply]','$_POST[supplydate]','$_POST[regform]','$_POST[regfdate]','$_POST[copper]','$_POST[copperdate]',
				'$_POST[othdoc]',
			'$_POST[gg]','$_POST[ggdate]','$_POST[bio]','$_POST[biodate]','$_POST[ifs]','$_POST[ifsdate]','$_POST[bios]',
				'$_POST[biosdate]','$_POST[nop]','$_POST[nopdate]','$_POST[othcert]',
			'$_POST[grond]','$_POST[water]','$_POST[blad]','$_POST[othpro]',
			'$_POST[opmerking]','$_POST[synergy]')";

//declare in the order variable
$insertdoc = mysql_query($querydoc);	//order executes

if ($insertdoc <> false){

	//last inserted id
	$doc_id = mysql_insert_id();

	//put data in connection table
	$apro_id = $_POST['pro_id'];
	$i = count($apro_id)-1;
	if ($i >= 0){
		while ($i >= 0) {

			echo '</br> i= '.$i;
		
			$pro_id = $apro_id[$i];

			$querypro = "INSERT INTO prodoc (proid, docid) VALUES ('".$pro_id."', '".$doc_id."')";
			$prodocnew = mysql_query($querypro);

				if ($prodocnew == false) {
					echo showSQLError($querypro,mysql_error(),'Fout: page='.$_GET['page'].'& action='.$action.' & function=prodocnew.');}

			$i = $i -1;
		}
		echo '</br>finish inut connection table';}
	else{
		echo '</br>No input into connection table';}
	}
	else{
		echo 'ERROR SEND';
		break;}

if ($insertdoc == false) {
	echo showSQLError($querydoc,mysql_error(),'Fout: page='.$_GET['page'].'& action='.$action.' & function=insertdoc.');}
elseif ($prodocnew == false) {
	echo showSQLError($querypro,mysql_error(),'Fout: page='.$_GET['page'].'& action='.$action.' & function=prodocnew.');}
else {
	echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action=add">';}
}

//make table to inset data
else{
// view on page
echo '<table border="0" align="center">
  <tr>
	<th colspan=4><h1>Documenten toevoegen aan leverancier</h1></th>
  </tr>
        <form method="post" action="index.php?page='.$_GET['page'].'">
			<tr>
			<th colspan=3></th>
			<th>Date of issue/valid:</th>
			</tr>
			<tr>
			<th colspan=2>Kies leverancier</th>';
	
	//dropdownlist suppliers
		echo '<td><select size="1" required Name="lev_id" onchange=DependDropList(this.value,"product")><option value="">--- Select ---</option>';

			  $select= $_POST ['lev_id'];

                $list=mysql_query("select * from leverancier order by levname asc");

				while($row_list=mysql_fetch_assoc($list)){

						echo '<option value="'.$row_list['levid'].'"';
					
					if($row_list['levid']==$select){'"selected"';} 
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
				<td><input type="checkbox" value="on" name="supply"></td>
				<td><input type="date" name="supplydate"></td>
			</tr>
			<tr>
				<th>Registration Form?</th>
				<td><input type="checkbox" value="on" name="regform"></td>
				<td><input type="date" name="regfdate"></td>
			</tr>
			<tr>
				<th>Kopper verklaring?</th>
				<td><input type="checkbox" value="on" name="copper"></td>
				<td><input type="date" name="copperdate"></td>
			</tr>
			<tr>
				<th>Ander document?</th>
				<td colspan=2><textarea rows=4 maxlenght=150 name="othdoc" style="width:334px"></textarea></td>
			</tr>
			<tr>
			  <th rowspan=6>Certificaat</th>
				<th>Global GAP</th>
				<td><input type="checkbox" value="on" name="gg"></td>
				<td><input type="date" name="ggdate"></td>
			</tr>
			<tr>
				<th>Biologisch?</th>
				<td><input type="checkbox" value="on" name="bio" required></td>
				<td><input type="date" name="biodate" required></td>
			</tr>
			<tr>
				<th>Hygiene?</th>
				<td><input type="checkbox" value="on" name="ifs"></td>
				<td><input type="date" name="ifsdate"></td>
			</tr>
			<tr>
				<th>Bio Suisse?</th>
				<td><input type="checkbox" value="on" name="bios"></td>
				<td><input type="date" name="biosdate"></td>
			</tr>
				<th>NOP?</th>
				<td><input type="checkbox" value="on" name="nop"></td>
				<td><input type="date" name="nopdate"></td>
			</tr>
			<tr>
				<th>Ander certificaat?</th>
				<td colspan="2"><textarea rows=4 maxlenght=150 name="othcert" style="width:334px"></textarea></td>
			</tr>
			<tr>
			  <th rowspan=5>Analyse</th>
				<th>Grond?</th>
				<td colspan=2><input type="checkbox" value="on" name="grond"></td>
			</tr>
			<tr>
				<th>Water?</th>
				<td colspan=2><input type="checkbox" value="on" name="water"></td>
			</tr>
			<tr>
				<th>Blad?</th>
				<td colspan=2><input type="checkbox" value="on" name="blad"></td>
			</tr>
			<th>Kies producten</th>';
	//dropdown list product
		echo '<td>
				<select id="droplist" size="10" name="pro_id[]" multiple>
					
					<option value="">--- Select ---</option>
				</select>
			</td>
			<td><button id="AddInfoPro" onclick=AddInfo("product")>Nieuw product</button></td>
			</tr>
			<tr>
				<th>Ander product?</th>
				<td colspan="2"><textarea rows=4 maxlenght=150 name="othpro" style="width:334px"></textarea></td>
			</tr>
			<tr>
				<th>Opmerkingen</th>
				<td colspan="3"><textarea rows=4 maxlenght=250 name="opmerking" style="width:474px"></textarea></td>
			</tr>
			<tr>
				<th>Synergy link</th>
				<td colspan="3"><textarea rows=2 maxlenght=250 name="synergy" style="width:474px"></textarea></td>
			</tr>
			<tr>
			  <td colspan=4 align="center"><input type="submit" name="submit" value="Opslaan"></td>
			</tr>
		</form>
	</table>';
}
?>