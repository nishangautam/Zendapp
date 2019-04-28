<?php

class Application_Form_Loginadd extends Zend_Form
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
        }


        // Add an email element
        $this->addElement('text', 'username', array(
            'label'      => 'User Name:',
            'class'=>'form-control col-md-12 ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),            
        ));
        $this->addElement('text', 'email', array(
            'label'      => 'Email:',
            'class'=>'form-control col-md-12',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array(
                'EmailAddress',
            )
            
        ));


         $this->addElement('password', 'password', array(
            'label'      => 'Password:',
            'class'=>'form-control col col-md-12 ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'), 
              
        ));

          $this->addElement('password', 'confirmpassword', array(
            'label'      => 'Confirm Password',
            'class'=>'form-control col col-md-12 ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'), 
            
                      
        ));
        ?>

           
           <?php
         $this->addElement('captcha', 'captcha', array(
            'label'      => 'Please enter the 5 letters displayed below:',
            'required'   => true,
             'class'=>'form-control col col-md-12 g-recaptcha',
             'data-sitekey'=>'6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI',
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 5,
                'timeout' => 300
            )
        ));


       
         $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
            'class'=>'btn btn-primary'
        ));

           $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));

    }
}
