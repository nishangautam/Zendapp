<?php

class Application_Model_SupplierMapper
{
    protected $_dbTable;
    protected $SupplierCount;
    
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
            $this->setDbTable('Application_Model_DbTable_Supplier');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Supplier $supplier)
    {
        $data = $supplier->toArray();
    // print_r($data);die;
        $id   = $supplier->getSupplierId();
        if (null === $id) {
            unset($data['supplier_id']);
           $id= $this->getDbTable()->insert($data);
           $supplier->setSupplierId($id);
        } else {
            $this->getDbTable()->update($data, array(
                'supplier_id = ?' => $id
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
    
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }
     public function deleteById($id){
        $this->getDbTable()->delete(array('supplier_id=?'=>$id));
    }
     public function fetch($args)
    {
        $resultSet = $this->getDbTable()->fetchAll($args);
        return $this->convertToModel($resultSet);
    }
      public function getPurchaseCount(){
        if($this->SupplierCount==null){
            $adapter=Zend_Db_Table_Abstract::getDefaultAdapter();
        $stmt=$adapter->query('select count(*) as page_count,supplier_id from purchase group by supplier_id');
        $data=$stmt->fetchAll();
        $temp=array();
        if($data){
            foreach($data as $item){
                $temp[$item['supplier_id']]=$item['page_count'];
            }
        }
        $this->SupplierCount=$temp;
        }
        
        return $this->SupplierCount;
    }
    public function getPurchaseCountById($id){
        $data=$this->getPurchaseCount();
        if(isset($data[$id])){
            return $data[$id];
        }
        return 0;
    }
    protected function convertToModel($resultSet)
    {
        $data = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Supplier();
            $entry->setSupplierId($row->supplier_id);
            $entry->setName($row->supplier);
            $entry->setAddress($row->address);
            $entry->setEmail($row->email);
            $entry->setContact($row->contact);
            $entry->setImage($row->image);
            $entry->setStatus($row->status);
           $entry->setCreatedDate($row->date_created);
            $data[] = $entry;
        }
        return $data;
    }
}