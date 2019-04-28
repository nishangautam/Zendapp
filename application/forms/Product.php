<?php

class Application_Form_Product extends Zend_Form
{
    protected $categoryMapper=null;

    public function __construct(){
        $this->categoryMapper=new Application_Model_CategoryMapper();
        parent::__construct();
    }


    public function init()
    {
        

        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an email element
        $this->addElement('select', 'category_id', array(
            'label'      => 'Category',
            'class'=>'form-control col-4 col-sm-8 ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),           
        ));


        $options=array();
        $data=$this->categoryMapper->fetch([
            'status'    => 1
        ]);
        if($data){
            foreach($data as $item){
                $options[$item->getCategoryId()]=$item->getCategory();
            }
        }

        $this->getElement('category_id')->setMultiOptions($options);


        $this->addElement('text', 'product', array(
            'label'      => 'Product Name:',
            'class'=>'form-control col col-sm-4',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            
            
        ));
        $this->addElement('text', 'price', array(
            'label'      => 'Product Price',
            'class'=>'form-control col col-sm-4',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array(
                'NotEmpty','Int',
            )
            
        ));
        



        $this->addElement('file', 'image', array(
            'label'      => 'Image:',
            'class'=>'form-control col col-sm-4',
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
