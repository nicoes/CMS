<?php
class Bootstrap extends Em_Application_Bootstrap
{
	protected function _initJavascript()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js','text/javascript');
	}
	protected function _initCSS()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->headLink()->appendStylesheet('/styles/cms/style.css');
	}
	protected function _initNavigation()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$config = new Zend_Config_Xml(APPLICATION_PATH . "/configs/navigation.xml","nav");
		$navigation = new Zend_Navigation($config);
		$view->navigation($navigation);
	}

}
?>