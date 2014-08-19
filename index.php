<?php
	define('DIR_ROOT', dirname(__FILE__).'/');
	require_once  DIR_ROOT.'/classes/user.class.php';
	$user = new User();
	include 'inc/header.inc.php';
	include 'classes/calendar.class.php';
	$calendar = new Calendar($pdo, $user, 2); 
	$calendar->show();
	include 'inc/footer.inc.php';
	
?>