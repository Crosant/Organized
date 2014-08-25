<?php

class User
{
    protected $LoggedIn = false;
    private $Name = "";
    private $Class = "";
    private $pdo = null;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->setName("Guest");
        $this->setClass("example");
        $this->logout();
    }

    public function logout()
    {
        return $this->LoggedIn = false;
    }

    public static function createUser($pdo, $username, $password, $class)
    {
        $username = str_replace($username, "`", "");
        $class = str_replace($class, "`", "");

        if (empty($username))
            return "Supply a username";

        if (empty($password))
            return "Supply a password";

        if (empty($class))
            return "Supply a class";

        $password = md5($password);

        try {
            $sql = 'SELECT count(*) FROM `users` WHERE username = :1 OR class = :1 OR username = :2;';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(":1" => $username, ":2" => $class));

            if ($stmt->rowCount() == 0) { // No such user
                $sql = 'INSERT INTO `users` (`username`, `password`, `class`) VALUES (":1", ":2", ":3");';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(":1" => $username, ":2" => $password, ":3" => $class));

                createUserTables($pdo, $username, $class);
            }
            else
                return "Username or Class already in use";

        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return "";
    }

    public static function createUserTables($pdo, $username, $class)
    {
        try {
            $pdo->prepare("CREATE TABLE IF NOT EXISTS `{$username}_planer` (
            `Tag` date DEFAULT NULL,
  `Zeit` varchar(50) DEFAULT NULL,
  `Inhalt` varchar(50) DEFAULT NULL,
  `Entfall` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute();

            $pdo->prepare("CREATE TABLE IF NOT EXISTS `{$class}_planer` (
            `Tag` date DEFAULT NULL,
  `Zeit` varchar(50) DEFAULT NULL,
  `Inhalt` varchar(50) DEFAULT NULL,
  `Entfall` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute(array(":1" => $class . "_planer"));

            $pdo->prepare("CREATE TABLE IF NOT EXISTS `{$class}_vertretung` (
  `Tag` date DEFAULT NULL,
  `Stunde` tinyint(4) DEFAULT NULL,
  `Fach` varchar(50) DEFAULT NULL,
  `Lehrer` varchar(50) DEFAULT NULL,
  `Anmerkung` text,
  `Entfall` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute(array(":1" => $class . "_vertretung"));

            $pdo->prepare("CREATE TABLE IF NOT EXISTS `{$class}_stundenplan` (
  `Stunde` tinyint(4) NOT NULL,
  `Tag` tinyint(4) NOT NULL,
  `Fach` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute(array(":1" => $class . "_stundenplan"));

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getClass()
    {
        return $this->Class;
    }

    public function setClass($class)
    {
        return $this->Class = $class;
    }

    public function getLoggedIn()
    {
        return $this->LoggedIn;
    }

    public function login($username, $password)
    {
        try {
            $sql = 'SELECT * FROM `users` WHERE username = :1;';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(":1" => $username));
            var_dump($stmt);
            if ($stmt->rowCount() != 1) { // No such user
                $this->LoggedIn = false;
                $_SESSION['loggedIn'] = false;
                return false;
            }
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results[0]['password'] == md5($password)) { // Logged in
                $this->LoggedIn = true;
                $this->setName($username);
                $this->setClass($results[0]['class']);

                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['class'] = $results[0]['class'];
                $_SESSION['admin'] = $results[0]['admin'];
                return true;
            } else { // Wrong password
                $this->LoggedIn = false;
                $_SESSION['loggedIn'] = false;
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

        return false;

        //return $this->LoggedIn = true;
    }

    public function sessionCheck()
    {
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            $this->LoggedIn = true;
            $this->setName($_SESSION['username']);
            $this->setClass($_SESSION['class']);
        }
    }

    public function isAdmin()
    {
        return $_SESSION['admin'] == 1;
    }
}

?>