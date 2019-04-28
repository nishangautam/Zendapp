<?php

class Application_Model_SaleMapper
{
    protected $_dbTable;

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
            $this->setDbTable('Application_Model_DbTable_Sale');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Sale $sale)
    {
        $data=$sale->toArray();
        // print_r($data);die;
        $id=$sale->getSaleId();
                if (null === $id) {
            unset($data['sale_id']);
            $id=$this->getDbTable()->insert($data);
            $sale->setSaleId($id);
            
        } else {
            $this->getDbTable()->update($data, array('sale_id = ?' => $id));
        }
    }

    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $data=$this->convertToModel($result);
        return $data[0];
    }

     public function getByCustomerId($customer_id){
        $select=$this->getDbTable()->select();
        $select->where('customer_id=?',$customer_id);
        $data=$this->getDbTable()->fetchAll($select);
        return $this->convertToModel($data);
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }
         public function deleteById($id){
        $this->getDbTable()->delete(array('sale_id=?'=>$id));
    }
     public function fetch($args)
    {
        $resultSet = $this->getDbTable()->fetchAll($args);
        return $this->convertToModel($resultSet);
    }
   protected function convertToModel($resultSet){
        $data=array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Sale();
            $entry->setSaleId($row->sale_id);
            $entry->setCustomerId($row->customer_id);
            $entry->setAmount($row->amount);
            $entry->setStatus($row->status);
            $entry->setCreatedDate($row->date_created);
            $data[] = $entry;
        }
        return $data;
    }
}