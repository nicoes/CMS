<?php
class Em_Application_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig()
    {
    	Zend_Registry::set('config', new Zend_Config($this->getOptions()));
    }
	protected function _initAutoStartSession() {
		$this->bootstrap('session');
		Zend_Session::start();
	}
	protected function _initDbAdapter()
	{
		$this->bootstrap('db');
		$db = $this->getResource('db');
		if ($db != null) {
			Zend_Registry::set('db', $db);
		} else {
			throw new Exception('cannot create database adapter');
		}
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
	}
}
?>