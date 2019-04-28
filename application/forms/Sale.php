<?php

class Application_Form_Sale extends Zend_Form
{
    protected $customerMapper = null;
    protected $productMapper = null;
    protected $categoryMapper = null;
    
    public function __construct()
    {
        $this->categoryMapper = new Application_Model_CategoryMapper();
        $this->customerMapper = new Application_Model_CustomerMapper();
        $this->productMapper = new Application_Model_ProductMapper();
        parent::__construct();
    }
    
    
    
    public function init()
    {
        
        
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->addElement('select', 'customer_id', array(
            'label' => 'Customer',
            'class' => 'form-control col-4 col-sm-8',
            'required' => true,
            'filters' => array(
                'StringTrim',
                'StripTags'
            )
        ));
        $options = array();
        $data    = $this->customerMapper->fetchAll();
        if ($data) {
            foreach ($data as $item) {
                $options[$item->getCustomerId()] = $item->getName();
            }
        }
        
        $this->getElement('customer_id')->setMultiOptions($options);
        
        
        $this->addElement('select', 'product_id', array(
            'label' => 'Product',
            'class' => 'form-control col-4 col-sm-8',
            'required' => true,
            'filters' => array(
                'StringTrim',
                'StripTags'
            )
        ));
        $options = array();
        $data    = $this->productMapper->fetchAll();
        if ($data) {
            foreach ($data as $item) {
                $options[$item->getProductId()] = $item->getName();
            }
        }
        
        $this->getElement('product_id')->setMultiOptions($options);
        
        
        
        // Add an email element
        $this->addElement('select', 'category_id', array(
            'label' => 'Category',
            'class' => 'form-control col-4 col-sm-8 ',
            'required' => true,
            'filters' => array(
                'StringTrim',
                'StripTags'
            )
        ));
        
        
        $options = array();
        $data    = $this->categoryMapper->fetchAll();
        if ($data) {
            foreach ($data as $item) {
                $options[$item->getCategoryId()] = $item->getCategory();
            }
        }
        
        $this->getElement('category_id')->setMultiOptions($options);
        
        
        $this->addElement('text', 'quantity', array(
            'label' => 'Quantity',
            'class' => 'form-control col col-sm-4',
            'required' => true,
            'filters' => array(
                'StringTrim',
                'StripTags'
            )
            
            
        ));
        $this->addElement('text', 'rate', array(
            'label' => 'Rate',
            'class' => 'form-control col col-sm-4',
            'required' => true,
            'filters' => array(
                'StringTrim',
                'StripTags'
            ),
            'validators' => array(
                'NotEmpty',
                'Int'
            )
            
        ));
        
        
        
        
        
        
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Sale',
            'class' => 'btn btn-primary'
        ));
        
        $this->addElement('hash', 'csrf', array(
            'ignore' => true
        ));
        
    }
}
