<?php

class LoginController extends BaseController
{   
    protected $loginMapper=null;

    public function init()
    {
        $this->loginMapper = new Application_Model_LoginMapper();
        parent::init();
    }

   public function activateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $customer = $this->loginMapper->find($id);
        
        $customer->enable();
        $this->loginMapper->save($customer);
        $this->_helper->redirector('view');
    }
    public function deactivateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $customer = $this->loginMapper->find($id);
        
        $customer->disable();
        $this->loginMapper->save($customer);
        $this->_helper->redirector('view');
    }
    public function updateAction()
    {
        $id=$this->getRequest()->getParam('id',0);
        $login=$this->loginMapper->find($id);
        if(!$login){
            throw new Exception("Login with login id {$id} not found");
            
        }
        $form=new Application_Form_Loginadd(true);
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getPost())){
                $data=$form->getValues();
               $password=$this->getRequest()->getParam('password');
               $confirm=$this->getRequest()->getParam('confirmpassword');
              $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                 try {
                          $login->setUserName($data['username']);
                           if(strcmp($password,$confirm)!==0){
                        throw new Exception("password did not match");

                       }
                       
                          $password=sha1($password);
                          $login->setPassword($password);
                         $login->setEmail($data['email']);
                        $this->loginMapper->save($login);
                 
                  
                
                $adapter->commit();
                 }
                 catch (Exception $e) {
                    $adapter->rollBack(); 
                    throw $e;
                }
                
                $this->_helper->redirector('view');
            }
        }
    	$form->populate($login->toArray());
        $this->view->loginform=$form;
    }
    public function addAction()
    {
       $form=new Application_Form_Loginadd();
       if($this->getRequest()->isPost()){
        if($form->isValid($this->getRequest()->getPost())){
            $data=$form->getValues();
              $password=$this->getRequest()->getParam('password');
              $confirm=$this->getRequest()->getParam('confirmpassword');

              $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                 try {

                    $login= new Application_Model_Login();
                    $login->setUserName($data['username']);
                    
                    if(strcmp($password,$confirm)!==0){
                        throw new Exception("password did not match");
                    }

                        
                     $password=sha1($password);
                    $login->setPassword($password);
                    // $login->setPassword($data['password']);
                    $login->setEmail($data['email']);
                    $loginMapper= new Application_Model_LoginMapper();

                    $loginMapper->save($login);
                   
                     $adapter->commit();

                 }
                 catch (Exception $e) {
                    $adapter->rollBack(); 
                    throw $e;
                }
           
            $this->_helper->redirector('view');
        }
       }


         $this->view->loginform=$form;
    }
    public function viewAction(){

       $data                        = $this->loginMapper->fetchall();
        $this->view->logins       = $data;
    }
     public function deleteAction(){
        $id=$this->getRequest()->getParam('id',0);
        $login=$this->loginMapper->find($id);
        if(!$login){
            throw new Exception("No logins found.");
        }
        $this->loginMapper->deleteById($id);
         $this->_helper->redirector('view');
    }


}

