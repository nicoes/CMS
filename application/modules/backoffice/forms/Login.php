<?php 
class Backoffice_Form_Login extends Em_Form_Basic
{

    public function init()
    {
    	$this->addElement('text', 'username', array(
            'label'      => 'Gebruikersnaam',
            'required'   => true
        ));
        
        $this->addElement('password', 'password', array(
            'label'      => 'Wachtwoord',
            'required'   => true
        ));
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Log in',
        ));
    }

}
?>