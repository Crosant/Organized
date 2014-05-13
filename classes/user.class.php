<?php
class User
{
    private $Name = "";
    private $Class = "";
	protected $LoggedIn = false;
    
	public function __construct()
	{
		$this->setName("Guest");
		$this->setClass("Example");
		$this->logout();
	}
	
	public function getName()
	{
		return $this->name;
	}
	public function getClass()
	{
		return $this->{'Class'};
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
		return $this->{'Class'} = $class;
	}
	public function login()
	{
		return $this->LoggedIn = true;
	}
	public function logout()
	{
		return $this->LoggedIn = false;
	}	
}
?>