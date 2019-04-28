<?php

class Application_Model_SaledetailMapper
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
            $this->setDbTable('Application_Model_DbTable_Saledetail');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Saledetail $saledetail)
    {
        $data=$saledetail->toArray();
        // print_r($data);die;
        $id=$saledetail->getSaledetailId();
                if (null === $id) {
            unset($data['saledetail_id']);
         $id=   $this->getDbTable()->insert($data);
          $saledetail->setSaledetailId($id);
        } else {
            $this->getDbTable()->update($data, array('saledetail_id = ?' => $id));
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
     public function getBySaleId($sale_id){
        $select=$this->getDbTable()->select();
        $select->where('sale_id=?',$sale_id);
        $data=$this->getDbTable()->fetchAll($select);
        return $this->convertToModel($data);
    }
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }
         public function deleteById($id){
        $this->getDbTable()->delete(array('saledetail_id=?'=>$id));
    }
   protected function convertToModel($resultSet){
        $data=array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Saledetail();
            $entry->setSaledetailId($row->saledetail_id);
            $entry->setSaleId($row->sale_id);
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