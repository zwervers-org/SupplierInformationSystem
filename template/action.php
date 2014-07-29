<?php	
	switch ($_GET['action']){
	case 'add':
		echo ucfirst($_GET['page']).' toegevoegt';
		break;
	case 'change':
		echo ucfirst($_GET['page']).' gewijzigd';
		break;
	case 'del':
		echo ucfirst($_GET['page']).' verwijderd';
		break;
	default:
		echo 'Er is iets gebeurd via '.$_GET['page'].', maar ik kan niet vertellen wat....';
		break;
	}
?>