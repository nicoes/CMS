<?php
class Frontoffice_Bootstrap extends Em_Application_Module_Bootstrap
{
	protected function _initLibraryAutoloader()
	{
		return $this->getResourceLoader()->addResourceType('library','library','library');
	}
}