<?php 
class App_Model_UserMapper extends Em_Model_Mapper_Db_Basic
{
    protected $_basemodel = "App_Model_User";
	
	public function save($user)
	{
		if(!($user instanceof App_Model_User))
		{
			throw new Exception("Model is not of type App_Model_User");
		}
		if($user->getId() < 0)
		{
			$user->setPassword($user::saltPassword($user->getPassword()));
		}
		parent::save($user);
	}
	
} 
