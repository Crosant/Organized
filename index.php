<?php
session_start();
define('DIR_ROOT', dirname(__FILE__) . '/');
require_once DIR_ROOT . 'inc/sql.inc.php';
require_once DIR_ROOT . 'classes/user.class.php';
$user = new User($pdo);
include 'inc/header.inc.php';
include 'classes/calendar.class.php';
$calendar = new Calendar($pdo, $user, 4);
$calendar->show();
$class = 1;
if(isset($_POST['insertB']) && $user->getLoggedIn()) { // Pressed insert button
    if( $_POST['insert']['class']){
        $tbl_name = $user->getClass() . "_planer";
    }
    else {
        $tbl_name = $user->getName() . "_planer";
    }
    $sql = "INSERT INTO " . $tbl_name . " (Tag,Zeit,Inhalt) VALUES (:1,:2,:3)";
    $q = $pdo->prepare($sql);
    $q->execute(array(':1' => $_POST['insert']['date'],
                       ':2' => $_POST['insert']['time'],
                        ':3' => $_POST['insert']['thing']));
    header("Refresh:0");
}
if($user->getLoggedIn()){
echo '
    <form action="' . $_SERVER['PHP_SELF'] . '" method="post" accept-charset="UTF-8">
        <input id="date" style="margin: 5px; margin-bottom: 15px;" type="text" name="insert[date]"
               placeholder="Tag YYYY-MM-DD" size="30"/>
        <input id="time" style="margin: 5px; margin-bottom: 15px;" type="text" name="insert[time]"
               placeholder="Zeit eg. 00:00-20:30" size="30"/>
        <input id="thing" style="margin: 5px; margin-bottom: 15px;" type="text" name="insert[thing]"
               placeholder="Inhalt" size="30"/>
        <input id="class" style=" margin-right: 10px;" type="checkbox" name="insert[class]" value="1" /> Klasse?
        <input class="btn btn-primary" style="margin: 5px; clear: left; width: 96%; height: 32px; font-size: 13px;"
               type="submit" name="insertB" value="Insert"/>
    </form> ';
}
include 'inc/footer.inc.php';

?>