<?php

class Administration_ProduitsController extends Zend_Controller_Action
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
        
        $this->view->page_select="produits";
    }
	public function supprimerjourAction()
    {

    	$tbl_jour=new Application_Model_DbTable_Jour();
    	$idjour=$this->getParam("id",0);
    	$jour=$tbl_jour->find($idjour)->current();
    	if($jour){
    		$id_produit=$jour->produit_id;
    		$jour->delete();
    		$this->redirect("/administration/produits/modifier/id/".$id_produit.'/ong/jours');
    	}
    	exit();
    }
    
    public function supprimerAction()
    {
    	$tbl_produit=new Application_Model_DbTable_Produit();
    	$id=$this->getParam("id",0);
    	$produit=$tbl_produit->find($id)->current();
    	if($produit){
    		
    		$produit->delete();
    		$this->redirect("/administration/produits");
    	}
    	exit();
    }
    
    public function indexAction()
    {
    	$tbl_categorie=new Application_Model_DbTable_Categorie();
    	$tbl_produit= new Application_Model_DbTable_Produit();
    	
    	$request=$this->getRequest();
    	if ($request->isPost()) {

    		if($_FILES['image']['size']>0) {
    			$tempFile = $_FILES['image']['tmp_name'];
    			$image="P".strftime("%d%m%y%H%M%S").".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    			$targetPath = "photos/".$image;
    			$recadrer=$this->getParam("recadrer",0);
    			$recadrer=($recadrer==1)?true:false;
    			FNC::copyImg($_FILES['image']['tmp_name'],200,160,$targetPath,$recadrer);
    		} else {
    			$image="";
    		}
    	
    		
    		
    		$data = array(
    				"categorie_id"=>$this->getParam("categorie_id",0),
    				"libelle"=>$this->getParam("titre",''),
    				"image"=>$image,
    				"ordre"=>0,
    				"visible"=>$this->getParam("visible",1),
    		);
    	
    	
    		$tbl_produit->insert($data);
    		$this->redirect('/administration/produits');
    		}
    		
    	$this->view->categories=$tbl_categorie->fetchAll();
    	$this->view->produits=$tbl_produit->fetchAll();
    	$this->view->ong=$this->getParam("ajouter",0);
    }
    
    public function modifierAction()
    {
    	
    	
    	
    	$tbl_categorie=new Application_Model_DbTable_Categorie();
    	$tbl_produit= new Application_Model_DbTable_Produit();
    	
    	$id=$this->getParam("id");
    	$produit=$tbl_produit->find($id)->current();
    	if($produit){
	    	$request=$this->getRequest();
	    	
	    	
	    	
	    	
	    	
	    	if ($request->isPost()) {

		    		$image=$produit->image;
		    		if($_FILES['image']['size']>0) {
		    			$tempFile = $_FILES['image']['tmp_name'];
		    			$image="P".strftime("%d%m%y%H%M%S").".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
		    			$targetPath = "photos/".$image;
		    			$recadrer=$this->getParam('recadrer',0);
		    			$recadrer=($recadrer==1)?true:false;
		    			
		    			FNC::copyImg($tempFile,200,160,$targetPath,$recadrer);
		    		}
		    		
		    		
		    		$data = array(
		    				"categorie_id"=>$this->getParam("categorie_id",0),
		    				"titre"=>$this->getParam("titre",''),
		    				"code"=>$this->getParam("code",''),
		    				"jour_depart"=>$this->getParam("jour_depart",0),
		    				"prochain_depart"=>FNC::dateFrToMysql($this->getParam("prochain_depart",'')),
		    				"soustitre"=>$this->getParam("soustitre",''),
		    				"minidescription"=>FNC::cleanHtmlTags($this->getParam("minidescription",'')),
		    				"description"=>FNC::cleanHtmlTags($this->getParam("description",'')),

		    				"titre_en"=>$this->getParam("titre_en",''),
		    				"soustitre_en"=>$this->getParam("soustitre_en",''),
		    				"minidescription_en"=>FNC::cleanHtmlTags($this->getParam("minidescription_en",'')),
		    				"description_en"=>FNC::cleanHtmlTags($this->getParam("description_en",'')),

		    				"image"=>$image,
		    				//"tarif_id"=>$this->getParam("tarif_id",0),
		    				"visible"=>$this->getParam("visible",1),
		    				"depart_dimanche"=>$this->getParam("depart_dimanche",0),
							"depart_lundi"=>$this->getParam("depart_lundi",0),
							"depart_mardi"=>$this->getParam("depart_mardi",0),
							"depart_mercredi"=>$this->getParam("depart_mercredi",0),
							"depart_jeudi"=>$this->getParam("depart_jeudi",0),
							"depart_vendredi"=>$this->getParam("depart_vendredi",0),
							"depart_samedi"=>$this->getParam("depart_samedi",0),
		    				 
		    		);
		    		
		    		$tbl_produit->update($data,array("id=?"=>$produit->id));
		    		
		    		

		    		// // modifications destinations 
		    		// $tbl_produit_destination->delete("produit_id=".$produit->id);
		    		// $destinations_s=$this->getParam("destinations",array());
		    		// foreach ($destinations_s as $id_dest){
		    		// 	$tbl_produit_destination->insert(array(
		    		// 			"produit_id"=>$produit->id,
		    		// 			"destination_id"=>$id_dest
		    		// 	));
		    		// }


		    		// // modifications themes 
		    		// $tbl_produit_theme->delete("produit_id=".$produit->id);
		    		// $themes_s=$this->getParam("themes",array());
		    		// foreach ($themes_s as $id_dest){
		    		// 	$tbl_produit_theme->insert(array(
		    		// 			"produit_id"=>$produit->id,
		    		// 			"theme_id"=>$id_dest
		    		// 	));
		    		// }




		    		
		    		$this->redirect('/administration/produits/modifier/id/'.$produit->id);
	    		}


	    		
	    	
	    	
	    	$this->view->ong=$this->getParam('ong',null);
	    	
	    	$this->view->produit=$produit;
	    	
	    	$this->view->categories=$tbl_categorie->fetchAll();
	    	
	    	$this->view->produits=$tbl_produit->fetchAll();
	    	
	    	
    	}else{
    		$this->redirect('/administration');
    	}
    }
    
    
}



