<script type="text/javascript" src="./script/sha512.js"></script>
<?php
if(isset($_GET['LogInError'])) { 
   switch ($_GET['LogInError']){
		case "0":
		 echo 'Invaild request!';
		 break;
		
		case "1":
		 echo 'Account is locked. To many wrong logins! Wait for 2 ours and try again.';
		 break;
		 
		case "2":
		 echo 'Wrong password! Try an other password.';
		 break;
		
		case "3":
		 echo 'E-mail is not registerd jet. Contact the webmaster to register you.';
		 break;
		 
		default:
		 echo 'something whent wrong';
		 break;
}}
?>
<div id="login">
<form action="./input/verwerken/login.php" method="post" name="login_form">
   Email: <input type="email" name="email" required placeholder=" E-mail address"/><br />
   Password: <input type="password" name="password" id="password" required placeholder=" Password"/><br />
   <input type="submit" value="Login" onclick="formhash(this.form, this.form.password);" />
</form>
</div>