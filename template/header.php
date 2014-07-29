
<img src="./image/logo.gif" name="Logo">

<?php 
if(login_check($sec_login) == true) {
echo $title; 
}
else{
echo 'Log in';
}
	?>