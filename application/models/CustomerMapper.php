<?php

class Application_Model_CustomerMapper
{
    protected $_dbTable;
    protected $CustomerCount=null;
    
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
            $this->setDbTable('Application_Model_DbTable_Customer');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Customer $customer)
    {
        $data = $customer->toArray();
        // print_r($data);die;
        $id   = $customer->getCustomerId();
        if (null === $id) {
            unset($data['customer_id']);
            $id=$this->getDbTable()->insert($data);
            $customer->setCustomerId($id);

        } else {
            $this->getDbTable()->update($data, array(
                'customer_id = ?' => $id
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
    
    public function deleteById($id)
    {
        $this->getDbTable()->delete(array(
            'customer_id=?' => $id
        ));
    }
     public function fetch($args)
    {
        $resultSet = $this->getDbTable()->fetchAll($args);
        return $this->convertToModel($resultSet);
    }
     public function getSaleCount(){
        if($this->CustomerCount==null){
            $adapter=Zend_Db_Table_Abstract::getDefaultAdapter();
        $stmt=$adapter->query('select count(*) as page_count,customer_id from sale group by customer_id');
        $data=$stmt->fetchAll();
        $temp=array();
        if($data){
            foreach($data as $item){
                $temp[$item['customer_id']]=$item['page_count'];
            }
        }
        $this->CustomerCount=$temp;
        }
        
        return $this->CustomerCount;
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
            $entry = new Application_Model_Customer();
            $entry->setCustomerId($row->customer_id);
            $entry->setName($row->customer);
            $entry->setAddress($row->address);
            $entry->setEmail($row->email);
            $entry->setContact($row->contact);
            $entry->setImage($row->image);
            $entry->setStatus($row->status);
            $entry->setCreatedDate($row->date);
            $entry->setSaleCount($row->page_count);
            $data[] = $entry;
        }
        return $data;
    }
}