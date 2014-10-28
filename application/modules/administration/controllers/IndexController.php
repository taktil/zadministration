<?php

class Administration_IndexController extends Zend_Controller_Action
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
        
        $this->view->page_select="accueil";
    }
	
   
    public function indexAction()
    {
    	
    	$tbl_page=new Application_Model_DbTable_Page();
    	$id=1;
    	$page=$tbl_page->find($id)->current();
    	
    	if($page){

	    	$request=$this->getRequest();
	    	
	    	if ($request->isPost()) {
	    		if($request->getParam('titre')){
	    			$img_name=$page->image;
	    			// if($_FILES['image']['size']>0){
	    			// 	$img_name="ando-travel-pub-".time().".jpg";
	    			// 	$targetPath = "photos/".$img_name;
	    			// 	FNC::copyImg($_FILES['image']['tmp_name'], 480, 390, $targetPath);
	    			// }
	    			
	    			
		    		$data = array(
		    				"titre"=>$this->getParam("titre",''),
		    				"soustitre"=>$this->getParam("soustitre",''),
		    				"minidescription"=>FNC::cleanHtmlTags($this->getParam("minidescription",'')),
		    				"description"=>FNC::cleanHtmlTags($this->getParam("description",'')),
		    				"description2"=>FNC::cleanHtmlTags($this->getParam("description2",'')),

		    				"titre_en"=>$this->getParam("titre_en",''),
		    				"soustitre_en"=>$this->getParam("soustitre_en",''),
		    				"minidescription_en"=>FNC::cleanHtmlTags($this->getParam("minidescription_en",'')),
		    				"description_en"=>FNC::cleanHtmlTags($this->getParam("description_en",'')),
		    				"description2_en"=>FNC::cleanHtmlTags($this->getParam("description2_en",'')),

		    				"visible"=>$this->getParam("visible",1),
		    				"image"=>$img_name,
		    				"lien"=>$this->getParam("lien",""),
		    		);
		    		
		    		$tbl_page->update($data,array("id=?"=>$id));
		    		$this->redirect('/administration/index');
	    		}
	    		
	    		
	    		
	    		
	    		
	    		
	    		
	    	}
	    	
	    	$this->view->ong=$this->getParam('ong',null);
	    	
	    	$this->view->article=$page;
	    	
	    	
	    	
    	}else{
    		$this->redirect('/administration');
    	}
    }
    
    
}



