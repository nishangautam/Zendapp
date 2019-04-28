<?php

class Api_ProductController extends Zend_Controller_Action
{

    protected $productMapper;

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $this->productMapper=new Application_Model_ProductMapper();
    }

    public function listAction(){
        $cat_id=$this->getRequest()->getParam('category_id',0);
        $data=$this->productMapper->getByCategoryId($cat_id);
        $jsonData=array();
        if($data){
            foreach($data as $item){
                $temp=array();
                $temp['product_id']=$item->getProductId();
                $temp['name']=$item->getName();
                $temp['price']=$item->getPrice();
                $jsonData[]=$temp;
            }
        }
        echo json_encode($jsonData);
    }
public function addAction(){
    $pro_id=$this->getRequest()->getParam('product_id',0);
    $data=$this->productMapper->getByProductId($pro_id);
    $jsonData=array();
    if($data){
        foreach($data as $item){
            $temp['product_id']=$item->getProductId();
                $temp['price']=$item->getPrice();
                $jsonData=$temp;
            }
        }
        echo json_encode($jsonData);
}
    


}

