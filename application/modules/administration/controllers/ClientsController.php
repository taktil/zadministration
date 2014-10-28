<?php

class Administration_ClientsController extends Zend_Controller_Action
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
        
        $this->view->page_select="clients";
    }

    public function indexAction(){
        $tbl_client=new Application_Model_DbTable_Client();
        $clients=$tbl_client->fetchAll($tbl_client->select()->order("id desc"));
        $this->view->clients=$clients;
    }

    public function detailsAction(){

    	$tbl_client=new Application_Model_DbTable_Client();
        $id=$this->getParam('id',0);
        $client=$tbl_client->find($id)->current();
        if($client){
            $this->view->client=$client;
        }else{
            throw new Zend_Controller_Action_Exception("Error Processing Request", 404);
            
        }

    }

}



