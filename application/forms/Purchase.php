<?php

class Application_Form_Purchase extends Zend_Form
{
    protected $supplierMapper = null;
    
    
    public function __construct()
    {
      
        $this->supplierMapper = new Application_Model_SupplierMapper();
        
        parent::__construct();
    }
    
    
    
    public function init()
    {
        
        
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->addElement('select', 'supplier_id', array(
            'label' => 'Supplier',
            'class' => 'form-control col-4 col-sm-8',
            'required' => true,
            'filters' => array(
                'StringTrim',
                'StripTags'
            )
        ));
        $options = array();
        $data    = $this->supplierMapper->fetch([
            'status'    => 1
        ]);
        if ($data) {
            foreach ($data as $item) {
                $options[$item->getSupplierId()] = $item->getName();
            }
        }
        
        $this->getElement('supplier_id')->setMultiOptions($options);
        
        
        
        
        
        $this->addElement('text', 'amount', array(
            'label' => 'Amount',
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
            'label' => 'Purchase',
            'class' => 'btn btn-primary'
        ));
        
        $this->addElement('hash', 'csrf', array(
            'ignore' => true
        ));
        
    }
}
