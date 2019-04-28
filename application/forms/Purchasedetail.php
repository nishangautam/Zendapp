<?php

class Application_Form_Purchasedetail extends Zend_Form
{
    
    
    
    public function __construct()
    {
      
        
        
        parent::__construct();
    }
    
    
    
    public function init()
    {
        
        
        // Set the method for the display form to POST
        $this->setMethod('post');
       
        
        
         $this->addElement('text', 'p_id', array(
            'label' => 'purchase Id',
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

          $this->addElement('text', 'product_id', array(
            'label' => 'product_id',
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
        
         $this->addElement('text', 'product_quantity', array(
            'label' => 'product_quantity',
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
          $this->addElement('text', 'price', array(
            'label' => 'price',
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
           $this->addElement('text', 'discount', array(
            'label' => 'discount',
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
