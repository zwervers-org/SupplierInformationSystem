<?php
function wijzigen (){
	
	$userid = $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$useremail = $_SESSION['useremail'];
			
		echo '<table align="center"><tr>
			<th colspan=2><h1>Gebruiker wijzigen</h1></th>
			</tr>	<tr>
			<table align="center">
			<form action="./input/verwerken/registreren.php" method="post">
			<input type="hidden" name="change" value="userchange">';
	
		echo '<tr>	<th>ID</th>	<td>';
		echo '<input type="text" name="userid" size="40" readonly="readonly" value="';
		echo $userid;
		
	echo '"></tr>	<tr>	<th>Naam</th>	<td>';
		echo '<input type="text" name="username" size="40" required value="';
		echo $username;
			
		echo '" placeholder=" Username"></tr>	<tr>	<th>E-mail</th>	<td>';
		echo '<input type="email" name="email" size="40" required value="';
		echo $useremail;
		echo '" placeholder=" E-mail address"></tr>';
		echo '<tr>	<th>Old password</th>	<td>';
		echo '<input type="password" name="oldpassword" size="40" id="oldpassword" required placeholder=" Old password">';
		echo '</tr>';
		echo '<tr>	<th>New password</th>	<td>';
		echo '<input type="password" name="newpassword" size="40" id="newpassword" required placeholder=" New password">';
		echo '</td></tr>';
	
		echo '<tr><td colspan=2><input type="submit" value="Wijzigen" onclick="reghash(this.form, this.form.oldpassword, this.form.newpassword)" /></td></tr>';
		echo '	</table>
					</table>
						</form>';

}

function users (){	
	echo '<table align="center">
		<form method="post" action="index.php?registreren">
			<input type="hidden" name="change" value="memb_change">
		<tr><th colspan=4><h1>Aanwezige gebruikers</h1></th></tr>
		<tr><th><input type="submit" name="submit" value="Change"></th>
		<th>ID</th><th>Naam</th><th>E-mail</th></tr>';

	foreach ($GetUsers($sec_login) as $row) {
		echo '<td width="10px"><center><input type="radio" name="userid" value= ',$row['id'], '></center></td>';
		echo '<td><center>';
		echo $row['id'] ;
			echo '</center></td><td>' ;
		echo $row['name'] ;
			echo '</td><td>' ;
		echo $row['email'] ;
			echo '</td></tr>';
	}
	echo '</table></form>';
}
	
function toevoegen (){
	echo '<table align="center">
		  <tr>
		<th colspan=2><h1>Gebruiker toevoegen</h1></th>
		  </tr>
				<form method="post" action="./input/verwerken/registreren.php">
				<tr>
				  <th>Naam</th>
				  <td><input type="text" name="username" size="40" requered placeholder=" Username"></td>
				</tr>
				<tr>
				  <th>Email</th>
				  <td><input type="text" name="email" size="40" requered placeholder=" E-mail address"></td>
				</tr>
				<tr>
				  <th>Password</th>
				  <td><input type="password" name="password" id="password" size="40" requered placeholder=" Password"></td>
				</tr>
				</td> </tr><tr>
				  <td colspan=2 align="right">
					<input type="button" value="Registreer" onclick="formhash(this.form, this.form.password)" /></td>
				</tr>
			</form>
		  </table>';
}
			
	
if (in_array($username, $admin)){
	
	if (isset($_GET['changeusr'])){
		wijzigen();
	
	}	

	else {
		//users();
		echo '<input type="button" value="Change your account" onclick=location.href="index.php?page='.$_GET['page'].'&changeusr=yes">';
		toevoegen();

	}}

elseif (in_array($username, $moderator)){
	if (isset($_GET['changeusr'])){
		if($_GET['changeusr'] == 'no'){
			echo '<input type="button" value="Change your account" onclick=location.href="index.php?page='.$_GET['page'].'&changeusr=yes">';
			toevoegen();}
		else{
			echo '<button onclick=location.href="index.php?page='.$_GET['page'].'&changeusr=no">Register an account</button>';
			wijzigen();}
	}	

	else {
		echo '<button onclick=location.href="index.php?page='.$_GET['page'].'&changeusr=no">Register an account</button>';
		wijzigen();

	}}
	
else {
	wijzigen();}

?>