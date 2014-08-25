<?php
session_start();
define('DIR_ROOT', dirname(__FILE__) . '/');
require_once DIR_ROOT . 'inc/data.inc.php';
require_once DIR_ROOT . 'inc/sql.inc.php';
require_once DIR_ROOT . 'classes/user.class.php';

$user = new User($pdo);
$user->sessionCheck();
require 'inc/header.inc.php';

if ($user->getLoggedIn() && $user->isAdmin()) {
    if (isset($_REQUEST['insert'])) {
        $data = $_REQUEST['user'];

        User::createUser($pdo, $data["username"], $data["password"], $data["class"]);
    }

    if (isset($_REQUEST['migrateUsers'])) {
        $sql = 'SELECT * FROM `users`;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $user) {
            User::createUserTables($pdo, $user["username"], $user["class"]);
        }
    }

    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" accept-charset="UTF-8">
        <input id="username" style="margin: 5px; margin-bottom: 15px;" type="text" name="user[username]"
               placeholder="Username" size="30"/>
        <input id="password" style="margin: 5px; margin-bottom: 15px;" type="password" name="user[password]"
               placeholder="Password" size="30"/>
        <input id="class" style="margin: 5px; margin-bottom: 15px;" type="text" name="user[class]" placeholder="Class"
               size="30"/>
        <input class="btn btn-primary" style="margin: 5px; clear: left; width: 96%; height: 32px; font-size: 13px;"
               type="submit" name="insert" value="insert"/>
    </form>
<?php
}
require 'inc/footer.inc.php';
?>