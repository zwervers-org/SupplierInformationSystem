<?php
If (isset($_GET['error'])){
   echo '<div id=error>';
	switch ($_GET['error']){
		case "0":
		//echo '<script>var bericht ('Wijziging gelukt');
		//		var dialog = $(foo).dialog('open');
		//		setTimeout(function() { dialog.dialog('close'); }, 5000);</script>';
		//message(dialog;);
			break;
		
		case "1":
			//echo '<script>alert("Fout bij wijzigen - Koppeling: Ok | Result: leeg")</script>';
			echo 'Fout bij wijzigen - Koppeling: Ok | Result: leeg';
			break;
		
		case "2":
			//echo '<script>alert("Fout bij wijzigen - Koppeling: Ok | Result: Invoer waarden > 1")</script>';
			echo 'Fout bij wijzigen - Koppeling: Ok | Result: Invoer waarden > 1';
			break;
		
		case "3":
			//echo '<script>alert("Fout bij wijzigen - Koppeling: Database connectie mislukt")</script>';	
			echo 'Fout bij wijzigen - Koppeling: Database connectie mislukt';	
			break;
		
		case "9":
			//echo '<script>alert("Fout bij wijzigen - Koppeling: OK | Result: formulier niet herkend")</script>';	
			echo 'Fout bij wijzigen - Koppeling: OK | Result: formulier niet herkend';	
			break;
		
		default:
			echo '<script>alert("Onbekende fout bij invoer - END ERROR")</script>';
			echo 'Onbekende fout bij invoer - END ERROR';
			break;
	}
	echo '</div>';
}
?>