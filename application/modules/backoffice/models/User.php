<?php 
class Backoffice_Model_User extends Em_Model_Abstract
{
	protected $role = -1;
	protected $username;
	protected $id;
	
	private static $salt = "$%^&hyu3fsdfvdvdfvmkm";
	
	public function __construct()
	{
	}
	public static function saltPassword($password)
	{
		return self::$salt.password;
	}
}
