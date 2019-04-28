<?php


class BaseController extends Zend_Controller_Action{

	public function init(){

		parent::init();
		 $auth=Zend_Auth::getInstance();
        if(!$auth->hasIdentity()){
            $this->_helper->redirector('index','admin');
        }

	}

}