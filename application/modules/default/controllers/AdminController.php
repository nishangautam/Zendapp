<?php

class AdminController extends Zend_Controller_Action
{   
    protected $loginMapper=null;

    public function init()
    {
        $this->loginMapper = new Application_Model_LoginMapper();
    }

    public function logoutAction(){
        $auth=Zend_Auth::getInstance();
        $auth->clearIdentity();
$this->_helper->redirector('index','index');

    }
    public function indexAction()
    {
          $this->_helper->layout()->disableLayout();
         $form=new Application_Form_Login();
         $this->view->loginform=$form;

         if($this->getRequest()->isPost()){

            $auth=Zend_Auth::getInstance();
            $adapter=new Zend_Auth_Adapter_DbTable();
            $adapter->setTableName('login');
            $adapter->setIdentityColumn('username');
            $adapter->setCredentialColumn('password');

            // 1. set username
            $username=$this->getRequest()->getParam('username');
            $password=$this->getRequest()->getParam('password');
            $adapter->setIdentity($username);

            $password=sha1($password);

            $adapter->setCredential($password);


            $auth->authenticate($adapter);
             if(!$auth->hasIdentity()){
               throw new Exception("Not logged in"); 
               
            }
            // if($auth->hasIdentity()){
            

            $user=$this->loginMapper->getByUsername($username);
            if($user->getStatus()==Application_Model_Login::STATUS_DISABLED){
              throw new Exception("user is not enabled.");
            }            
               $this->_helper->redirector('index','index');
              // var_dump($user);die;
        // }



         }
        

    }
   

}

