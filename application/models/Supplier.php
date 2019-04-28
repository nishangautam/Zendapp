<?php

class Application_Model_Supplier
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=0;
    protected $supplier_id;
    protected $supplier;
    protected $address;
    protected $email;
    protected $contact;
    protected $date_created;
    protected $status;
    protected $page_count;
    protected $supplierMapper;

    public function __construct(array $options = null)
    {
        $this->date_created=date('Y-m-d H:i:s');
        $this->status=0;
        $this->supplierMapper=new Application_Model_SupplierMapper();
         
       
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


    public function getSupplierId(){
        return $this->supplier_id;
    }
    public function setSupplierId($id){
         $this->supplier_id=$id;
    }
    public function getName(){
        return $this->supplier;
    }
    public function setName($newName){
        if(empty($newName)){
            throw new Exception("Name ss can not be empty");
            
        }
        $this->supplier=$newName;
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
        return $this->date_created;
    }

    public function setCreatedDate($date){
        $this->date_created=$date;
    }

    public function enable(){
        $this->status=self::STATUS_ENABLED;
    }
    public function disable(){
        $this->status=self::STATUS_DISABLED;
    }
    public function getPurchaseCount(){
        return $this->supplierMapper->getPurchaseCountById($this->getSupplierId());
    }
    public function setPurchaseCount($pc){
        $this->page_count=$pc;
    }
    public function toArray(){
        $data=array();
        $data['supplier_id']=$this->getSupplierId();
        $data['supplier']=$this->getName();
        $data['address']=$this->getAddress();
        $data['email']=$this->getEmail();
        $data['contact']=$this->getContact();
        $data['image']=$this->getImage();
       $data['status']=$this->getStatus();
        $data['date_created']=$this->getCreatedDate();
        $data['page_count']=$this->getPurchaseCount();
        return $data;
    }
}