<?php

class PurchaseController extends Zend_Controller_Action
{
    protected $purchaseMapper=null;

    public function init()
    {
        $this->purchaseMapper =new Application_Model_PurchaseMapper();
    }

    public function indexAction()
    {
       $this->view->purchases=$this->purchaseMapper->fetchAll();
    }

    public function activateAction(){
        $id=$this->getRequest()->getParam('id',0);
        $purchase=$this->purchaseMapper->find($id);

        $purchase->activate();
        $this->purchaseMapper->save($purchase);
        $this->_helper->redirector('index');

    }

    public function updateAction()
    {
    	
    }
    public function listAction()
    { 
         $form=new Application_Form_Purchase();
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getPost())){
                // form is valid
                $data=$form->getvalues();
                $purchase=new Application_Model_purchase();
                $purchase->setSupplierId($data['supplier_id']);
                $purchase->setAmount($data['amount']);
                 $purchaseMapper=new Application_Model_PurchaseMapper();

                $purchaseMapper->save($purchase);
                var_dump($this->getRequest()->getParams());die;
                $this->_helper->redirector('index');


            }
        }

        $this->view->purchaseform=$form;
        //action body
    }
    public function deleteAction(){
       
    }


}

