<?php

class SaleController extends BaseController
{
    protected $productMapper = null;
    protected $customerMapper = null;
    protected $saleMapper = null;
    protected $categoryMapper = null;
    protected $saledetailMapper = null;

    public function init()
    {
        $this->productMapper         = new Application_Model_ProductMapper();
        $this->customerMapper        = new Application_Model_CustomerMapper();
        $this->saleMapper        = new Application_Model_SaleMapper();
        $this->categoryMapper        = new Application_Model_CategoryMapper();
        $this->saledetailMapper = new Application_Model_SaledetailMapper();
         parent::init();
    }

    public function indexAction()
    {
       $data                        = $this->saleMapper->fetchall();
        $this->view->sales       = $data;
        
    }
     public function viewAction(){
          $this->_helper->layout()->disableLayout();
          $id=$this->getRequest()->getParam('id',0);
        $sale=$this->saleMapper->find($id);
        $this->view->sale=$sale;
    }
    public function updateAction()
    {
        //action body
    }
    public function deleteAction(){
         $id=$this->getRequest()->getParam('id',0);
        $sale=$this->saleMapper->find($id);

        if(!$sale){
            throw new Exception("No sale found.");
        }
        $this->saleMapper->deleteById($id);
         $this->_helper->redirector('index');
    }
    public function addAction()
    {
      // $form = new Application_Form_Sale();
      //   $this->view->saleform = $form;

          $data                 = $this->productMapper->fetch([
            'status'    => 1
        ]);
        $this->view->products = $data;
        
        $data                  = $this->customerMapper->fetch([
            'status'    => 1
        ]);
        $this->view->customers = $data;
        

        
        $data                   = $this->categoryMapper->fetch([
            'status'    => 1
        ]);
        $this->view->categories = $data;

         if ($this->getRequest()->isPost()) {
            $customerId  = $this->getRequest()->getParam('customer_id', 0);
            $productIds  = $this->getRequest()->getParam('product_id', array());
            $productQtys = $this->getRequest()->getParam('product_quantity', array());
            $prices       = $this->getRequest()->getParam('price', array());
            $discounts    = $this->getRequest()->getParam('discount', array());
             $id      = $this->getRequest()->getParam('id', 0);
             $adapter = Zend_Db_Table::getDefaultAdapter();
                $adapter->beginTransaction();
                try {
                     $sale=new Application_Model_Sale();
                    $sale->setCustomerId($customerId);
                    $saleMapper=new Application_Model_SaleMapper();
                    $this->saleMapper->save($sale);

                    $saleId=$sale->getSaleId();

                    $saledetailMapper=new Application_Model_SaledetailMapper();
                    $amt=0;
                    foreach($productIds as $key=>$productId){
                    $saledetail = new Application_Model_Saledetail();
                    $saledetail->setSaleId($saleId);   
                        $price=$prices[$key];
                        $qty=$productQtys[$key];
                        $productId=$productIds[$key];
                        $discount=$discounts[$key];
                        if($qty<0){
                            throw new Exception("Negative Quantity", 1);
                            
                        }
                        if($discount<0){
                            throw new Exception("Negative Discout", 1);
                            
                        }
                        
                        $amount=array();
                        $amount=($price*$qty)-(($price*$qty)*($discount/100));
                        $saledetail->setProductId($productId);
                        $saledetail->setPrice($price);
                        $saledetail->setProductQuantity($qty);
                        $saledetail->setDiscount($discount);
                        $saledetail->setAmount($amount);
                        $saledetailMapper->save($saledetail);
                        $amt+=$amount;
                        $sale->setAmount($amt);
                        $saleMapper->save($sale);

                        $product = $this->productMapper->find($productId);
                       
                        $oldQty=$product->getProductQuantity();
                         // echo $oldQty;
                        // if($oldQty<=0){
                        // throw new Exception("Insufficient Quantity");
                        
                        //  }
                        
                        $newQty=$oldQty-$qty;
                        if($newQty>=0){
                             $product->setProductQuantity($newQty);
                        $this->productMapper->save($product);
                        }
                        else{

                           throw new Exception("Insufficient Quantity");    
                        }
                        // echo $newQty;
                           

                    }
                   
                        

                   
                    $adapter->commit();
                }
                 catch (Exception $e) {
                    throw $e;
                }
                 $this->_helper->redirector('index');
        }
        
    }


}

