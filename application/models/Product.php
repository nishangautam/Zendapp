<?php
class Application_Model_Product
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    protected $product_id;
    protected $product;
    protected $category_id;
    protected $price;
    protected $product_quantity;
    protected $image;
    protected $date_created;
    protected $status;
    protected $purchase_count;
    protected $sale_count;
    protected $productMapper;
    public function __construct(array $options = null)
    {
        $this->date_created     = date('Y-m-d H:i:s');
        $this->product_quantity = 0;
        $this->status=0;
        //  if (is_array($options)) {
        //     $this->setOptions($options);
        // }
        $this->productMapper=new Application_Model_productMapper();
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
    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function setCategoryId($id)
    {
        $this->category_id = $id;
    }
    public function getproductId()
    {
        return $this->product_id;
    }
    public function setproductId($id)
    {
        $this->product_id = $id;
    }
    public function getName()
    {
        return $this->product;
    }
    public function setName($newName)
    {
        if (empty($newName)) {
            throw new Exception("Name ss can not be empty");
        }
        $this->product = $newName;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($p)
    {
        $this->price = $p;
    }
    public function getProductQuantity()
    {
        return $this->product_quantity;
    }
    public function setProductQuantity($q)
    {
        $this->product_quantity = $q;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($i)
    {
        $this->image = $i;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($st){
        $this->status=$st;
    }
    public function getCreatedDate()
    {
        return $this->date_created;
    }
    public function setCreatedDate($date)
    {
        $this->date_created = $date;
    }
    public function enable()
    {
        $this->status = self::STATUS_ENABLED;
    }
    public function disable()
    {
        $this->status = self::STATUS_DISABLED;
    }
    public function getCategory()
    {
        $mapper = new Application_Model_CategoryMapper();
        return $mapper->find($this->category_id);
    }
    public function getPurchaseCount(){
        return $this->productMapper->getPurchaseCountById($this->getproductId());
    }
    public function setPurchaseCount($pc){
        $this->purchase_count=$pc;
    }
    public function getSaleCount(){
        return $this->productMapper->getSaleCountById($this->getProductId());
    }
    public function setSaleCount($sc){
        $this->sale_count=$sc;
    }
    public function toArray()
    {
        $data                     = array();
        $data['product_id']       = $this->getproductId();
        $data['product']          = $this->getName();
        $data['category_id']      = $this->getCategoryId();
        $data['price']            = $this->getPrice();
        $data['product_quantity'] = $this->getProductQuantity();
        $data['image']            = $this->getImage();
        $data['status']           = $this->getStatus();
        $data['date_created']     = $this->getCreatedDate();
        $data['purchase_count']=$this->getPurchaseCount();
        $data['sale_count']=$this->getsaleCount();
        return $data;
    }
}