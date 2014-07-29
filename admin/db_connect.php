<?php

if(basename($_SERVER['PHP_SELF']) == "db_connect.php") {
	header("location: ./../index.php");
}

define("HOST", "localhost"); // The host you want to connect to.
define("USER", "sec_user"); // The database username.
define("PASSWORD", "eKcGZr59zAa2BEWU"); // The database password. 
define("DATABASE", "secure_login"); // The database name.
 
$sec_login = new mysqli(HOST, USER, PASSWORD, DATABASE);
// If you are connecting via TCP/IP rather than a UNIX socket remember to add the port number as a parameter.

//Database gegevens
$cfg = array(); // Een array aanmaken
$cfg['host'] = 'localhost'; // Meestal localhost
$cfg['user'] = 'otcsysteem'; // gebruikersnaam
$cfg['pass'] = 'OTCsysprodoc'; // Paswoord database
$cfg['db'] = 'otcsysteem'; // Database naam
$cfg['uren'] = 8; // Aantal uren ingelogd 
 
// maak verbinding met de database
$verbinding = mysql_connect($cfg['host'], $cfg['user'], $cfg['pass']);
$database = mysql_select_db($cfg['db']);
$datasql = new mysqli($cfg['host'], $cfg['user'], $cfg['pass'], $cfg['db']);
// controleren of de verbinding is gelegt
if (!$verbinding)
{die ('Er kon geen verbinding worden gemaakt: ' . mysql_error());
}

if (!$database)
{die ('Database is niet geladen: ' . mysql_error());
}
?>