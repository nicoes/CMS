<?php

class Em_Form_Basic extends Zend_Form
{

	public function __construct($options = null)
	{
		parent::__construct($options);
		
		if(!isset($options['disableHash']))
		{
	        $this->addElement('hash', 'csrf');
		}
	}

}


?>