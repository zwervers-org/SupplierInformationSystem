<?php
echo '<option value="">--- Select ---</option>';
if(!empty($_GET['list'])){
  if(!empty($_GET['id'])){
  include ('./../admin/db_connect.php');
    $list = $_GET['list'];
	$id = $_GET['id'];
    
	switch($list)
    {
        case 'product':{
            //get only data for the supplier
			$querylist="SELECT *
					FROM product 
					JOIN levpro ON '".$id."' = levpro.levid AND levpro.proid = product.proid";
			$sendlist=mysql_query($querylist);
			
			//set light table initials
			$listid = 'pro';
			
			$querypro = "SELECT *
					FROM prodoc
					JOIN document ON '".$id."' = document.levid AND document.docid = prodoc.docid";
			$sendpro = mysql_query($querypro);
            }
        }
	
            $ids = "";
			while ($id = mysql_fetch_array($sendpro)){
			$ids[] = $id[$listid.'id'];}

			$select= $ids;
                if ($select == ""){
				$select[]=0;}

			while($rowlist=mysql_fetch_assoc($sendlist)){

			if(in_array($row_list[$listid.'id'], $select)){echo 'yes';}
                    echo '<option value="'.$rowlist[$listid.'id'].'"';
					if(in_array($rowlist[$listid.'id'], $select)){echo 'selected';}
                    	echo'>';

					echo $rowlist[$listid.'name'];

                    echo'</option>';
				}
}}

else { 
echo $_GET['id'].'GEEN MAKELIST';}
?>