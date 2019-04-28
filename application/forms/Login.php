<?php

class Application_Form_Login extends Zend_Form
{

    protected $isEditMode=false;

    public function __construct($isEditMode=false){
        $this->isEditMode=$isEditMode;
        parent::__construct();
    }

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        if($this->isEditMode){
            $this->addElement('hidden','login_id');
        } ?>
           
                    
                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                       <?php 
                       $this->addElement('text', 'username', array(
            'label'      => 'User Name:',
            'class'=>'form-control ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),            
        )); ?>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="col-xs-12">
                       <?php 
                        $this->addElement('password', 'password', array(
            'label'      => 'Password:',
            'class'=>'form-control ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),            
        )); ?>
                      </div>
                    </div>
                     
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <?php
                         $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Log In',
            'class'=>'btn btn-info btn-sm btn-block btn-rounded text-uppercase waves-effect waves-light',
            'title'=>'Login with Google'
        )); ?>
                      </div>
                    </div>
                  
       
        
        

       
        <?php
       

           $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));

    }
}
