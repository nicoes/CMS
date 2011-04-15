<?php
class IndexController extends Em_Controller_Action
{
	private $role;
	
    public function init()
    {
        $this->role = -1;
    }
	public function preDispatch() {
		$user= Backoffice_Model_Auth_Authenticate::getInstance()->getUser();
		if($user instanceof Backoffice_Model_User)
		{
			$this->role = $user->role;
		}
	}
    public function indexAction()
    {
         if($this->_request->isPost()) {
         	if($this->role <= 0)
         	{
	        	$uname = $this->_request->getPost('username');
	        	$password = $this->_request->getPost('password');
         		$auth = Backoffice_Model_Auth_Authenticate::getInstance();
         		if(Zend_Auth_Result::SUCCESS == $auth->login($uname, $password))
         		{
         			$this->role = $auth->getUser()->role;
         		} else 
         		{
         			$this->view->errormessage = "Verkeerde gebruikersnaam/wachtwoord combinatie";
         		}
         	}
         }
         if($this->role >= 0)
         {
         	$this->_redirect("/index/view");
         }
         $form = new Backoffice_Form_Login();
         $form->setAction($this->url);
         $this->view->form = $form;
    }
    public function viewAction()
    {
    
    }
    public function logoutAction()
    {
    	$auth = Backoffice_Model_Auth_Authenticate::getInstance();
    	$auth->logout();
    	$this->_forward("index");
    }

}
?>
