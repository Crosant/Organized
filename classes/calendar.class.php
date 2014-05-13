<?php
class Calendar
{
	private $user = '';
	private $mode = '';
	
	public function __construct($user, $mode)
	{
		$this->user = $user;
		$this->mode = $mode;
	}
}
?>