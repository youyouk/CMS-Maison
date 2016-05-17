<?php
require '../admin/config.php'; 
require '../inc/PHPMailerAutoload.php'; 
include '../admin/html/header.php'; 
if (parametre(33, $bdd) != 'NON') {
	
	/**************************************************************
				RENVOI MDP ? 
	***************************************************************/
	if(isset($_POST['renvoi'])) {
		if (($_POST['EMAIL']) == "") {
			// Erreur : email invalide
			header('Location: '.$_SERVER['PHP_SELF'].'?u=1');
		} else {			
			$EMAIL 	= $_POST['EMAIL'];
			$IP 	= $_POST['IP'];
			$now = time();
			if (isset($_POST['EMAIL'])) {
				if (checkbrute($EMAIL, $bdd) != true) { 
					//$prep_stmt = "SELECT * FROM ADMIN_UTILISATEURS WHERE EMAIL = '$EMAIL' AND ID NOT LIKE '1'  "; RENVOI TT LE MONDE SAUF ADMIN DU SITE
					$prep_stmt = "SELECT * FROM ADMIN_UTILISATEURS WHERE EMAIL = '$EMAIL' ";
					$stmt = $bdd->prepare($prep_stmt);
					$stmt->execute();
					if ($stmt->rowCount() > 1) { 
						// Erreur : Plusieurs utilisateurs avec le même email
						$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '2', '$IP')"); 
						header('Location: '.$_SERVER['PHP_SELF'].'?u=1');
					} else if ($stmt->rowCount() < 1) { 
						// Erreur : Aucun utilisateur avec le même email
						$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '2', '$IP')"); 
						header('Location: '.$_SERVER['PHP_SELF'].'?u=9'); 
					} else {
						// On récupère les infos
						$donnees = $stmt->fetch();
						// On envoie l'email 
						$mail = new PHPMailer;
						$mail->From = "ne-pas-repondre@".$_SERVER['HTTP_HOST'];
						$mail->FromName = parametre(4, $bdd); 
						$mail->addReplyTo(parametre(1, $bdd)); 
						$mail->addAddress($donnees['EMAIL']);
						$mail->isHTML(true); 
						$mail->Subject = "Votre mot de passe";
						$mail->Body = "Suite à votre demande, <b><a href=\"".parametre(6, $bdd)."/admin/reinitialiser.php?ID=".$donnees['ID']."&SEL=".$donnees['SEL']."\" target =\"blank\">cliquez-ici pour modifier votre mot de passe</a></b> d'accès à l'admin du site ".parametre(4, $bdd).". N'oubliez pas de supprimer cet email une fois que votre mot de passe aura été changé.<br />";   
						if (!$mail->send()) {
							echo '<div class="alert alert-danger">Erreur d\'envoi du mail : ' . $mail->ErrorInfo .'</div>';
						} else {
							$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '5', '$IP')");
							header('Location: '.$_SERVER['PHP_SELF'].'?m=11');
						} 
					} 
				}	else  {
				// Bruteforce
				header("Location: ../admin/login.php?e=4");
				return false;
				}
			} else { 
				header('Location: '.$_SERVER['PHP_SELF'].'?u=2'); 
			}
		} 
	}
	?>  
	<br />
	<form action="" method="post" name="post"> 
		
		<div class="form-group"> 
			<div class="col-md-6">
				<p><label>Email</label>
				<input type="email" id="EMAIL" name="EMAIL" value=""required/>
				</p>
				<p id="clear">&nbsp;</p> 
				
			</div>
			
			<div class="col-md-5">
				<p class=" alert alert-info">Saisissez votre email pour recevoir la procédure de changement de mot de passe.</p> 
			</div>
			
				<p id="clear">&nbsp;</p> 
				
				<input name="IP" type="hidden" value="<?php  echo  $_SERVER['REMOTE_ADDR']; ?>" required /> 
				<a href="./" class=" btn btn-default">Annuler</a> 
				<input name="renvoi" type="submit"  class=" btn btn-large btn-success pull-right" value="Valider" />
		</div>
	</form>   
	<?php 
include'../admin/html/footer.php';

} else {
	header("Location: ../admin/login.php?e=6");
}

?>