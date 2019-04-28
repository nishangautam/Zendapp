<?php

class Application_Model_Customer
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=0;
    protected $customer_id;
    protected $customer;
    protected $address;
    protected $email;
    protected $contact;
    protected $image;
    protected $date;
    protected $status;
     protected $page_count=0;
    protected $customerMapper;

     public function __construct(array $options = null)
    {
        $this->date=date('Y-m-d H:i:s');
        $this->status=0;
        $this->customerMapper=new Application_Model_CustomerMapper();
         
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


    public function getCustomerId(){
        return $this->customer_id;
    }
    public function setCustomerId($id){
         $this->customer_id=$id;
    }
    public function getName(){
        return $this->customer;
    }
    public function setName($newName){
        if(empty($newName)){
            throw new Exception("Name {$name} can not be empty");
            
        }
        $this->customer=$newName;
    }
    public function getAddress(){
        return $this->address;
    }
    public function setAddress($a){
         $this->address=$a;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($e){
        $this->email=$e;
    }
    public function getContact(){
        return $this->contact;
    }
    public function setContact($c){
        $this->contact=$c;
    }
    public function getImage(){
        return $this->image;
    }
    public function setImage($i){
        $this->image=$i;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($st){
        $this->status=$st;
    }
    public function getCreatedDate(){
        return $this->date;
    }

    public function setCreatedDate($d){
        $this->date=$d;
    }

    public function enable(){
        $this->status=self::STATUS_ENABLED;
    }
    public function disable(){
        $this->status=self::STATUS_DISABLED;
    }
    public function getSaleCount(){
        return $this->customerMapper->getSaleCountById($this->getCustomerId());
    }
    public function setSaleCount($pc){
        $this->page_count=$pc;
    }
    public function toArray(){
        $data=array();
        $data['customer_id']=$this->getCustomerId();
        $data['customer']=$this->getName();
        $data['address']=$this->getAddress();
        $data['email']=$this->getEmail();
        $data['contact']=$this->getContact();
        $data['image']=$this->getImage();
         $data['status']=$this->getStatus();
        $data['date']=$this->getCreatedDate();
        $data['page_count']=$this->getSaleCount();
        return $data;
    }
}