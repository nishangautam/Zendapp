<?php

class Application_Form_Customer extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add an email element
        $this->addElement('text', 'customer', array(
            'label'      => 'Customer Name:',
            'class'=>'form-control col col-sm-4 ',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            
            
        ));

        $this->addElement('text', 'address', array(
            'label'      => 'Address:',
            'class'=>'form-control col col-sm-4',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            
            
        ));
        $this->addElement('text', 'email', array(
            'label'      => 'Email:',
            'class'=>'form-control col col-sm-4',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array(
                'EmailAddress',
            )
            
        ));
        $this->addElement('text', 'contact', array(
            'label'      => 'Contact:',
            'class'=>'form-control col col-sm-4',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            
            
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
