<?php

class Application_Model_Category
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=0;
    protected $category_id;
    protected $category;
    protected $date_created;
    protected $status;
    protected $page_count=0;
    protected $categoryMapper;

    public function __construct(array $options = null)
    {
        $this->date_created=date('Y-m-d H:i:s');
        $this->status=0;
        $this->categoryMapper=new Application_Model_CategoryMapper();
    }

   

    public function getCategoryId(){
        return $this->category_id;
    }
    public function setCategoryId($id){
         $this->category_id=$id;
    }
    public function getCategory(){
        return $this->category;
    }
    public function setCategory($newName){
        // if(empty($newName)){
        //     throw new Exception("Name {$name} can not be empty");
            
        // }
        $this->category=$newName;
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
   
    public function getProductCount(){
      return  $this->categoryMapper->getProductCountById($this->getCategoryId());
           }
    public function setProductCount($pc){
         $this->page_count=$pc;
    }
    public function toArray(){
        $data=array();
        $data['category_id']=$this->getCategoryId();
        $data['category']=$this->getCategory();
        $data['status']=$this->getStatus();
         $data['date_created']=$this->getCreatedDate();
        $data['page_count']=$this->getProductCount();
        return $data;
    }
}