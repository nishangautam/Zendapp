<?php

class Application_Model_Purchase
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=0;
    protected $purchase_id;
    protected $supplier_id;
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

   

    public function getPurchaseId(){
        return $this->purchase_id;
    }
    public function setPurchaseId($id){
         $this->purchase_id=$id;
    }
    public function getSupplierId(){
        return $this->supplier_id;
    }
    public function setSupplierId($s){
        $this->supplier_id=$s;
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
     public function getSupplier()
    {
        $mapper = new Application_Model_SupplierMapper();
        return $mapper->find($this->supplier_id);
    }

    public function getPurchaseData(){
        $mapper=new Application_Model_PurchaseDetailMapper();
        return $mapper->getByPurchaseId($this->purchase_id);
    }

   

    public function toArray(){
        $data=array();
        $data['purchase_id']=$this->getPurchaseId();
        $data['supplier_id']=$this->getSupplierId();
        $data['status']=$this->getStatus();
        $data['amount']=$this->getAmount();
        $data['date_created']=$this->getCreatedDate();
        return $data;
    }
}