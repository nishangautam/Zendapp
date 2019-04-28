<?php

class IndexController extends BaseController
{

     protected $customerMapper = null;
     protected $supplierMapper=null;
     protected $categoryMapper=null;
     protected $productMapper=null;
     protected $purchaseMapper=null;
     protected $saleMapper=null;

    public function init()
    {
         $this->customerMapper = new Application_Model_CustomerMapper();
         $this->supplierMapper=new Application_Model_SupplierMapper();
         $this->categoryMapper=new Application_Model_CategoryMapper();
         $this->productMapper=new Application_Model_ProductMapper();
         $this->purchaseMapper=new Application_Model_PurchaseMapper();
         $this->saleMapper=new Application_Model_saleMapper();
         parent::init();
    }

    public function indexAction()
    {
       $rowset      = $this->customerMapper->fetchall();
       $rowCount = count($rowset);
       $this->view->cus=$rowCount;

        $rowset=$this->supplierMapper->fetchall();
        $rowCount=count($rowset);
        $this->view->sup=$rowCount;

        $rowset=$this->productMapper->fetchall();
        $rowCount=count($rowset);
        $this->view->pro=$rowCount;

        $rowset=$this->categoryMapper->fetchall();
        $rowCount=count($rowset);
        $this->view->cat=$rowCount;

        $rowset=$this->purchaseMapper->fetchall();
        $rowCount=count($rowset);
        $this->view->pur=$rowCount;

        $rowset=$this->saleMapper->fetchall();
        $rowCount=count($rowset);
        $this->view->sal=$rowCount;

        // $this->categoryMapper->getProductCount();

 
    }
    public function abcAction(){
    	// actionBody
    }


}

