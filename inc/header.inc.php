<!DOCTYPE html>
<?php
require_once 'sql.inc.php';
require_once 'functions.inc.php';
require_once DIR_ROOT . '/classes/user.class.php';
$date = date('D d.F.Y', time());
$week = date('W', time());
$year = date('Y', time());
$login = true;
$class = $user -> getClass();
$mode = 0;
?>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
		if ($mode == 1)
			echo '<title> Vertretungsplan' . $class . ' vom ' . $date . ' </title>';
		elseif ($mode == 0)
			echo '<title> Stundenplan ' . $class . ' (' . $week . '. Kalenderwoche) </title>';
		?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<?php
			include 'custom.style.inc.php';
		?>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
	</head>

	<body>

		<!-- Fixed navbar -->
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Planer</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<a class="navbar-brand" href="#">Stundenplan</a>
						<a class="navbar-brand" href="#">Vertretungsplan</a>

					</ul>
					<?php

					if (!$login) {
						echo '<ul class="nav navbar-nav navbar-right">
<li><a href="#">Login</a></li>
</ul>';
					} else {
						echo '<ul class="nav navbar-nav navbar-right">
<li><a href="#">Logout</a></li>
</ul>';
						echo '<ul class="nav navbar-nav navbar-right">
<li><a href="#">' . $user -> getName() . '</a></li>
</ul>';

					}
					?>
				</div><!--/.nav-collapse -->
			</div>
		</div>
		<div class="container">
			<div class="wrap">
				<!-- Main component for a primary marketing message or call to action -->
				<div class="jumbotron">
