 <?php

class OT_View_Helper_Text
{
	private $langapp;
	
	public function __construct()
	{
        $lang = new Zend_Session_Namespace('Lang');
		if(file_exists(APPLICATION_PATH."/../library/OT/Language/".$lang->taal.".php"))
		{
			include(APPLICATION_PATH."/../library/OT/Language/".$lang->taal.".php");
			$this->langapp = $langapp;
		} else
		{
			die("language doesn't exist");
		}
	
	}
	
	public function text($tag)
	{
		return UCFirst($this->langapp[$tag]);
	}


}

?>