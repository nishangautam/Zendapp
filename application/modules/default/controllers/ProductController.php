<?php

class ProductController extends BaseController
{
    protected $productMapper = null;
    
    
    public function init()
    {
        $this->productMapper = new Application_Model_ProductMapper();
         parent::init();
    }
    
    public function indexAction()
    {
        $this->view->products = $this->productMapper->fetchall();
        
    }
    public function activateAction()
    {
        $id      = $this->getRequest()->getParam('id', 0);
        $product = $this->productMapper->find($id);
        
        $product->enable();
        $this->productMapper->save($product);
        $this->_helper->redirector('index');
    }
      public function deactivateAction()
    {
        $id      = $this->getRequest()->getParam('id', 0);
        $product = $this->productMapper->find($id);
        
        $product->disable();
        $this->productMapper->save($product);
        $this->_helper->redirector('index');
    }
    public function updateAction()
    {
        $id      = $this->getRequest()->getParam('id', 0);
        $product = $this->productMapper->find($id);
        $form    = new Application_Form_Product(true);
        if (!$product) {
            throw new Exception("Product with product id {$id} not found.");
        
        }
        $form = new Application_Form_Product(true);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data    = $form->getValues();
                $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                
                try {
                    $product->setName($data['product']);
                    $product->setPrice($data['price']);
                    $product->setCategoryId($data['category_id']);
                    $product->setImage('default_image.jpg');
                    $this->productMapper->save($product);
                    
                    $fileName = $form->getElement('image')->getFileName();
                    
                    
                    $ext = $this->getExtension($fileName);
                    if (!($ext == 'png' || $ext == 'jpg' || $ext = 'jpeg')) {
                        throw new RuntimeException("Please select image.");
                    }
                    
                    
                    $fileLocation = $form->image->getFilename();
                    $imageName    = $product->getProductId() . '-' . $product->getName() . '.' . $ext;
                    $newPath      = APPLICATION_PATH . '/../public_html/images/' . $imageName;
                    file_put_contents($newPath, file_get_contents($fileName));
                    $product->setImage($imageName);
                    $this->productMapper->save($product);
                    $adapter->commit();
                    
                }
                catch (Exception $e) {
                    $adapter->rollBack();
                }
                
                $this->_helper->redirector('index');
            }
        }
        $form->populate($product->toArray());
        // die(var_dump($product->toArray()));
        $this->view->productform = $form;
        
    }
    public function addAction()
    {
        //action body
        $form = new Application_Form_Product();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $data    = $form->getValues();
                $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                try {
                    $product = new Application_Model_Product();
                    $product->setName($data['product']);
                    $product->setPrice($data['price']);
                    $product->setCategoryId($data['category_id']);
                    $product->setImage('default_image.jpg');
                    $productMapper = new Application_Model_ProductMapper();
                    $productMapper->save($product);
                    
                    
                    $fileName = $form->getElement('image')->getFileName();
                    
                    
                    $ext = $this->getExtension($fileName);
                    if (!($ext == 'png' || $ext == 'jpg' || $ext = 'jpeg')) {
                        throw new RuntimeException("Please select image.");
                    }
                    
                    
                    $fileLocation = $form->image->getFilename();
                    $imageName    = $product->getProductId() . '-' . $product->getName() . '.' . $ext;
                    $newPath      = APPLICATION_PATH . '/../public_html/images/' . $imageName;
                    file_put_contents($newPath, file_get_contents($fileName));
                    $product->setImage($imageName);
                    $productMapper->save($product);
                    $adapter->commit();
                }
                catch (Exception $e) {
                    $adapter->rollBack();
                }
                
                $this->_helper->redirector('index');
            }
        }
        
        $this->view->productform = $form;
    }
    public function deleteAction()
    {
        $id      = $this->getRequest()->getParam('id', 0);
        $product = $this->productMapper->find($id);
        if (!$product) {
            throw new Exception("No product found.");
        }
        $this->productMapper->deleteById($id);
        $this->_helper->redirector('index');
    }
    
    protected function getExtension($filePath)
    {
        $data = pathinfo($filePath);
        return $data['extension'];
    }
    
}
