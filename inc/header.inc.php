<!DOCTYPE html>
<?php
require_once 'functions.inc.php';
require_once DIR_ROOT . '/classes/user.class.php';
//$date = date('D d.F.Y', time());
$week = isset($_REQUEST['week']) && is_numeric($_REQUEST['week']) ? sprintf('%02d', $_REQUEST['week']) : date('W', time());
$year = isset($_REQUEST['year']) && is_numeric($_REQUEST['year']) ? sprintf('%04d', $_REQUEST['year']) : date('Y', time());
$class = $user->getClass();
if (isset($_REQUEST['mode']) && is_numeric($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
} else {
    $mode = 4;
}
$user->sessionCheck();

if (isset($_POST['login'])) { // Pressed login button
    $user->login(strtolower($_POST['user']['username']), $_POST['user']['password']);
    if (!empty($_POST['user']['remember_me'])) {
        setcookie("SESSION_UNAME", strtolower($_POST['user']['username']), 60 * 60 * 24 * 365);
        setcookie("SESSION_PASSWD", $_POST['user']['password'], 60 * 60 * 24 * 365);
    }
}

if (isset($_GET['a']) && $_GET['a'] == 'logout') { // Log out
    $user->logout();
    unset($_SESSION['loggedIn']);
    session_destroy();
}

?>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php

        switch ($mode) {
            case 0:
                echo 'Stundenplan ' . $user->getClass() . ' (' . $week . '. Kalenderwoche)';
                break;
            case 1:
                echo 'Vertretungsplan ' . $user->getClass() . ' (' . $week . '. Kalenderwoche)';
                break;
            case 2:
                echo 'Aufgaben ' . $user->getName() . ' (KW ' . $week . ')';
                break;
            case 3:
                echo 'Aufgaben ' . $user->getClass() . ' (' . $week . '. Kalenderwoche)';
                break;
            case 4:
                echo 'Aufgaben ' . $user->getName() . ' / ' . $user->getClass() . ' (' . $week . '. Kalenderwoche)';
                break;
        }
        ?>
    </title>
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
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Aufgaben</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <a class="navbar-brand" href="?mode=0">Stundenplan</a>
                <!--                                             <a class="navbar-brand" href="#">Vertretungsplan</a>
               --->
            </ul>
            <?php

            if (!$user->getLoggedIn()) {
                echo '<ul class="nav navbar-nav navbar-right">
                                                                <li class="dropdown">
                                                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">Login</a>
                                                                        <ul class="dropdown-menu">
                                                                                <form action="' . $_SERVER['PHP_SELF'] . '" method="post" accept-charset="UTF-8">
                                                                                        <input id="username" style="margin: 5px; margin-bottom: 15px;" type="text" name="user[username]" placeholder="Username" size="30" />
                                                                                        <input id="password" style="margin: 5px; margin-bottom: 15px;" type="password" name="user[password]" placeholder="Password" size="30" />
                                                                                        <input id="remember_me" style="margin: 5px; margin-right: 10px;" type="checkbox" name="user[remember_me]" value="1" />
                                                                                        <label class="string optional" for="remember_me"> Remember me</label>
 
                                                                                        <input class="btn btn-primary" style="margin: 5px; clear: left; width: 96%; height: 32px; font-size: 13px;" type="submit" name="login" value="Login" />
                                                                                </form>
                                                                        </ul>
                                                                </li>
                                                           </ul>';
            } else {
                echo '<ul class="nav navbar-nav navbar-right">
<li><a href="' . $_SERVER['PHP_SELF'] . '?a=logout">Logout</a></li>
</ul>';
                echo '<ul class="nav navbar-nav navbar-right">
<li><a href="#">' . $user->getName() . '</a></li>
</ul>';

            }
            ?>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
<div class="container">
    <div class="wrap">
        <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron">