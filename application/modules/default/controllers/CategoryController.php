<?php

class CategoryController extends BaseController
{
    protected $categoryMapper=null;

    public function init()
    {
    $this->categoryMapper =new Application_Model_CategoryMapper();
       parent::init();
    }

    public function indexAction()
    {
       $this->view->categories=$this->categoryMapper->fetchAll();
    }

    public function activateAction(){
        $id=$this->getRequest()->getParam('id',0);
        $category=$this->categoryMapper->find($id);
        $category->enable();
        $this->categoryMapper->save($category);
        $this->_helper->redirector('index');

    }

    public function deactivateAction(){
        $id=$this->getRequest()->getParam('id',0);
        $category=$this->categoryMapper->find($id);
        $category->disable();
        $this->categoryMapper->save($category);
        $this->_helper->redirector('index');

    }

    public function updateAction()
    {
    	$id=$this->getRequest()->getParam('id',0);
        $category=$this->categoryMapper->find($id);
        if(!$category){
            throw new Exception("Category with category id {$id} not found.");
        }
        $form=new Application_Form_Category(true);

        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getPost())){
                // form is valid
                $data=$form->getValues();
                // $category->setOptions($data);
                $category->setCategory($data['category']);
                $this->categoryMapper->save($category);
               $this->_helper->redirector('index');
            }
        }
        $form->populate($category->toArray());
        $this->view->categoryform=$form;
    }
    public function addAction()
    {
         $form=new Application_Form_Category();
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getPost())){
                // form is valid
                $data=$form->getvalues();
                $category=new Application_Model_Category();
                $category->setCategory($data['category']);
                 $categoryMapper=new Application_Model_CategoryMapper();

                $categoryMapper->save($category);
                $this->_helper->redirector('index');


            }
        }

        $this->view->categoryform=$form;
        //action body
    }
    public function deleteAction(){
        $id=$this->getRequest()->getParam('id',0);
        $category=$this->categoryMapper->find($id);
        if(!$category){
            throw new Exception("No categorys found.");
        }
        $this->categoryMapper->deleteById($id);
         $this->_helper->redirector('index');
    }


}

