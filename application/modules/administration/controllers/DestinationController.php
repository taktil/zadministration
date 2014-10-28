<?php

class Administration_DestinationController extends Zend_Controller_Action
{

    public function init()
    {
    	$admin_user = new Zend_Session_Namespace('admin_user');
        if(!Zend_Auth::getInstance()->hasIdentity() or !isset($admin_user->user))
        {
            $this->_redirect('administration/login');
        }
        
        /* Initialize action controller here */
        
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayoutPath(APPLICATION_PATH."/layouts/scripts/admin/");
        
        $this->view->page_select="destination";
    }
	
    public function indexAction()
    {
    	$tbl_destination=new Application_Model_DbTable_Destination();
    	$destinations=$tbl_destination->fetchAll();
    	$request=$this->getRequest();
    	if ($request->isPost()) {
    		 
    		$data = array(
    				"libelle"=>$this->getParam("libelle",''),
    				"description"=>$this->getParam("description",''),
    		);
    		 
    		$tbl_destination->insert($data);
    		$this->_redirect('administration/destination');
    	}
    	
    	$this->view->destinations=$destinations;
    }
    
    	
    	
    public function supprimerAction()
    {
    	exit();
    	
    }
    public function modifierAction()
    {

    	$tbl_destination=new Application_Model_DbTable_Destination();
    	$id=$this->getParam("id");
    	
    	$destination=$tbl_destination->find($id)->current();
    	if($destination){
    		$request=$this->getRequest();
    	
    		if ($request->isPost()) {
    			
    				$data = array(
    						"libelle"=>$this->getParam("libelle",''),
    						"description"=>$this->getParam("description",''),
    				);
    	
    				$tbl_destination->update($data,array("id=?"=>$id));
    				$this->_redirect('administration/destination/modifier/id/'.$id);
    		}
    	
    		$this->view->destination=$destination;
    	
    	}else{
    		$this->redirect('/administration/destination');
    	}
    	
    	
    }
    
    
}



