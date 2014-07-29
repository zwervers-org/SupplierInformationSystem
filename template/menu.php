<?php
if(login_check($mysqli) == true) {

	echo '<div id="menu">';
	
echo '<div>
	<a href="index.php">Home</a>
	  <ul>
		<li><a href="index.php">Startpagina</a></li>
		<li><a href="index.php?page=logout">Uitloggen</a></li>
		<li><a href="index.php?page=account">Account</a></li>
	  </ul>
	</div>
		  
  <div>';
    
if (in_array($username, $admin) or in_array($username, $moderator)){
	echo '<a href="index.php?page=form">Nieuw</a>';
	include('formlist.php');
echo '</div>';

if(in_array($username, $admin)){
	echo ' <div>
	 <a href="index.php?page=productkalender">Product kalender</a>
	   <ul>
		  <li><a href="#">Zuid-Afrika</a></li>
		  <li><a href="#">China</a></li>
		</ul>
	</div>
	<div>
	<a href="index.php?page=sitemap">Sitemap</a>
	</div>';
	
}}
	else {
		echo'';}
echo '</div>

<div id=user>
'.$welkom.'        <a href="index.php?page=logout"><img src="./image/logout.gif" alt="logout" height="16" width="43"></a>
</div>';
}

else {
	echo '<div id="menu">';
	
echo '<div>
	<a href="index.php">Home</a>
	  <ul>
		<li><a href="index.php">Startpagina</a></li>
		<li><a href="index.php?page=login">Inloggen</a></li>
	  </ul>
	</div>
</div>
<div id=user>
	NIET INGELOGD
</div>';
}
?>