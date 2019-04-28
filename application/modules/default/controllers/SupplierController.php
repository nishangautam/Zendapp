<?php

class SupplierController extends BaseController
{
    protected $supplierMapper = null;
    
    public function init()
    {
        $this->supplierMapper = new Application_Model_SupplierMapper();
         parent::init();
    }
    
    public function indexAction()
    {
        $this->view->suppliers = $this->supplierMapper->fetchAll();
    }
    public function activateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $supplier = $this->supplierMapper->find($id);
        $supplier->enable();
        $this->supplierMapper->save($supplier);
        $this->_helper->redirector('index');
    }
    public function deactivateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $supplier = $this->supplierMapper->find($id);
        $supplier->disable();
        $this->supplierMapper->save($supplier);
        $this->_helper->redirector('index');
    }
    public function updateAction()
    {
        $id       = $this->getRequest()->getParam('id', 0);
        $supplier = $this->supplierMapper->find($id);
        $form     = new Application_Form_Supplier(true);
        if (!$supplier) {
            throw new Exception("Supplier with Supplier  id {$id} not found.");
        }
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data = $form->getvalues();
                $adapter=Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                try {
                     $supplier->setName($data['supplier']);
                $supplier->setAddress($data['address']);
                $supplier->setEmail($data['email']);
                $supplier->setContact($data['contact']);
                 $supplier->setImage('default_image.jpg');
                $this->supplierMapper->save($supplier);
                $fileName = $form->getElement('image')->getFileName();
                    
                    
                    $ext = $this->getExtension($fileName);
                    if (!($ext == 'png' || $ext == 'jpg' || $ext = 'jpeg')) {
                        throw new RuntimeException("Please select image.");
                    }
                    
                    $fileLocation = $form->image->getFilename();
                    $imageName    = $supplier->getSupplierId() . '-' . $supplier->getName() . '.' . $ext;
                    $newPath      = APPLICATION_PATH . '/../public_html/images/' . $imageName;
                    file_put_contents($newPath, file_get_contents($fileName));
                    $supplier->setImage($imageName);
                   $this->supplierMapper->save($supplier);
                    $adapter->commit();
 


                } catch (Exception $e) {
                     $adapter->rollBack();
                }
               
                $this->_helper->redirector('index');
            }
        }
        $form->populate($supplier->toArray());
        $this->view->supplierform = $form;
    }
    public function addAction()
    {
        $form = new Application_Form_Supplier();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                // form is valid
                $data     = $form->getvalues();
                 $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                try {
                                    $supplier = new Application_Model_Supplier();
                $supplier->setName($data['supplier']);
                $supplier->setAddress($data['address']);
                $supplier->setEmail($data['email']);
                $supplier->setContact($data['contact']);
                $supplier->setImage('default_image.jpg');
                $supplierMapper = new Application_Model_SupplierMapper();
                $supplierMapper->save($supplier);

                $fileName = $form->getElement('image')->getFileName();
                    
                    
                    $ext = $this->getExtension($fileName);
                    if (!($ext == 'png' || $ext == 'jpg' || $ext = 'jpeg')) {
                        throw new RuntimeException("Please select image.");
                    }
                    
                    $fileLocation = $form->image->getFilename();
                    $imageName    = $supplier->getSupplierId() . '-' . $supplier->getName() . '.' . $ext;
                    $newPath      = APPLICATION_PATH . '/../public_html/images/' . $imageName;
                    file_put_contents($newPath, file_get_contents($fileName));
                    $supplier->setImage($imageName);
                    $supplierMapper->save($supplier);
                    $adapter->commit();
                } catch (Exception $e) {
                     $adapter->rollBack();
                }

                $this->_helper->redirector('index');
                
            }
        }
        
        
        $this->view->supplierform = $form;
    }
    public function deleteAction()
    {
         $id=$this->getRequest()->getParam('id',0);
        $supplier=$this->supplierMapper->find($id);
        if(!$supplier){
            throw new Exception("No supplier found.");
        }
        $this->supplierMapper->deleteById($id);
         $this->_helper->redirector('index');
    }
     protected function getExtension($filePath)
    {
        $data = pathinfo($filePath);
        return $data['extension'];
    }
    
    
}
