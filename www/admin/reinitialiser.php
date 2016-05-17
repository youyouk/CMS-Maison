<?php 
require '../admin/config.php'; 
include '../admin/html/header.php';
if (parametre(33, $bdd) != 'NON') {

	if (isset($_GET['ID'], $_GET['SEL'] )) {
		$ID 	= $_GET['ID'];
		$SEL 	= $_GET['SEL']; 
		/**************************************************************
					MODIFICATION MDP ? 
		***************************************************************/
		if(isset($_POST['update'])) {
			if (($_POST['MDP']) != ($_POST['confirmMDP'])) {
				// Erreur : les mots de passe ne correspondent pas
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&SEL='.$SEL.'&e=12');
			} else {
				$ID 	= $_POST['ID'];
				$EMAIL 	= $_POST['EMAIL'];
				$SEL 	= $_POST['SEL'];
				$MDP1 	= $_POST['MDP'];
				$MDP2 	= $_POST['confirmMDP'];
				$MDP 	= hash('sha512', $MDP1 . $SEL);
				$IP 	= $_POST['IP'];
				$now = time();
				if (isset($_POST['ID'], $_POST['MDP'], $_POST['EMAIL'], $_POST['SEL'])) {
					$prep_stmt = "SELECT ID FROM ADMIN_UTILISATEURS WHERE SEL = '$SEL' AND ID LIKE '$ID'  AND EMAIL = '$EMAIL' ";
					$stmt = $bdd->prepare($prep_stmt);
					$stmt->execute();
					//$stmt->store_result();
			 
					if ($stmt->rowCount() > 1) { 
						// Erreur : Plusieurs utilisateurs avec le même sel et le même ID
						$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '4', '$IP')"); 
						header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&SEL='.$SEL.'&u=7'); 
					} else if ($stmt->rowCount() < 1) { 
						// Erreur : Aucun utilisateur avec le même sel, le même ID et le même EMAIL
						$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '4', '$IP')"); 
						header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&SEL='.$SEL.'&u=9'); 
					} else {  
						$query = 'UPDATE ADMIN_UTILISATEURS SET MDP = :MDP WHERE ID = :ID AND EMAIL = :EMAIL';
						$stmt= $bdd->prepare($query);
						if( $stmt->execute(array( 
							':MDP' => $MDP,
							':ID' => $ID,
							':EMAIL' => $EMAIL))) {
								// Modif OK
								$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '6', '$IP')");
								// On recharge la page							
								header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&SEL='.$SEL.'&m=10');
							} else {
								// Echec modif 
								$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '4', '$IP')"); 
								header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&SEL='.$SEL.'&e=11');
							}
					} 
				} else { 
					// Formulaire incomplet 
					header('Location: '.$_SERVER['PHP_SELF'].'?u=2'); 
				}	
			}	
		}
		?>
		<script type="text/JavaScript" src="../ressources/js/sha512.js"></script> 
		<script type="text/JavaScript" src="../ressources/js/admin.js"></script>
		<br />
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value="<?php if(isset($_GET['ID'])) { echo $ID; } else { echo "Erreur"; } ?>" /> 
			<input name="SEL" type="hidden" size="0" value="<?php if(isset($_GET['SEL'])) { echo $SEL; } else { echo "Erreur"; } ?>" /> 
			<input name="IP" type="hidden" value="<?php  echo  $_SERVER['REMOTE_ADDR']; ?>" required />
			
			<div class="form-group"> 
				<div class="col-md-6">
					<p><label>Votre Email</label>
					<input type="email" id="EMAIL" name="EMAIL" value=""required/>
					</p>
					
					<p id="clear">&nbsp;</p>
					<p><label>Nouveau mot de passe</label>
					<input type="text" id="MDP" name="MDP" value=""required/>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Confirmez-le</label> 
					<input id="confirmMDP" name="confirmMDP" type="text" value=""required/>
					</p>
					<p id="clear">&nbsp;</p> 
					
				</div>
				
				<div class="col-md-5">
					<p id="clear">&nbsp;</p> 
					<p class=" alert alert-info">Le mot de passe doit contenir au moins 6 caractères dont :<br />
					<br />• Au moins une majuscule
					<br />• Au moins une minuscule
					<br />• Au moins un chiffre</p> 
					<p id="clear">&nbsp;</p> 
					<input name="update" type="submit"  class=" btn btn-large btn-success pull-right" value="Mettre à jour le mot de passe" onclick="return regformrenit(this.form, this.form.MDP, this.form.confirmMDP);"/>
				</div>
				
					<p id="clear">&nbsp;</p> 
					
					<a href="./" class=" btn btn-default">Annuler</a>
			</div>
		</form>   
		<?php
		} else if (($_SERVER['QUERY_STRING']) != "u=8") { 
				header('Location: '.$_SERVER['PHP_SELF'].'?u=8'); 
			exit;
	}  
	include'../admin/html/footer.php';

} else {
	header("Location: ../admin/login.php?e=6");
}

?>