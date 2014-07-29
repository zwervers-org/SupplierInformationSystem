
<img src="./image/logo.gif" name="Logo">

<?php 
if(login_check($mysqli) == false) {
echo $title; 
}
else{
echo 'Document overzicht';
}
	?>