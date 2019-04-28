<?php

class Application_Model_Sale
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=0;
    protected $sale_id;
    protected $customer_id;
    protected $status;
    protected $amount;
    protected $date_created;
    

    public function __construct(array $options = null)
    {
        $this->date_created=date('Y-m-d H:i:s');
        $this->status=0;
        $this->amount=0;
        if (is_array($options)) {
            $this->setOptions($options);
        }
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


    public function getSaleId(){
        return $this->sale_id;
    }
    public function setSaleId($id){
         $this->sale_id=$id;
    }
    public function getCustomerId(){
        return $this->customer_id;
    }
    public function setCustomerId($s){
        $this->customer_id=$s;
    }
   
    public function getAmount(){
        return $this->amount;
    }
    public function setAmount($a){
        $this->amount=$a;
    }
    public function getCreatedDate(){
        return $this->date_created;
    }
     public function setCreatedDate($date){
        $this->date_created=$date;
    }
     public function getStatus(){
        return $this->status;
    }
    public function setStatus($st){
        $this->status=$st;
    }
    public function enable(){
        $this->status=self::STATUS_ENABLED;
    }
    public function disable(){
        $this->status=self::STATUS_DISABLED;
    }
    public function getCustomer(){
         $mapper = new Application_Model_CustomerMapper();
        return $mapper->find($this->customer_id);
    }


    public function getSaleData(){
        $mapper=new Application_Model_SaleDetailMapper();
        return $mapper->getBySaleId($this->sale_id);
    }
   

    public function toArray(){
        $data=array();
        $data['sale_id']=$this->getSaleId();
        $data['customer_id']=$this->getCustomerId();
        $data['status']=$this->getStatus();
        $data['amount']=$this->getAmount();
        $data['date_created']=$this->getCreatedDate();
        return $data;
    }
}