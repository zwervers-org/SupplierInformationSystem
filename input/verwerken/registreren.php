<?php 

include './../../admin/db_connect.php';
include './../../script/functions.php';

// Change for is used
if (isset($_POST['change'])){
// Check if old password is correct
	$email = $_POST['email'];
	$oldpassword = $_POST['pold']; // The hashed oldpassword.
	$userid = $_POST['userid'];
	$username = $_POST['username'];
	$newpassword = $_POST['pnew'];

	if(password_check($email, $oldpassword, $mysqli) == true) {
		// Old password is correct
	if ($oldpassword !== $newpassword) {
		// passwords are different
			
		// Get the salt
			if ($stmt = $mysqli->prepare("SELECT salt FROM members WHERE id = ? LIMIT 1")) { 
			  $stmt->bind_param('s', $userid); // Bind "$email" to parameter.
			  $stmt->execute(); // Execute the prepared query.
			  $stmt->store_result();
			  $stmt->bind_result($salt); // get variables from result.
			  $stmt->fetch();
		}

		// Create salted password (Careful not to over season)
		$pwdnew = hash('sha512', $newpassword.$salt);
			
		// Add your update to database script here. 
		// Make sure you use prepared statements!
		if ($update_stmt = $mysqli->prepare("UPDATE members SET username=?, email=?, password=? WHERE id=?")) {
			$update_stmt->bind_param('sssi', $username, $email, $pwdnew, $userid); 
		   // Execute the prepared query.
		   $update_stmt->execute();
		}
		
		if (user_check($username, $mysqli) == true){

			if(password_check($email, $newpassword, $mysqli) == true) {
				echo '<script>alert("',$username ,' gewijzigd")</script>';
				login($email, $newpassword, $mysqli);
			}
			else {
				echo '<br /> userid| '.$userid;
				echo '<br /> username| '.$username;
				echo '<br / > email| '.$email;
				echo '<br / > salt| '.$salt ;
				echo '<br / > hassold| '.$oldpassword;
				echo '</br></br> hasspw| '.$newpassword .'</br>saltnew| '.$pwdnew;
				echo '<script>alert("',$username ,' niet gewijzigd")</script>';	
			}
		}
		else {
				echo '<script>alert("',$username ,' bestaat niet")</script>';	
			}
	echo '<meta http-equiv="refresh" content="0;URL=./../../index.php">';
	}
	//passwords are the same
	else{
	echo '<script>alert("You used the same password, as old and new")</script>';
	echo '<meta http-equiv="refresh" content="0;URL=./../../index.php?page=registreren&changeusr=yes">';
	}}
	//old password is incorrect
	else{
			echo '<br /> userid| '.$userid;
			echo '<br /> username| '.$username;
			echo '<br / > email| '.$email;
			echo '<br / > salt| '.$salt ;
			echo '<br / > hassold| '.$oldpassword .'</br>saltold| '.$pold;
			echo '<br / > hasspw| '.$newpassword .'</br>saltnew| '.$pnew;
			echo '<script>alert("verder")</script>';
	echo '<script>alert("',$username ,' heeft een ander wachtwoord")</script>';
	echo '<meta http-equiv="refresh" content="0;URL=./../../index.php?page=registreren&changeusr=yes">';
	}
}

// New user is submitted
else {
$email = $_POST['email'];
$username = $_POST['username'];
// The hashed password from the form
$password = $_POST['p']; 
// Create a random salt
$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
// Create salted password (Careful not to over season)
$password = hash('sha512', $password.$random_salt);
 
// Add your insert to database script here. 
// Make sure you use prepared statements!
if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt) VALUES (?, ?, ?, ?)")) {    
   $insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt); 
   // Execute the prepared query.
   $insert_stmt->execute();
}

if (user_check($username, $mysqli) == true){
	echo '<script>alert("',$username ,' aangemaakt")</script>';
	echo '<meta http-equiv="refresh" content="0;URL=./../../index.php">';	
}
else {
	echo '<br /> username| '.$username;
	echo '<br / > email| '.$email;
	echo '<br / > salt| '.$random_salt ;
	echo '<br / > saltedpass| '.$password .'</br>hassedpass| '.$_POST['p'];
	echo '<script>alert("',$username ,' kan niet worden aangemaakt")</script>';
	echo '<meta http-equiv="refresh" content="0;URL=./../../index.php">';	
}
}

?>