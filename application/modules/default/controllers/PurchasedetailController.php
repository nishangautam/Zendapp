<?php

class PurchasedetailController extends BaseController
{
    protected $purchasedetailMapper=null;

    public function init()
    {
        $this->purchasedetailMapper =new Application_Model_PurchasedetailMapper();
         parent::init();
    }

    public function indexAction()
    {
       $this->view->purchasedetails=$this->purchasedetailMapper->fetchAll();
    }

    public function activateAction(){
        $id=$this->getRequest()->getParam('id',0);
        $purchasedetail=$this->purchasedetailMapper->find($id);

        $purchasedetail->activate();
        $this->purchasedetailMapper->save($purchasedetail);
        $this->_helper->redirector('index');

    }

    public function updateAction()
    {
    	
    }
    public function addAction()
    { 
         $form=new Application_Form_Purchasedetail();
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getPost())){
                // form is valid
                $data=$form->getvalues();
                $purchasedetail=new Application_Model_purchasedetail();
                $purchasedetail->setPId($data['p_id']);
                $purchasedetail->setProductId($data['product_id']);
                 $purchasedetail->setProductQuantity($data['product_quantity']);
                 $purchasedetail->setPrice($data['price']);
                 $purchasedetail->setDiscount($data['discount']);
                $purchasedetail->setAmount($data['amount']);
                 $purchasedetailMapper=new Application_Model_PurchasedetailMapper();

                $purchasedetailMapper->save($purchasedetail);
                var_dump($this->getRequest()->getParams());die;
                $this->_helper->redirector('index');


            }
        }

        $this->view->purchasedetailform=$form;
        //action body
    }
    public function deleteAction(){
       
    }


}

