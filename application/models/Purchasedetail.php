<?php

class Application_Model_Purchasedetail
{
    protected $purchasedetail_id;
    protected $purchase_id;
    protected $product_id;
    protected $product_quantity;
    protected $price;
    protected $discount;
    protected $amount;
    
    

    public function __construct(array $options = null)
    {

}
    public function getPurchasedetailId(){
        return $this->purchasedetail_id;
    }
    public function setPurchasedetailId($id){
         $this->purchasedetail_id=$id;
    }
    public function getPurchaseId(){
        return $this->purchase_id;
    }
    public function setPurchaseId($i){
        $this->purchase_id=$i;
    }
   
    public function getProductId(){
        return $this->product_id;
    }
    public function setProductId($p){
        $this->product_id=$p;
    }
    public function getProductQuantity(){
        return $this->product_quantity;
    }
    public function setProductQuantity($q){
        $this->product_quantity=$q;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($r){
        $this->price=$r;
    }
    public function getDiscount(){
        return $this->discount;
    }
    public function setDiscount($d){
        $this->discount=$d;
    }
    public function getAmount(){
        return $this->amount;
    }
    public function setAmount($a){
        $this->amount=$a;
    }
     public function getProduct()
    {
        $mapper = new Application_Model_ProductMapper();
        return $mapper->find($this->product_id);
    }
   public function getPurchase(){
    $mapper=new Application_Model_PurchaseMapper();
    return $mapper->find($this->purchase_id);
   }

    public function toArray(){
        $data=array();
        $data['purchasedetail_id']=$this->getPurchasedetailId();
        $data['purchase_id']=$this->getPurchaseId();
        $data['product_id']=$this->getProductId();
        $data['product_quantity']=$this->getProductQuantity();
        $data['price']=$this->getPrice();
        $data['discount']=$this->getDiscount();
        $data['amount']=$this->getAmount();
       
        return $data;
    }
}