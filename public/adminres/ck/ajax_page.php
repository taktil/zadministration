<?php
	include("../class.pagemoha.php");
	
		if(isset($_POST['op'])){
			$op=$_POST['op'];
			if($op=='del_img'){
				$t=mysql_fetch_array(mysql_query("select * from image where id=$_POST[id] limit 1"));
				@unlink("../images_index/$t[src]");
				@unlink("../images_index/$t[src_m]");
				if(mysql_query("delete from image where id=$_POST[id] limit 1")){
					echo "1";
				}
			}
			
			if($op=='del_press'){
				$t=mysql_fetch_array(mysql_query("select * from press where id=$_POST[id] limit 1"));
				@unlink("../press/$t[src]");
				@unlink("../press/$t[src_1]");
				@unlink("../press/$t[pdf]");
				if(mysql_query("delete from press where id=$_POST[id] limit 1")){
					echo "1";
				}
			}
			if($op=='send_resa'){
				$sujet = "Reservation - darmoha.com";
				$From  = "From:".$_POST['email']."\n";
				$From .= "MIME-version: 1.0\n";
				$From .= "Content-type: text/html; charset= utf-8\n";
				$contenu="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=unicode\">
				<meta name=\"Generator\" content=\"Microsoft SafeHTML\">
				<strong>Nom et prenom :  </strong>                  ".htmlentities($_POST['np'])."<br />
				<strong>Email :</strong>                  ".htmlentities($_POST['email'])."<br />
				<strong>T&eacute;l&eacute;phone :</strong>                  ".htmlentities($_POST['tel'])."<br />
				<strong>Date de reservation :</strong>                  ".htmlentities($_POST['date'])."<br /><br />
				<strong>Message :</strong>                ".htmlentities(stripslashes(str_replace('"',"'",$_POST['msg']))); 
				@mail("darmoha@menara.ma",$sujet,$contenu,$From);
				@mail("alwan@live.fr",$sujet,$contenu,$From);
				echo 1;
				
			}
			if($op=='newsletter'){
				$valid_mail=true;
				
				$regex = "/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i";
				$courriel = $_POST['email'];
				if (preg_match($regex, $courriel)) {
				$valid_mail=true;
				} else {
					$valid_mail=false;
				}

				if($valid_mail){
					$q_me=mysql_query("select * from newsletters where email='$_POST[email]'");
					if(mysql_num_rows($q_me)>0){
						echo "E-mail existe deja !";
					}else{
						mysql_query("insert into newsletters values('','$_POST[email]','".$_SERVER['REMOTE_ADDR']."',NOW())");
						echo "E-mail enregistre !";
					}
				}else{
				echo "E-mail invalide !";
				}
			}
		}
		
		
?>