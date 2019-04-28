<?php

class Application_Model_loginMapper
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
            $this->setDbTable('Application_Model_DbTable_Login');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Login $login)
    {
        $data=$login->toArray();
        $id=$login->getLoginId();
                if (null === $id) {
            unset($data['login_id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('login_id = ?' => $id));
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

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->convertToModel($resultSet);
    }

     public function deleteById($id){
        $this->getDbTable()->delete(array('login_id=?'=>$id));
    }
    
     public function getByUsername($username){
        $sql="SELECT * FROM login where username='$username'";
        $adapter=Zend_Db_Table_Abstract::getDefaultAdapter();
            $stm=$adapter->query($sql);
        $data=$stm->fetchAll();
        $data=$this->convertToModel($data);
        return $data[0];
     }
   protected function convertToModel($resultSet){
        $data=array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_login();
            $entry->setLoginId($row['login_id']);
            $entry->setUserName($row['username']);
            $entry->setPassword($row['password']);
            $entry->setEmail($row['email']);
            $entry->setStatus($row['status']);
            $entry->setCreatedDate($row['date_created']);
            $data[] = $entry;
        }
        return $data;
    }
}
