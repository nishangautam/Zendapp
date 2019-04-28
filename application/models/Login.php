<?php

class Application_Model_Login
{
    const STATUS_ENABLED=1;
    const STATUS_DISABLED=0;
     protected $login_id;
    protected $username;
    protected $password;
    protected $email;
    protected $date_created;
    protected $status;

    public function __construct(array $options = null)
    {
        $this->date_created=date('Y-m-d H:i:s');
        $this->status=0;
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid guestbook property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }


    public function getLoginId(){
        return $this->login_id;
    }
    public function setLoginId($id){
         $this->login_id=$id;
    }
    public function getUserName(){
        return $this->username;
    }
    public function setUserName($newName){
        if(empty($newName)){
            throw new Exception("UserName Cannot be empty");
            
        }
        $this->username=$newName;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($em){
        $this->email=$em;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($p){
        $this->password=$p;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($st){
        $this->status=$st;
    }
    public function getCreatedDate(){
        return $this->date_created;
    }

    public function setCreatedDate($date){
        $this->date_created=$date;
    }

    public function enable(){
        $this->status=self::STATUS_ENABLED;
    }
    public function disable(){
        $this->status=self::STATUS_DISABLED;
    }
    public function toArray(){
        $data=array();
        $data['login_id']=$this->getLoginId();
        $data['username']=$this->getUserName();
        $data['password']=$this->getPassword();
        $data['email']=$this->getEmail();
        $data['status']=$this->getStatus();
        $data['date_created']=$this->getCreatedDate();
        return $data;
    }
}