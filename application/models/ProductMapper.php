<?php
class Application_Model_ProductMapper
{
    protected $_dbTable;
    protected $ProductCount;
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_product');
        }
        return $this->_dbTable;
    }
    public function save(Application_Model_Product $product)
    {
        $data = $product->toArray();
         // print_r($data);die;
        $id   = $product->getProductId();
        if (null === $id) {
            unset($data['product_id']);
            $id = $this->getDbTable()->insert($data);
            $product->setProductId($id);
        } else {
            $this->getDbTable()->update($data, array(
                'product_id = ?' => $id
            ));
        }
    }
    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $data = $this->convertToModel($result);
        return $data[0];
    }

    public function getByCategoryId($category_id){
        $select=$this->getDbTable()->select();
        $select->where('category_id=?',$category_id);
        $data=$this->getDbTable()->fetchAll($select);
        return $this->convertToModel($data);
    }
     public function getByProductId($product_id){
        $select=$this->getDbTable()->select();
        $select->where('product_id=?',$product_id);
        $data=$this->getDbTable()->fetchAll($select);
        return $this->convertToModel($data);
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }
    public function deleteById($id)
    {
        $this->getDbTable()->delete(array(
            'product_id=?' => $id
        ));
    }
     public function fetch($args)
    {
        $resultSet = $this->getDbTable()->fetchAll($args);
        return $this->convertToModel($resultSet);
    }
    public function getPurchaseCount(){
        if($this->ProductCount==null){
            $adapter=Zend_Db_Table_Abstract::getDefaultAdapter();
        $stmt=$adapter->query('select count(*) as page_count,product_id from purchasedetail group by product_id');
        $data=$stmt->fetchAll();
        $temp=array();
        if($data){
            foreach($data as $item){
                $temp[$item['product_id']]=$item['page_count'];
            }
        }
        $this->ProductCount=$temp;
        }
        
        return $this->ProductCount;
    }
    public function getPurchaseCountById($id){
        $data=$this->getPurchaseCount();
        if(isset($data[$id])){
            return $data[$id];
        }
        return 0;
    }

    public function getSaleCount(){
        if($this->ProductCount==null){
            $adapter=Zend_Db_Table_Abstract::getDefaultAdapter();
        $stmt=$adapter->query('select count(*) as page_count,product_id from saledetail group by product_id');
        $data=$stmt->fetchAll();
        $temp=array();
        if($data){
            foreach($data as $item){
                $temp[$item['product_id']]=$item['page_count'];
            }
        }
        $this->ProductCount=$temp;
        }
        
        return $this->ProductCount;
    }
    public function getSaleCountById($id){
        $data=$this->getSaleCount();
        if(isset($data[$id])){
            return $data[$id];
        }
        return 0;
    }
    protected function convertToModel($resultSet)
    {
        $data = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Product();
            $entry->setProductId($row->product_id);
            $entry->setCategoryId($row->category_id);
            $entry->setName($row->product);
            $entry->setPrice($row->price);
            $entry->setProductQuantity($row->product_quantity);
            $entry->setImage($row->image);
            $entry->setStatus($row->status);
            $entry->setCreatedDate($row->date_created);
            $entry->setPurchaseCount($row->purchase_count);
            $entry->setSaleCount($row->sale_count);
            $data[] = $entry;
        }
        return $data;
    }
}