<?php

//add data to sql
if (isset($_POST['lev_id'])){

$query = "INSERT INTO beschikbaarheid 
			(kwar1_jan, kwar2_jan, kwar3_jan, kwar4_jan,
			kwar1_feb, kwar2_feb, kwar3_feb, kwar4_feb,
			kwar1_maa, kwar2_maa, kwar3_maa, kwar4_maa,
			kwar1_apr, kwar2_apr, kwar3_apr, kwar4_apr,
			kwar1_mei, kwar2_mei, kwar3_mei, kwar4_mei,
			kwar1_jun, kwar2_jun, kwar3_jun, kwar4_jun,
			kwar1_jul, kwar2_jul, kwar3_jul, kwar4_jul,
			kwar1_aug, kwar2_aug, kwar3_aug, kwar4_aug,
			kwar1_sep, kwar2_sep, kwar3_sep, kwar4_sep,
			kwar1_okt, kwar2_okt, kwar3_okt, kwar4_okt,
			kwar1_nov, kwar2_nov, kwar3_nov, kwar4_nov,
			kwar1_dec, kwar2_dec, kwar3_dec, kwar4_dec)
		  VALUES
			('$_POST[kwa1_jan]', '$_POST[kwa2_jan]', '$_POST[kwa3_jan]', '$_POST[kwa4_jan]', 
			'$_POST[kwa1_feb]', '$_POST[kwa2_feb]', '$_POST[kwa3_feb]', '$_POST[kwa4_feb]', 
			'$_POST[kwa1_maa]', '$_POST[kwa2_maa]', '$_POST[kwa3_maa]', '$_POST[kwa4_maa]', 
			'$_POST[kwa1_apr]', '$_POST[kwa2_apr]', '$_POST[kwa3_apr]', '$_POST[kwa4_apr]', 
			'$_POST[kwa1_mei]', '$_POST[kwa2_mei]', '$_POST[kwa3_mei]', '$_POST[kwa4_mei]', 
			'$_POST[kwa1_jun]', '$_POST[kwa2_jun]', '$_POST[kwa3_jun]', '$_POST[kwa4_jun]', 
			'$_POST[kwa1_jul]', '$_POST[kwa2_jul]', '$_POST[kwa3_jul]', '$_POST[kwa4_jul]', 
			'$_POST[kwa1_aug]', '$_POST[kwa2_aug]', '$_POST[kwa3_aug]', '$_POST[kwa4_aug]', 
			'$_POST[kwa1_sep]', '$_POST[kwa2_sep]', '$_POST[kwa3_sep]', '$_POST[kwa4_sep]', 
			'$_POST[kwa1_okt]', '$_POST[kwa2_okt]', '$_POST[kwa3_okt]', '$_POST[kwa4_okt]', 
			'$_POST[kwa1_nov]', '$_POST[kwa2_nov]', '$_POST[kwa3_nov]', '$_POST[kwa4_nov]', 
			'$_POST[kwa1_dec]', '$_POST[kwa2_dec]', '$_POST[kwa3_dec]', '$_POST[kwa4_dec]')";

//make new product
$new = mysql_query($query);	//order executes

//get new id number	
$NewId = mysql_insert_id();
//echo 'Niew aangemaakte id: '.$NewId;

//put data in connection table
$base_id = $_POST['lev_id'];
$array_id = $_POST['pro_id'];

$i = count($array_id)-1;

while ($i >= 0) {

	$put_id = $array_id[$i];

	$queryconntable = "INSERT INTO probesch (proid, beschid, levid) VALUES ('".$put_id."', '".$NewId."', '".$base_id."')";
	$conntablenew = mysql_query($queryconntable);

		if ($conntablenew == false) 
		{
			echo showSQLError($queryconntable,mysql_error(),'Fout met database.');
			goto End;
		}

	$i = $i -1;
}

if ($new == false) 
{
    echo showSQLError($query,mysql_error(),'Fout met database.');
}

else {
	echo '<meta http-equiv="refresh" content="0;URL=./index.php?page='.$_GET['page'].'&action=add">';
}
End:
}

