<?php

class PurchaseController extends BaseController
{
    protected $productMapper = null;
    protected $supplierMapper = null;
    protected $purchaseMapper = null;
    protected $categoryMapper = null;
    protected $purchasedetailMapper = null;
    
    public function init()
    {
        $this->productMapper        = new Application_Model_ProductMapper();
        $this->supplierMapper       = new Application_Model_SupplierMapper();
        $this->purchaseMapper       = new Application_Model_PurchaseMapper();
        $this->categoryMapper       = new Application_Model_CategoryMapper();
        $this->purchasedetailMapper = new Application_Model_PurchasedetailMapper();
         parent::init();
    }
    
    public function indexAction()
    {
        $data                        = $this->purchaseMapper->fetchall();
        $this->view->purchases       = $data;
        
        
        
    }
    public function viewAction(){
        $this->_helper->layout()->disableLayout();
        $id=$this->getRequest()->getParam('id',0);
        $purchase=$this->purchaseMapper->find($id);
        $this->view->purchase=$purchase;
    }
    public function updateAction()
    {
        //action body
    } public function listAction()
    {
        //action body
    }
    public function deleteAction(){
         $id=$this->getRequest()->getParam('id',0);
        $purchase=$this->purchaseMapper->find($id);

        if(!$purchase){
            throw new Exception("No purchase found.");
        }
        $this->purchaseMapper->deleteById($id);
         $this->_helper->redirector('index');
    }
    public function addAction()
    {
        // var_dump($this->getRequest()->getParams());
        
        
        $data                 = $this->productMapper->fetch([
            'status'    => 1
        ]);
        $this->view->products = $data;
        
        $data                  = $this->supplierMapper->fetch([
            'status'    => 1
        ]);
        $this->view->suppliers = $data;
        
        $data                   = $this->categoryMapper->fetch([
            'status'    => 1
        ]);
        $this->view->categories = $data;
        
        
        if ($this->getRequest()->isPost()) {
            $supplierId  = $this->getRequest()->getParam('supplier_id', 0);
            $productIds  = $this->getRequest()->getParam('product_id', array());
            $productQtys = $this->getRequest()->getParam('product_quantity', array());
            $prices      = $this->getRequest()->getParam('price', array());
            $discounts   = $this->getRequest()->getParam('discount', array());

         

            //1. Begin Transaction
            //2. Save purchase
            //3. save each item
            //4. commit
           
            
            $adapter = Zend_Db_Table::getDefaultAdapter();
            $adapter->beginTransaction();
            try {
                
                $purchase = new Application_Model_Purchase();
                $purchase->setSupplierId($supplierId);
                $purchaseMapper = new Application_Model_PurchaseMapper();
                $this->purchaseMapper->save($purchase);
                
                $purchaseId = $purchase->getPurchaseId();
                
                $purchasedetailMapper = new Application_Model_PurchasedetailMapper();
                
                $amt=0;
                foreach ($productIds as $key => $productId) {
                    $purchasedetail = new Application_Model_Purchasedetail();
                    $purchasedetail->setPurchaseId($purchaseId);
                    $price     = $prices[$key];
                    $qty       = $productQtys[$key];
                    $productId = $productIds[$key];
                    $discount  = $discounts[$key];
                    if($qty<0){
                            throw new Exception("Negative Quantity", 1);
                            
                        }
                        if($discount<0){
                            throw new Exception("Negative Discount", 1);
                            
                        }
                    $amount=array();
                    $amount  = ($price * $qty) - (($price * $qty) * ($discount / 100));
                    $purchasedetail->setProductId($productId);
                    $purchasedetail->setPrice($price);
                    $purchasedetail->setProductQuantity($qty);
                    $purchasedetail->setDiscount($discount);
                    $purchasedetail->setAmount($amount);
                    $purchasedetailMapper->save($purchasedetail);

                    $amt=$amt+$amount;
                    $purchase->setAmount($amt);
                    $purchaseMapper->save($purchase);
                   
                    $product = $this->productMapper->find($productId);
                    
                    // $qty+=$qty;

                    $oldQty=$product->getProductQuantity();
                    
                    $qty+=$oldQty;
                    // echo $qty;die();
                    $product->setProductQuantity($qty);
                    $this->productMapper->save($product);                 
                    
                }
                // var_dump($amt);die();
                
                $adapter->commit();
                
            }
            catch (Exception $e) {
                throw $e;
            }
            $this->_helper->redirector('index');
        }
        
    }
    
    
    
}
