<?php

class Application_Model_PurchasedetailMapper
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
            $this->setDbTable('Application_Model_DbTable_Purchasedetail');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Purchasedetail $purchasedetail)
    {
        $data=$purchasedetail->toArray();
        // print_r($data);die;
        $id=$purchasedetail->getPurchasedetailId();
                if (null === $id) {
            unset($data['purchasedetail_id']);
         $id=   $this->getDbTable()->insert($data);
          $purchasedetail->setPurchasedetailId($id);
        } else {
            $this->getDbTable()->update($data, array('purchasedetail_id = ?' => $id));
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
     public function getByProductId($product_id){
        $select=$this->getDbTable()->select();
        $select->where('product_id=?',$product_id);
        $data=$this->getDbTable()->fetchAll($select);
        return $this->convertToModel($data);
    }
     public function getByPurchaseId($purchase_id){
        $select=$this->getDbTable()->select();
        $select->where('purchase_id=?',$purchase_id);
        $data=$this->getDbTable()->fetchAll($select);
        return $this->convertToModel($data);
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }
         public function deleteById($id){
        $this->getDbTable()->delete(array('purchasedetail_id=?'=>$id));
    }
   protected function convertToModel($resultSet){
        $data=array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Purchasedetail();
            $entry->setPurchasedetailId($row->purchasedetail_id);
            $entry->setPurchaseId($row->purchase_id);
            $entry->setProductId($row->product_id);
            $entry->setProductQuantity($row->product_quantity);
            $entry->setPrice($row->price);
            $entry->setDiscount($row->discount);
            $entry->setAmount($row->amount);
           
            $data[] = $entry;
        }
        return $data;
    }
}