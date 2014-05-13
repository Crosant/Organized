<?php
	define('DIR_ROOT', dirname(__FILE__).'/');
	require_once  DIR_ROOT.'/classes/user.class.php';
	$user = new User();
	include 'inc/header.inc.php';
	include 'inc/calendar.class.php'
	$calendar = new Calendar($user, 0); 
	$calendar->show();
	$arr = get_defined_vars();
	print_r($arr);
	include 'inc/footer.inc.php';
	
?>