<?php

class Application_Model_PurchaseMapper
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
            $this->setDbTable('Application_Model_DbTable_Purchase');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Purchase $purchase)
    {
        $data=$purchase->toArray();
        // print_r($data);die;
        $id=$purchase->getPurchaseId();
                if (null === $id) {
            unset($data['purchase_id']);
            $id=$this->getDbTable()->insert($data);
            $purchase->setPurchaseId($id);
            
        } else {
            $this->getDbTable()->update($data, array('purchase_id = ?' => $id));
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
   public function getBySupplierId($supplier_id){
        $select=$this->getDbTable()->select();
        $select->where('supplier_id=?',$supplier_id);
        $data=$this->getDbTable()->fetchAll($select);
        return $this->convertToModel($data);
    }


    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }
         public function deleteById($id){
        $this->getDbTable()->delete(array('purchase_id=?'=>$id));
    }
     public function fetch($args)
    {
        $resultSet = $this->getDbTable()->fetchAll($args);
        return $this->convertToModel($resultSet);
    }
   protected function convertToModel($resultSet){
        $data=array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Purchase();
            $entry->setPurchaseId($row->purchase_id);
            $entry->setSupplierId($row->supplier_id);
            $entry->setAmount($row->amount);
            $entry->setStatus($row->status);
            $entry->setCreatedDate($row->date_created);
            $data[] = $entry;
        }
        return $data;
    }
}