//make table to insert data
else {
echo '
<table align="center">
	<form method="POST" action="index.php?page=beschikbaarheid">

		<tr>	<th colspan="5">
			<h1>Beschikbaarheid van producten aangeven</h1>
		</th>	</tr>
		<tr>	<th>
			Kies leverancier
		</th>	<td colspan=4>
			<select id="leverancier" size="1" Name="lev_id" onchange=DependDropList(this.value,"product") required>
			<option value="">--- Select ---</option>';

			  $select= $_POST ['lev_id'];

                $list=mysql_query("SELECT * FROM leverancier ORDER BY levname ASC");

            while($lev_list=mysql_fetch_assoc($list)){

                    echo '<option value="'.$lev_list['levid'].'"';
				
				if($lev_list['levid']==$select){echo '"selected"';} 
					echo '>';

					echo $lev_list['levname'];

                    echo'</option>';

				}
echo '
			</select>
		</td>	</tr>
		
        <tr>	<th>
			Kies product
		</th>	<td colspan=4>
		<select id="droplist" size="3" Name="pro_id[]" multiple required>
			<option value="">--- Select ---</option>
			</select>
		</td>	</tr>
		<tr>
          <th>Januari</th>	<td>
			<input type="checkbox" value="on" name="kwa1_jan">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_jan">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_jan">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_jan">
            </td>	</tr>
		<tr>
          <th>Februari</th>	<td>
			<input type="checkbox" value="on" name="kwa1_feb">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_feb">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_feb">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_feb">
            </td>	</tr>
		<tr>
          <th>Maart</th>	<td>
			<input type="checkbox" value="on" name="kwa1_maa">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_maa">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_maa">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_maa">
            </td>	</tr>
		<tr>
          <th>April</th>	<td>
			<input type="checkbox" value="on" name="kwa1_apr">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_apr">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_apr">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_apr">
            </td>	</tr>
		<tr>
          <th>Mei</th>	<td>
			<input type="checkbox" value="on" name="kwa1_mei">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_mei">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_mei">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_mei">
            </td>	</tr>
		<tr>
          <th>Juni</th>	<td>
			<input type="checkbox" value="on" name="kwa1_jun">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_jun">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_jun">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_jun">
            </td>	</tr>
		<tr>
          <th>Juli</th>	<td>
			<input type="checkbox" value="on" name="kwa1_jul">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_jul">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_jul">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_jul">
            </td>	</tr>
		<tr>
          <th>Augustus</th>	<td>
			<input type="checkbox" value="on" name="kwa1_aug">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_aug">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_aug">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_aug">
            </td>	</tr>
		<tr>
          <th>September</th>	<td>
			<input type="checkbox" value="on" name="kwa1_sep">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_sep">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_sep">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_sep">
            </td>	</tr>
		<tr>
          <th>Oktober</th>	<td>
			<input type="checkbox" value="on" name="kwa1_okt">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_okt">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_okt">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_okt">
            </td>	</tr>
		<tr>
          <th>November</th>	<td>
			<input type="checkbox" value="on" name="kwa1_nov">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_nov">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_nov">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_nov">
            </td>	</tr>
		<tr>
          <th>December</th>	<td>
			<input type="checkbox" value="on" name="kwa1_dec">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa2_dec">
            </td>	<td>
           	<input type="checkbox" value="on" name="kwa3_dec">
            </td>	<td>
			<input type="checkbox" value="on" name="kwa4_dec">
            </td>	</tr>
		<tr>	<td colspan="5" align="center">
			<button align="right" formmethod="POST" type="submit" formaction=./index.php?page='.$_GET['page'].'>
						Opslaan</button>
		</td>	</tr>
	</form>
</table>';
}
?>