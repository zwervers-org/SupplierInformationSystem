<?php
function sec_session_start() {
        $session_name = 'otc-organics-session'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(true); // regenerated the session, delete the old one.     
}

function login($email, $password, $mysqli) {
   // Using prepared Statements means that SQL injection is not possible. 
   if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? LIMIT 1")) { 
      $stmt->bind_param('s', $email); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($user_id, $username, $db_password, $salt); // get variables from result.
      $stmt->fetch();
      $password = hash('sha512', $password.$salt); // hash the password with the unique salt.
 
      if($stmt->num_rows == 1) { // If the user exists
         // We check if the account is locked from too many login attempts
         if(checkbrute($user_id, $mysqli) == true) { 
            // Account is locked
			return 1;
         } else {
         if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!
 
               $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
               $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
               $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
               $_SESSION['user_id'] = $user_id; 
               $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
               $_SESSION['username'] = $username;
               $_SESSION['login_string'] = hash('sha512', $password.$ip_address.$user_browser);
			   $_SESSION['useremail'] = $email;
               // Login successful.
               return true;    
         } else {
            // Password is not correct
            // We record this attempt in the database
            $now = time();
            $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
			return 2;
         }
      }
      } else {
         // No user exists.
		 return 3;
      }
   }
}

function checkbrute($user_id, $mysqli) {
   // Get timestamp of current time
   $now = time();
   // All login attempts are counted from the past 2 hours. 
   $valid_attempts = $now - (2 * 60 * 60); 
 
   if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) { 
      $stmt->bind_param('i', $user_id); 
      // Execute the prepared query.
      $stmt->execute();
      $stmt->store_result();
      // If there has been more than 5 failed logins
      if($stmt->num_rows > 5) {
         return true;
      } else {
         return false;
      }
   }
}

function login_check($mysqli) {
   // Check if all session variables are set
   if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
     $user_id = $_SESSION['user_id'];
     $login_string = $_SESSION['login_string'];
     $username = $_SESSION['username'];
     $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
     $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
 
     if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) { 
        $stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
 
        if($stmt->num_rows == 1) { // If the user exists
           $stmt->bind_result($password); // get variables from result.
           $stmt->fetch();
           $login_check = hash('sha512', $password.$ip_address.$user_browser);
           if($login_check == $login_string) {
              // Logged In!!!!			   
              return true;
           } else {
              // Not logged in
              return false;
           }
        } else {
            // Not logged in
			//echo '<script>alert("No user exists")</script>';
            return false;
        }
     } else {
        // Not logged in
		 //echo '<script>alert("No SQL preparation")</script>';
        return false;
     }
   } else {
     // Not logged in
	   //echo '<script>alert("No session made")</script>';
	   return false;
   }
}

function user_check($username, $mysqli){
	$login_string = $username;
	if ($stmt = $mysqli->prepare("SELECT username FROM members WHERE username = ? LIMIT 1")) { 
        $stmt->bind_param('i', $username); // Bind "$username" to parameter.
        $stmt->execute(); // Execute the prepared query.
        $stmt->store_result();
		if($stmt->num_rows == 1) { // If the user exists
       		$stmt->bind_result($username); // get variables from result.
       		$stmt->fetch();
       		$login_check = $username;
		
		if($login_check == $login_string){
			return true;
	}
	else {
		return false;
	}
	}
	}
	
} 

function password_check($email, $password, $mysqli){
   if ($stmt = $mysqli->prepare("SELECT password, salt FROM members WHERE email = ? LIMIT 1")) { 
      $stmt->bind_param('s', $email); // Bind "$email" to parameter.
      $stmt->execute(); // Execute the prepared query.
      $stmt->store_result();
      $stmt->bind_result($db_password, $salt); // get variables from result.
      $stmt->fetch();
      $password = hash('sha512', $password.$salt); // hash the password with the unique salt.
 
      if($stmt->num_rows == 1) { // If the user exists
         if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
            // Password is correct!
			return true;
			}
			else {
			return false;
			}
		 }
   }
}

function GetUsers ($mysqli){
	if($mysqli->setFetchMode(DB_FETCHMODE_ASSOC)){
	$stmt = $mysqli->getAll('SELECT * FROM members ORDER BY userid ACS');}
}

