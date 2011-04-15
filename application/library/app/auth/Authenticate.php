
<?php

/* Klasse wordt als Singleton ge•mplementeerd */
 
class App_Auth_Authenticate
{
	protected static $_instance = null;

	private $_user;
	private $_auth;
	private $_loggedIn;
	private $_umapper;
	private $_salt = "$%^&hyu3fsdfvdvdfvmkm";
	
	
	public static function getInstance() 
	{
		if (null === self::$_instance) 
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	protected function __construct()
	{
		$this->_user = new App_Model_User();
		
		$this->_auth = Zend_Auth::getInstance();
		
		if ($this->_auth->hasIdentity()) 
		{
			$result = $this->loadUser($this->_auth->getIdentity());
			if (null != $result) {
				$this->_user = $result;
				$this->_loggedIn = true;
			} else {
				$this->logout();
			}
		} else {
			$this->_loggedIn = false;
		}
	}
	public function login($username, $password) 
	{
		try 
		{
			$this->_loggedIn = false;
			$result = Zend_Auth_Result::FAILURE;
			
			if ((is_string($username) && (strlen($username) > 0)) &&
				(is_string($password) && (strlen($password) > 0))) 
				{
				
				$authAdapter = $this->_createAuthenticationAdapter($username, $password);
				$authResult = $this->_auth->authenticate($authAdapter);
				if ($authResult->isValid()) {
					$this->_loggedIn = true;
					
					$loaded = $this->loadUser($this->_auth->getIdentity());
					
					if (null == $loaded) 
					{
						$this->logout();
					}
					
					$this->_user = $loaded;
				}
				$result = $authResult->getCode();
			}
		} catch (Exception $e) {
		
			$this->_loggedIn = false;
			$this->logout();
			throw $e;
		}
		return $result;
	}
	
	private function loadUser($identity)
	{
		if(!isset($this->_umapper))
		{
			$umapper = new App_Model_UserMapper(new App_Model_Daos_Users());
		}
		$user = $umapper->fetchFiltered($umapper->getDao()->getAdapter()->quoteInto("username = ?",$identity));
		return $user[0];
	}
	
	public function logout() 
	{
		$this->_loggedIn = false;
		if ($this->_auth == null) {
			$this->_auth = Zend_Auth::getInstance();
		}
		$this->_user = new App_Model_User();
		$this->_auth->clearIdentity();
	}

	public function isLoggedIn() 
	{
		return $this->_loggedIn;
	}
	public function getUser() 
	{
		return $this->_user;
	}
	private function _createAuthenticationAdapter($username, $password) 
	{
		$db = Zend_Registry::get('db');
		$adapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password', 'sha1(?)');
		$saltedPassword = $this->_salt . $password;
		$adapter->setIdentity($username);
		$adapter->setCredential($saltedPassword);
		return $adapter;
	}

}