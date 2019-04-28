<?php

class Application_Model_Saledetail
{
    protected $saledetail_id;
    protected $sale_id;
    protected $product_id;
    protected $product_quantity;
    protected $price;
    protected $discount;
    protected $amount;
    
    

    public function __construct(array $options = null)
    {
        // $this->date_created=date('Y-m-d H:i:s');
        // if (is_array($options)) {
        //     $this->setOptions($options);
        // }
    }

    // public function __set($name, $value)
    // {
    //     $method = 'set' . $name;
    //     if (('mapper' == $name) || !method_exists($this, $method)) {
    //         throw new Exception('Invalid guestbook property');
    //     }
    //     $this->$method($value);
    // }

    // public function __get($name)
    // {
    //     $method = 'get' . $name;
    //     if (('mapper' == $name) || !method_exists($this, $method)) {
    //         throw new Exception('Invalid guestbook property');
    //     }
    //     return $this->$method();
    // }

    // public function setOptions(array $options)
    // {
    //     $methods = get_class_methods($this);
    //     foreach ($options as $key => $value) {
    //         $method = 'set' . ucfirst($key);
    //         if (in_array($method, $methods)) {
    //             $this->$method($value);
    //         }
    //     }
    //     return $this;
    // }


    public function getSaledetailId(){
        return $this->saledetail_id;
    }
    public function setSaledetailId($id){
         $this->saledetail_id=$id;
    }
    public function getSaleId(){
        return $this->sale_id;
    }
    public function setSaleId($i){
        $this->sale_id=$i;
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
   public function getSale(){
    $mapper=new Application_Model_SaleMapper();
    return $mapper->find($this->sale_id);
   }
   

    public function toArray(){
        $data=array();
        $data['saledetail_id']=$this->getSaledetailId();
        $data['sale_id']=$this->getSaleId();
        $data['product_id']=$this->getProductId();
        $data['product_quantity']=$this->getProductQuantity();
        $data['price']=$this->getPrice();
        $data['discount']=$this->getDiscount();
        $data['amount']=$this->getAmount();
       
        return $data;
    }
}