function overview($type, $checkbox, $date){
	switch ($type){
	case 'doc':
		if ($checkbox == 'on' AND $date == '0000-00-00'){
			return '#807F83>';
		}
		elseif ($checkbox == 'on' AND $date <= date('Y-m-d', strtotime("-1 year"))){
			return '#C41230><font color="white">'.date('d-m-Y',strtotime($date)).'</front>';
		}
		elseif ($checkbox == 'on' AND $date <= date('Y-m-d', strtotime("-1 year +6 week"))) {
			return '#FF8800><font color="white">'.date('d-m-Y',strtotime($date)).'</front>';
		}
		elseif ($checkbox == 'on' AND $date <= date('Y-m-d', strtotime("now"))) {
			return '#00703C><font color="white">'.date('d-m-Y',strtotime($date)).'</front>';
		}
		else{
			return '#FFFFFF>';
		}
		
	case 'cert':
		if ($checkbox == 'on' AND $date == '0000-00-00'){
			return '#807F83>';
		}
		elseif ($checkbox == 'on' AND $date >= date('Y-m-d', strtotime("now"))) {
			return '#00703C><font color="white">'.date('d-m-Y',strtotime($date)).'</front>';
		}
		elseif ($checkbox == 'on' AND $date <= date('Y-m-d', strtotime("-6 week"))) {
			return '#FF8800><font color="white">'.date('d-m-Y',strtotime($date)).'</front>';
		}
		elseif ($checkbox == 'on' AND $date < date('Y-m-d', strtotime("now"))){
			return '#C41230><font color="white">'.date('d-m-Y',strtotime($date)).'</front>';
		}
		else{
			return '#FFFFFF>';
		}
	
	case 'anal':
		if ($checkbox == 'on'){
			return '#00703C>';
		}
		else{
			return '#FFFFFF>';
		}
	default:
		return '#FFFFFF>';
	}
}

function info($from){
		if ($from <> ""){
			return '<img align="middle" class="info" alt="'.$from.'" 
					src="./image/info.jpg" width="32px" height="22px">
				<span>'.$from.'</span>';
		}
}

function makemonth(){
#make array
	$month = array();
#month count	
	$mc = 1;
#array number counter
$i = 0;

	while ($mc <= 12){
		$k = 1;
		
		switch ($mc){
			case 1:
				$m = "jan";
				break;
			case 2:
				$m = "feb";
				break;
			case 3:
				$m = "maa";
				break;
			case 4:
				$m = "apr";
				break;
			case 5:
				$m = "mei";
				break;
			case 6:
				$m = "jun";
				break;
			case 7:
				$m = "jul";
				break;
			case 8:
				$m = "aug";
				break;
			case 9:
				$m = "sep";
				break;
			case 10:
				$m = "okt";
				break;
			case 11:
				$m = "nov";
				break;
			case 12:
				$m = "dec";
				break;
			}

#per product per kwarter of a month		
		while ($k <= 4){
			$month[$i] = $k.'_'.$m;
			$k = $k + 1;
			$i = $i + 1;
		}
		
		$mc = $mc + 1;
	}
return $month;
}

function OrderBy(){
$month = makemonth();
$OrderByA = array();

foreach ($month as $k => $v){
	$OrderByA[$k] = 'kwar'.$v;
}

$OrderBy = implode(", ", $OrderByA);

return $OrderBy;
}

function besch($leverancier, $landid, $land, $inkoper, $nr, $supcount){
		return '<td colspan = '.$nr.' bgcolor=#00703C>
			<a href="index.php?page=landoverview&land='.$land[$supcount].'">'.$landid[$supcount].'</a>
			<span><p>Leverancier: <a href="index.php?page=levoverview&lev='.$leverancier[$supcount].'">'.$leverancier[$supcount].'</a> -
			<a href="index.php?page=landoverview&land='.$land[$supcount].'">'.$land[$supcount].'</a></p>
			<p>Inkoper: <a href="index.php?page=inkoverview&ink='.$inkoper[$supcount].'">'.$inkoper[$supcount].'</a></p></span></td>';
}

function combinetable($product){
$month = makemonth();
$OrderBy = OrderBy();
$combined = array();

	foreach ($month as $k => $v){
		$combined['kwar'.$v] = '';
	}
		
	$selectkalender = "SELECT *
				FROM beschikbaar
				WHERE proname = '".$product."'
				ORDER BY ".$OrderBy."";
	$resultkalender = mysql_query($selectkalender);
	
	while ($row = mysql_fetch_array($resultkalender)){
		foreach ($month as $k => $v){			
			if ($row['kwar'.$v] == 'on') {
				if (empty($combined['kwar'.$v])) {
					$combined['kwar'.$v] = $row['levid'];}
				else{
					$value = $combined['kwar'.$v];
					$combined['kwar'.$v] = $value. ', '. $row['levid'];}
			}
		}
	}
	
	return $combined;
}
?>