<?php
session_start();
define('DIR_ROOT', dirname(__FILE__) . '/');
require_once DIR_ROOT . 'inc/data.inc.php';
require_once DIR_ROOT . 'inc/sql.inc.php';
require_once DIR_ROOT . 'classes/user.class.php';
$user = new User($pdo);
include 'inc/header.inc.php';
include 'classes/calendar.class.php';
$class = 1;
$extendet = 0;
$stamp = getStampFromWeek($week, $year);
$daten = array();
for($i = 0; $i < 12; $i++)
{
    if($i == 5 || $i == 6)
        continue;

    $daten[strftime('%Y-%m-%d', $stamp + 24 * 60 * 60 * $i)] = strftime('%A, %d.%m.', $stamp + 24 * 60 * 60 * $i);
}

$calendar = new Calendar($pdo, $user, $mode);
$calendar->show();
if (isset($_POST['insertB']) && $user->getLoggedIn()) { // Pressed insert button
    if (isset($_POST['insert']['class'])) {
        $tbl_name = $user->getClass() . "_planer";
    } else {
        $tbl_name = $user->getName() . "_planer";
    }
    $sql = "INSERT INTO " . $tbl_name . " (Tag,Zeit,Inhalt) VALUES (:1,:2,:3)";
    $q = $pdo->prepare($sql);
    $q->execute(array(':1' => $_POST['insert']['date'],
        ':2' => $_POST['insert']['time'],
        ':3' => $_POST['insert']['thing']));
    echo '<script type="text/javascript">window.location.href = window.location.href;</script>';
}
if ($user->getLoggedIn() && $mode != 0 && $mode != 1) {
    if ($extendet) {
        echo '
            <form action="' . $_SERVER['PHP_SELF'] . '?week=' . $week . '&year=' . $year . '" method="post" accept-charset="UTF-8">
            <input id="date" style="margin: 5px; margin-bottom: 15px;" type="text" name="insert[date]"
                  placeholder="Datum" size="30"/>
         <input id="time" style="margin: 5px; margin-bottom: 15px;" type="text" name="insert[time]"
                  placeholder="Zeit" size="30"/>
          <input id="thing" style="margin: 5px; margin-bottom: 15px;" type="text" name="insert[thing]"
                   placeholder="Aufgabe" size="30"/>
           <input id="class" style=" margin-right: 10px;" type="checkbox" name="insert[class]" value="1" /> ganze Klasse?
           <input class="btn btn-primary" style="margin: 5px; clear: left; width: 96%; height: 32px; font-size: 13px;"
                   type="submit" name="insertB" value="Aufgabe eintragen"/>
        </form> ';
    } else {
        echo '
        <form action="' . $_SERVER['PHP_SELF'] . '?week=' . $week . '&year=' . $year . '" method="post" accept-charset="UTF-8">
            <select name="insert[date]">
            ';

        foreach ($daten as $key => $val) {
            echo '<option value="' . $key . '">' . $val . '</option>'; //das erste braucht die form Y-m-d
        }
        echo '
            </select>
            <select name="insert[time]">
            ';

        foreach ($zeiten as $i) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }
        echo '
        </select>
        '.'<input id="thing" style="margin: 5px; margin-bottom: 15px;" type="text" name="insert[thing]"
                   placeholder="Aufgabe" size="30"/>
           <input id="class" style=" margin-right: 10px;" type="checkbox" name="insert[class]" value="1" /> ganze Klasse?
           <input class="btn btn-primary" style="margin: 5px; clear: left; width: 96%; height: 32px; font-size: 13px;"
                   type="submit" name="insertB" value="Aufgabe eintragen"/>
        </form> ';
    }
}
include 'inc/footer.inc.php';

?>