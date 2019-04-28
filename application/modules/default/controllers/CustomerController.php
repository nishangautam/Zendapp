<?php

class CustomerController extends BaseController
{
    protected $customerMapper = null;
    
    public function init()
    {
        $this->customerMapper = new Application_Model_CustomerMapper();
         parent::init();
    }
    
    public function indexAction()
    {
        $this->view->customers = $this->customerMapper->fetchAll();
    }
    public function activateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $customer = $this->customerMapper->find($id);
        
        $customer->enable();
        $this->customerMapper->save($customer);
        $this->_helper->redirector('index');
    }
     public function deactivateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $customer = $this->customerMapper->find($id);
        
        $customer->disable();
        $this->customerMapper->save($customer);
        $this->_helper->redirector('index');
    }
    public function updateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $customer = $this->customerMapper->find($id);
        $form     = new Application_Form_Customer(true);
        if (!$customer) {
            throw new Exception("customer with customer id {$id} not found.");
        }
        $form = new Application_Form_Customer(true);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getvalues();
                 $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                try {
                     $customer->setName($data['customer']);
                    $customer->setAddress($data['address']);
                    $customer->setEmail($data['email']);
                    $customer->setContact($data['contact']);
                    $customer->setImage('default_image.jpg');
                    $this->customerMapper->save($customer);

                 $fileName = $form->getElement('image')->getFileName();
                    
                    
                    $ext = $this->getExtension($fileName);
                    if (!($ext == 'png' || $ext == 'jpg' || $ext = 'jpeg')) {
                        throw new RuntimeException("Please select image.");
                    }
                    
                    $fileLocation = $form->image->getFilename();
                    $imageName    = $customer->getCustomerId() . '-' . $customer->getName() . '.' . $ext;
                    $newPath      = APPLICATION_PATH . '/../public_html/images/' . $imageName;
                    file_put_contents($newPath, file_get_contents($fileName));
                    $customer->setImage($imageName);
                    
                      $this->customerMapper->save($customer);
                    $adapter->commit();
                } catch (Exception $e) {
                    $adapter->rollBack(); 
                }
               
                $this->_helper->redirector('index');
                
            }
        }
        $form->populate($customer->toArray());
        $this->view->customerform = $form;
        
        
    }
    public function addAction()
    {
        $form = new Application_Form_Customer();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                // form is valid
                $data    = $form->getvalues();
                 $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                try {
                    $customer = new Application_Model_Customer();
                    $customer->setName($data['customer']);
                    $customer->setAddress($data['address']);
                    $customer->setEmail($data['email']);
                    $customer->setContact($data['contact']);
                    $customer->setImage('default_image.jpg');
                    $customerMapper = new Application_Model_CustomerMapper();
                    $customerMapper->save($customer);
                    
                    $fileName = $form->getElement('image')->getFileName();
                    
                    
                    $ext = $this->getExtension($fileName);
                    if (!($ext == 'png' || $ext == 'jpg' || $ext = 'jpeg')) {
                        throw new RuntimeException("Please select image.");
                    }
                    
                    $fileLocation = $form->image->getFilename();
                    $imageName    = $customer->getCustomerId() . '-' . $customer->getName() . '.' . $ext;
                    $newPath      = APPLICATION_PATH . '/../public_html/images/' . $imageName;
                    file_put_contents($newPath, file_get_contents($fileName));
                    $customer->setImage($imageName);
                    
                   $customerMapper->save($customer);
                    $adapter->commit();
                }
                catch (Exception $e) {
                    $adapter->rollBack();
                }
                
                
                
                
                $this->_helper->redirector('index');
                
            }
        }
        
        $this->view->customerform = $form;
        //action body
    }
    
    public function deleteAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $customer = $this->customerMapper->find($id);
        if (!$customer) {
            throw new Exception("No customer found.");
        }
        $this->customerMapper->deleteById($id);
        $this->_helper->redirector('index');
    }
    protected function getExtension($filePath)
    {
        $data = pathinfo($filePath);
        return $data['extension'];
    }
    
    
}
