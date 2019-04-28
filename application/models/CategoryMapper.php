<?php

class Application_Model_CategoryMapper
{
    protected $_dbTable;
    protected $CategoryCount=null;

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
            $this->setDbTable('Application_Model_DbTable_Category');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Category $category)
    {
        $data=$category->toArray();
        // print_r($data);die;
        $id=$category->getCategoryId();
                if (null === $id) {
            unset($data['category_id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('category_id = ?' => $id));
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

    public function getProductCount(){
        if($this->CategoryCount==null){
            $adapter=Zend_Db_Table_Abstract::getDefaultAdapter();
        $stmt=$adapter->query('select count(*) as page_count,category_id from product group by category_id');
        $data=$stmt->fetchAll();
        $temp=array();
        if($data){
            foreach($data as $item){
                $temp[$item['category_id']]=$item['page_count'];
            }
        }
        $this->CategoryCount=$temp;
        }
        
        return $this->CategoryCount;
    }
    public function getProductCountById($id){
        $data=$this->getProductCount();
        if(isset($data[$id])){
            return $data[$id];
        }
        return 0;
    }

    

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }
         public function deleteById($id){
        $this->getDbTable()->delete(array('category_id=?'=>$id));
    }

  public function fetch($args)
    {
        $resultSet = $this->getDbTable()->fetchAll($args);
        return $this->convertToModel($resultSet);
    }

   protected function convertToModel($resultSet){
        $data=array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Category();
            $entry->setCategoryId($row->category_id);
            $entry->setCategory($row->category);
            $entry->setStatus($row->status);
            $entry->setCreatedDate($row->date_created);
            $entry->setProductCount($row->page_count);
            $data[] = $entry;
        }
        return $data;
    }
}