<?php
 
class User
{
    private $Name = "";
    private $Class = "";
    private $pdo = null;
    protected $LoggedIn = false;
 
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->setName("Guest");
        $this->setClass("example");
        $this->logout();
    }
 
    public function getName()
    {
        return $this->name;
    }
 
    public function getClass()
    {
        return $this->Class;
    }
 
    public function getLoggedIn()
    {
        return $this->LoggedIn;
    }
 
    public function setName($name)
    {
        return $this->name = $name;
    }
 
    public function setClass($class)
    {
        return $this->Class = $class;
    }
 
    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM `users` WHERE username = \"" . $username . "\";";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount() == 0) { // No such user
                $this->LoggedIn = false;
                $_SESSION['loggedIn'] = false;
                return false;
            } else if($stmt->rowCount() > 1) { // Multiple users with the same name, shouldn't happen but just to be secure..
                $this->LoggedIn = false;
                $_SESSION['loggedIn'] = false;
                return false;
            }
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
            if($results[0]['password'] == md5($password)) { // Logged in
                $this->LoggedIn =  true;
                $this->setName($username);
                $this->setClass($results[0]['class']);
 
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['class'] = $results[0]['class'];
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
 
    public function logout()
    {
        return $this->LoggedIn = false;
    }
 
    public function sessionCheck()
    {
        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            $this->LoggedIn = true;
            $this->setName($_SESSION['username']);
            $this->setClass($_SESSION['class']);
        }
    }
 
}
 
?>