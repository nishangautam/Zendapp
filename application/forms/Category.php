<?php

class Application_Form_Category extends Zend_Form
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
            $this->addElement('hidden','category_id');
        }


        // Add an email element
        $this->addElement('text', 'category', array(
            'label'      => 'Category Name:',
            'class'=>'form-control col-4 col-sm-8 ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),            
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
