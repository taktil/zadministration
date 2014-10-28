<?php

class Administration_CategorieController extends Zend_Controller_Action
{

    public function init()
    {
    	$admin_user = new Zend_Session_Namespace('admin_user');
        if(!Zend_Auth::getInstance()->hasIdentity() or !isset($admin_user->user))
        {
            $this->redirect('/administration/login');
        }
        
        /* Initialize action controller here */
        
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayoutPath(APPLICATION_PATH."/layouts/scripts/admin/");
        
        $this->view->page_select="categorie";

    }
	
    public function indexAction()
    {

    	$tbl_categorie=new Application_Model_DbTable_Categorie();
    	$categories=$tbl_categorie->fetchAll();
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		 
    		$data = array(
    				"libelle"=>$this->getParam("libelle",''),
    				"description"=>$this->getParam("description",''),
    		);
    		 
    		$tbl_categorie->insert($data);
    		$this->redirect('/administration/categorie');
    	}
    	
    	$this->view->categories=$categories;
    }
    
    	
    	
    public function supprimerAction()
    {
        throw new Zend_Controller_Action_Exception("Error Processing Request", 1);
        
    }
    public function modifierAction()
    {

    	$tbl_categorie=new Application_Model_DbTable_Categorie();
    	$id=$this->getParam("id");
    	
    	$categorie=$tbl_categorie->find($id)->current();
       
    	if($categorie){
    		$request=$this->getRequest();
    	
    		if ($request->isPost()) {
    			
    				$data = array(
    						"libelle"=>$this->getParam("libelle",''),
    						"description"=>$this->getParam("description",''),
    				);
    	
    				$tbl_categorie->update($data,array("id=?"=>$id));
    				$this->redirect('/administration/categorie/modifier/id/'.$id);
    		}
    	
    		$this->view->categorie=$categorie;
    	
    	}else{
    		$this->redirect('/administration/categorie');
    	}
    	
    	
    }
    
    
}



