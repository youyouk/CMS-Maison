<?php
ob_start(); 
include "./html/header.php"; 
// Captcha tout simple
$code = '';
$i = 0;
	while ($i < 4) { 
	$code .= substr('23456789ABCDEFGHJKMNPQRSTVWXYZ', mt_rand(0, strlen('23456789ABCDEFGHJKMNPQRSTVWXYZ')-1), 1);
	$i++;
} 
?>

<?php if (parametre(23, $bdd) != 'NON') { ?>
	<br /><div id="map" style="width: 300px; height: 150px; float: right;margin-top:17px;"><?php echo parametre(23, $bdd); ?></div>
<?php }
	if ((parametre(15, $bdd) != 'NON') || (parametre(16, $bdd) != 'NON')) { 
		echo '<h3>Coordonnées</h3>'; 
		echo '<p style="text-align:center;">'; 
		if (parametre(16, $bdd) != 'NON') {
			echo parametre(16, $bdd);
			echo '<br />';
		}
		if (parametre(15, $bdd) != 'NON') {
			echo parametre(15, $bdd);
		}
		echo '</p>';
	}

	if (parametre(23, $bdd) != 'NON') {
		echo '<p id="clear">&nbsp;</p>';
	}

	if (page_publiee("contact", $bdd) != false) {
		
		$erreur_msg = "";
		if((isset($_POST['EMAIL'])) && ($erreur_msg == "")) {

		function died($error) {
			echo "<p>Votre message n'a pas été envoyé :</p>";
			echo '<br /><div class="alert alert-danger"><ul style="color:#C12700">';
			echo $error."</ul></div><br />";
			echo '<input type="button" onclick="javascript:history.back()";" class="btn " value="Retourner au formulaire"><p>&nbsp;</p>';
			die();
		}

		if (!isset($_POST['TYPE']) ||
			!isset($_POST['NOM']) ||
			!isset($_POST['EMAIL']) ||
			!isset($_POST['CP']) ||
			!isset($_POST['MESSAGE']) ||
			!isset($_POST['IP']) ||
			!isset($_POST['CAPTCHA']) ||
			!isset($_POST['CAPTCHA_OK']) ||
			!isset($_POST['DESTINATAIRE'])) {
				died('Merci de compléter votre formulaire.');       
			}
		$TYPE 			= $_POST['TYPE']; 
		$NOM 			= $_POST['NOM'];
		$EMAIL 			= $_POST['EMAIL'];
		$TELEPHONE 		= $_POST['TELEPHONE'];
		$ADRESSE 		= $_POST['ADRESSE'];
		$CP 			= $_POST['CP']; 
		$VILLE 			= $_POST['VILLE']; 
		$MESSAGE 		= $_POST['MESSAGE']; 
		$IP 			= $_POST['IP']; 
		$DESTINATAIRE 	= $_POST['DESTINATAIRE']; 
		
		
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if(!preg_match($email_exp,$EMAIL)) { 
			$erreur_msg .= '<li>L\'email n\'est pas valide</li>';
		}
		
		$string_exp = "/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]{1,75})$/";
		if(!preg_match($string_exp,$NOM)) {
			$erreur_msg .= '<li>Le nom n\'est pas valide</li>';
		}
		
		if(strlen($MESSAGE) < 10) {
			$erreur_msg .= '<li>Votre message est trop court</li>';
		}
		if(strcasecmp($_POST["CAPTCHA_OK"], $_POST["CAPTCHA"]) != 0) {
			$erreur_msg .= '<li>Code de sécurité incorrect</li>';
		}
		
		/* DESTINATAIRE */ 
		if($DESTINATAIRE == "1") {
			$dest_email = "p.satge@cavac.fr";
			$dest_nom = "Perrine SATGE";
		}  else if($DESTINATAIRE == "2") { 
			$dest_email = "c.marsat@cavac.fr";
			$dest_nom = "Christian MARSAT";
		}  else if($DESTINATAIRE == "3") { 
			$dest_email = "f.barboteau@cavac.fr";
			$dest_nom = "Florent BARBOTEAU";
		}  else {
			//$dest_email = parametre(1, $bdd);
			$dest_email = "h.jousseaume@cavac.fr";
			$dest_nom = "Webmaster";
		}
		/* VOUS ETES */
		/* if($TYPE == "1") {
			$TYPE_NOM = "Particulier";
		} else if($TYPE == "2") {
			$TYPE_NOM = "Professionnel";
		}  else if($TYPE == "3") {
			$TYPE_NOM = "Collectivité"; 
		}  else if($TYPE == "4")  {
			$TYPE_NOM = "Autre";
		} */
		  
		if(strlen($erreur_msg) > 0) {
			died($erreur_msg);
		} else {

			function clean_string($string) {
				$malsain = array("content-type","bcc:","to:","cc:","href", "<", ">", "%");
				return str_replace($malsain,"",$string);
			}
		 

			$objet = "Message via le site ". parametre(4, $bdd);

			//$msg = "Voici les détails concernant cette demande : <br /><br />";
			$msg = "<b>Service concerné :</b> ".clean_string($dest_nom)."<br /><br />"; 
			$msg .= "<b>Nom du contact :</b> ".clean_string($NOM)."<br />";
			$msg .= "<b>Activité :</b> ".clean_string($TYPE)."<br />"; 
			$msg .= "<b>Adresse :</b> ".clean_string($ADRESSE)."<br />";
			$msg .= "<b>Code postal :</b> ".clean_string($CP)."<br />";
			$msg .= "<b>Ville :</b> ".clean_string($VILLE)."<br />";
			$msg .= "<b>Téléphone :</b> ".clean_string($TELEPHONE)."<br />";
			$msg .= "<b>Email :</b> ".clean_string($EMAIL)."<br /><br />";
			$msg .= "<b>Message :</b> ".clean_string($MESSAGE)."<br /><br />"; 
			$msg .= "<b>IP :</b> ".clean_string($IP)."<br /><br />";
			$msg .= "Ce message a été enregistré dans <a href=\"".parametre(6, $bdd)."/admin/\" target =\"blank\">l'admin du site ".parametre(4, $bdd)."</a>, connectez-vous pour le consulter ultérieurement.<br /><br />";

			$headers = 'From: '.$EMAIL."\r\n".
			'Content-type: text/html; charset=UTF-8'."\r\n".
			'Reply-To: '.$EMAIL."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			 
			// On enregistre le message
			$DATE 		= time();
			$TYPE 		= $_POST['TYPE'];
			$NOM 		= $_POST['NOM'];
			$EMAIL 		= $_POST['EMAIL'];
			$TELEPHONE 	= $_POST['TELEPHONE'];
			$ADRESSE 	= $_POST['ADRESSE'];
			$CP 		= $_POST['CP'];
			$VILLE 		= $_POST['VILLE'];
			$IP 		= $_POST['IP'];
			$MESSAGE 	= $_POST['MESSAGE'];
			$DESTINATAIRE 	= $dest_nom;
			
			$query = 'INSERT INTO ADMIN_MESSAGES ( DATE,  TYPE,  NOM,  EMAIL,  TELEPHONE,  ADRESSE,  CP,  VILLE,  MESSAGE,  IP,  DESTINATAIRE)
										 VALUES ( :DATE, :TYPE, :NOM, :EMAIL, :TELEPHONE, :ADRESSE, :CP, :VILLE, :MESSAGE, :IP, :DESTINATAIRE)';

			$statement= $bdd->prepare($query);	
				
			if( $statement->execute(array(
				':DATE' 	=> $DATE,
				':TYPE' 	=> $TYPE,
				':NOM' 		=> $NOM,
				':EMAIL' 	=> $EMAIL,
				':TELEPHONE'=> $TELEPHONE,
				':ADRESSE' 	=> $ADRESSE,
				':CP' 		=> $CP,
				':VILLE' 	=> $VILLE,
				':IP' 		=> $IP,
				':DESTINATAIRE'	=> $DESTINATAIRE,
				':MESSAGE' 	=> $MESSAGE)))
					{
						// On envoie l'email
						@mail($dest_email, $objet, $msg, $headers);
					} else {
						echo ('<div class="alert alert-danger"><strong>Echec enregistrement du message</strong></div>');
					}
				}
?>
<p id="clear">&nbsp;</p>
<h2>Message envoyé</h2>
 <div class="alert alert-success" style="padding: 15px;"><p><?php echo parametre(17, $bdd); ?></p></div>

<?php }	else { ?>  
<?php require "./html/content.php"; ?>
 
<h2>Formulaire de contact</h2>
<form method="post" action="contact.php" name="contacter" class="form"> 
		<div class="form-group">
		  <input name="IP" type="hidden" value="<?php  echo  $_SERVER['REMOTE_ADDR']; ?>" required />
		  <input name="CAPTCHA_OK" type="hidden" value="<?php echo $code;?>" /> 
			<div class="col-md-6">
				
				<p><label>Nom <span class="required">*</span></label>
				<input name="NOM" type="text" value="<?php if(isset($_POST['NOM'])) echo $NOM; ?>" required />
				</p>
				
				<p id="clear">&nbsp;</p>
			
				<p><label>Email <span class="required">*</span></label>
				<input name="EMAIL" type="text" value="<?php if(isset($_POST['EMAIL'])) echo $EMAIL; ?>" required />
				</p>
				
				<p id="clear">&nbsp;</p>
				
				<p><label>Téléphone</label>
				<input name="TELEPHONE" type="text" value="<?php if(isset($_POST['TELEPHONE'])) echo $TELEPHONE; ?>" />
				</p>
				
				<p id="clear">&nbsp;</p>
				
				<p><label>Destinataire du message</label>
					<select name="DESTINATAIRE" required>
						<option value="2">Christian MARSAT</option>
						<option value="1">Perrine SATGE (secteur Nord)</option>
						<option value="3">Florent BARBOTEAU (secteur Sud)</option>
						<!--<option value="5">Webmaster</option>-->
					</select> 
				</p>
			</div>
				
			<p id="clear" class="visible-phone">&nbsp;</p>
			
			<div class="col-md-5 " >
			
				<p><label>Vous êtes</label> 
				<select name="TYPE">
					<option value="Particulier">Particulier</option>
					<option value="Professionnel">Professionnel</option>
					<option value="Collectivité">Collectivité</option>
					<option value="Autre">Autre</option>
				</select>
				</p>
			
				<p id="clear">&nbsp;</p>
				
				<p><label>Adresse</label>
				<input name="ADRESSE" type="text" value="<?php if(isset($_POST['ADRESSE'])) echo $ADRESSE; ?>" />
				</p>
				
				<p id="clear">&nbsp;</p>
				
				<p><label>Code postal <span class="required">*</span></label>
				<input name="CP" type="text" value="<?php if(isset($_POST['CP'])) echo $CP; ?>" required />
				</p>
				
				<p id="clear">&nbsp;</p>
				
				<p><label>Ville</label>
				<input name="VILLE" type="text" value="<?php if(isset($_POST['VILLE'])) echo $VILLE; ?>" />
				</p>
				
				<p id="clear">&nbsp;</p> 
				
			</div> 
			
			<p id="clear">&nbsp;</p>
			
			<div class="col-md-6"> 
				<p id="clear">&nbsp;</p>
				<p><label>Message <span class="required">*</span></label>
				<textarea name="MESSAGE" cols="40" rows="9"><?php if(isset($_POST['MESSAGE'])) echo $MESSAGE; ?></textarea>
				</p>
				 
			</div>
				
			<p id="clear" class="visible-phone">&nbsp;</p>
			
			<div class="col-md-5 " >
				<p id="clear">&nbsp;</p>
				
				<p><label>Merci de recopier ce code : <span class="required"><?php echo $code;?></span></label> 
				<input id="CAPTCHA" name="CAPTCHA" type="text" value="<?php /* echo $code; */?>" style=" width: 100px; " required/>
				</p>  
				<p id="clear">&nbsp;</p>
				<p id="clear">&nbsp;</p>
				<p id="clear">&nbsp;</p>
				<input type="submit" class="btn btn-large btn-success pull-right" value="Envoyer" /> 
			</div> 
		</div>
		
		  
		<p id="clear">&nbsp;</p>
		<p><small><em><span class="required">* champs requis</span></p>
		<p class="alert alert-info">Les données que vous nous communiquerez ne seront pas transmises à des tiers et ne seront utilisées que pour le traitement de votre demande. Conformément à la loi informatique et libertés du 06-01-1978, vous disposez d'un droit d'accès et de rectification aux informations vous concernant.</em></small></p>
</form>   
<?php
	} 
} else {
	/* Afficher la page d'accueil */
	header('Location: index.php');
}
$stmt->closeCursor();
include "./html/footer.php";
?>

