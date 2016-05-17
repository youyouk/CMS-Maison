<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION PROFIL ? 
***************************************************************/
if(isset($_POST['suppression'])) { 
	$ID = $_POST['ID']; 

	$query = 'DELETE FROM ADMIN_UTILISATEURS 
		WHERE ID = :ID';
	
	$stmt = $bdd->prepare($query);
	$stmt->execute(array(
		':ID' => $ID));

	if($stmt) {
		header('Location: '.$_SERVER['PHP_SELF'].'?m=9');
	} else {
		header('Location: '.$_SERVER['PHP_SELF'].'?e=9');
	}
} 
/**************************************************************
			CONFIRMATION SUPPRESSION
***************************************************************/ 
$check= !empty($_GET['ID']);
if($check==true) {

	$action = $_GET['action'];
	$ID = $_GET['ID'];
	
	if($action == "suppression"){
		$query = 'SELECT * FROM ADMIN_UTILISATEURS
		WHERE ID = :ID';
		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		
		$donnees = $stmt->fetch();
		echo ('<p>Confirmez-vous la suppression irréversible de l\'utilisateur <strong>'.$donnees['NOM'].'</strong> ?</p>
			<p><form action="utilisateurs.php" method="post" name="post"><br />
				<input name="ID" type="hidden" value="'.$donnees['ID'].'"> 
				<a href="utilisateurs.php" class=" btn btn-default">Retour</a>
				<input name="suppression" type="submit" class=" btn  btn-danger btn-large pull-right" value="Effacer" />
			</form></p>');
	}
} 
/**************************************************************
			LISTING PROFILS 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) {
	/**************************************************************
				AJOUT PROFIL ? 
	***************************************************************/				
	if(isset($_POST['add_post'])) {
		if (isset($_POST['NOM'], $_POST['EMAIL'], $_POST['MDP'], $_POST['SEL'])) {
			$NOM = filter_input(INPUT_POST, 'NOM', FILTER_SANITIZE_STRING);
			$EMAIL = filter_input(INPUT_POST, 'EMAIL', FILTER_SANITIZE_EMAIL);
			$EMAIL = filter_var($EMAIL, FILTER_VALIDATE_EMAIL);
				if (!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) { 
					header('Location: '.$_SERVER['PHP_SELF'].'?u=1'); 
				} 
			$SEL = $_POST['SEL'];
			$MDP = $_POST['MDP'];
 
			$prep_stmt = "SELECT ID FROM ADMIN_UTILISATEURS WHERE EMAIL = :EMAIL LIMIT 1";
			$stmt = $bdd->prepare($prep_stmt);  
			$stmt->execute(array(':EMAIL' => $EMAIL));
			//$stmt->store_result();
	 
			if ($stmt->rowCount() == 1) { 
				header('Location: '.$_SERVER['PHP_SELF'].'?u=3'); 
			} else {  
				$MDP = hash('sha512', $_POST['MDP'] . $SEL);
				$query = 'INSERT INTO ADMIN_UTILISATEURS ( NOM, EMAIL, MDP, SEL) VALUES ( :NOM, :EMAIL, :MDP, :SEL)'; 
				$stmt= $bdd->prepare($query);
				if( $stmt->execute(array( 
						':NOM' => $NOM,
						':EMAIL' => $EMAIL,
						':MDP' => $MDP,
						':SEL' => $SEL))) {
							header('Location: '.$_SERVER['PHP_SELF'].'?m=7');
						} else {
							header('Location: '.$_SERVER['PHP_SELF'].'?e=7');
						}
			} 
		} else { 
			header('Location: '.$_SERVER['PHP_SELF'].'?u=5'); 
		}
	}
?> 
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-list-ul fa-1x"></i> Liste</a></li> 
	<li role="presentation"><a href="#nouveau" aria-controls="nouveau" role="tab" data-toggle="tab"><i class="fa fa-plus fa-1x"></i> Ajouter un utilisateur</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="modifications"> 
		<table class="table table-responsive table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Email</th>
					<th>Dernière connexion</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php  
			$reponse = $bdd->query('SELECT * FROM ADMIN_UTILISATEURS ORDER BY ID DESC');
			while ($donnees = $reponse->fetch()) {
			echo '
			<tr>
				<td>'. $donnees['NOM'].'</td>
				<td>'. $donnees['EMAIL'].'</td>
				<td>';
					$requete = "SELECT * FROM ADMIN_LOGS WHERE EMAIL = '".$donnees['EMAIL']."' ORDER BY DATE DESC LIMIT 1";
					$details = $bdd->prepare($requete);
					$details->execute();
					if($details->rowCount() == 1) {
						while ($resultat = $details->fetch()) {
							echo 'Le '. date('d/m/Y à H:i', $resultat['DATE']);
						} 
					} else {
						echo "Aucune";
					}
				echo'</td>
				<td style="text-align:center;">
						<a href="utilisateurs.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				if (($donnees['ID'] != "1") && ($_SESSION['ID'] = "1")) {
				echo '
						<a href="utilisateurs.php?action=suppression&ID='.$donnees['ID'].'" class=" btn btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>
					';
				}
			echo '</td></tr>';
			}
			$reponse->closeCursor();
			?>
		  </tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="nouveau">
		<script type="text/JavaScript" src="../ressources/js/sha512.js"></script> 
		<script type="text/JavaScript" src="../ressources/js/admin.js"></script>
		<br />
		<form action="" method="post" name="post">
			<input id="SEL" name="SEL" type="hidden" value="<?php echo hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); ?>" />
			
			<div class="form-group">
				
				<p id="clear">&nbsp;</p>
				
				<div class="col-md-6">
					<p><label>Nom</label> 
					<input id="NOM" name="NOM" type="text" class="form-control" value="<?php if(isset($_GET['NOM'])) echo $NOM; ?>" required>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Email</label> 
					<input id="EMAIL" name="EMAIL" type="text" class="form-control" value="<?php if(isset($_GET['EMAIL'])) echo $EMAIL; ?>" required>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Mot de passe</label>
					<input type="text" id="MDP" name="MDP" value="<?php if(isset($_GET['MDP'])) echo $MDP; ?>"required/>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Confirmer mot de passe</label> 
					<input id="confirmMDP" name="confirmMDP" type="text" value="<?php if(isset($_GET['confirmMDP'])) echo $confirmMDP; ?>"required/>
					</p>
					
				</div>
				
				
				<div class="col-md-5">
					<p id="clear">&nbsp;</p>
				<p id="clear" class="visible-phone">&nbsp;</p>
					<p class="alert alert-info">Le mot de passe doit contenir au moins 6 caractères dont :<br />
					<br />• Au moins une majuscule
					<br />• Au moins une minuscule
					<br />• Au moins un chiffre</p>
					<p id="clear">&nbsp;</p> 
					 
					<input name="add_post" type="submit"  class=" btn btn-large btn-success pull-right" value="Ajouter" onclick="return regformhash(this.form, this.form.NOM, this.form.EMAIL, this.form.MDP, this.form.confirmMDP);"/>
				</div>
				
			</div>
		</form>
	</div>
</div>
<?php }
$check= !empty($_GET['ID']);
if($check==true) { 
	/**************************************************************
				MODIFICATION PROFILS ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])){
		if (isset($_POST['NOM'], $_POST['EMAIL'], $_POST['MDP'] )) {
			$ID = $_POST['ID'];
			$SEL = $_POST['SEL'];
			$NOM = filter_input(INPUT_POST, 'NOM', FILTER_SANITIZE_STRING);
			$EMAIL = filter_input(INPUT_POST, 'EMAIL', FILTER_SANITIZE_EMAIL);
			$EMAIL = filter_var($EMAIL, FILTER_VALIDATE_EMAIL);
				if (!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)) { 
					header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&u=1'); 
				}
			$MDP = hash('sha512', $_POST['MDP'] . $SEL);
			$prep_stmt = "SELECT ID FROM ADMIN_UTILISATEURS WHERE EMAIL = '$EMAIL' AND ID NOT LIKE '$ID'  ";
			$stmt = $bdd->prepare($prep_stmt);
			$stmt->execute();
			//$stmt->store_result();
	 
			if ($stmt->rowCount() > 1) { 
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&u=3'); 
			} else { 
				$query = 'UPDATE ADMIN_UTILISATEURS SET
					 NOM = :NOM, 
					 EMAIL = :EMAIL, 
					 MDP = :MDP,
					 SEL = :SEL
					 WHERE ID = :ID';

				$stmt= $bdd->prepare($query);
				if( $stmt->execute(array(
					':NOM' => $NOM,
					':EMAIL' => $EMAIL,
					':MDP' => $MDP,
					':SEL' => $SEL,
					':ID' => $ID))) {
						header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&m=8');
					} else {
						header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&e=8');
					}
			} 
		} else { 
			header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&e=2'); 
		}		
	}
	/**************************************************************
				MODE MODIFICATION
	***************************************************************/ 
	if($action == "edit"){
		$query = 'SELECT * FROM ADMIN_UTILISATEURS
		WHERE ID = :ID';				
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));				
		$donnees = $stmt->fetch(); ?>
		<script type="text/JavaScript" src="../ressources/js/sha512.js"></script> 
		<script type="text/JavaScript" src="../ressources/js/admin.js"></script>
		<br />
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" /> 
			<input name="SEL" type="hidden" size="0" value="<?php echo hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); ?>" /> 
			
			<div class="form-group">
				
				
				<div class="col-md-6">
					<p><label>Nom</label> 
					<input id="NOM" name="NOM" type="text" class="form-control" value="<?php echo $donnees['NOM']; ?>" required>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Email</label> 
					<input id="EMAIL" name="EMAIL" type="text" class="form-control" value="<?php echo $donnees['EMAIL']; ?>" required>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Mot de passe</label>
					<input type="text" id="MDP" name="MDP" value=""required/>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Confirmer mot de passe</label> 
					<input id="confirmMDP" name="confirmMDP" type="text" value=""required/>
					</p>
					
				</div>
				
				<div class="col-md-5 alert alert-info">
					<p>Le mot de passe doit contenir au moins 6 caractères dont :<br />
					<br />• Au moins une majuscule
					<br />• Au moins une minuscule
					<br />• Au moins un chiffre</p>
				</div>
				
					<p id="clear">&nbsp;</p> 
					
					<a href="utilisateurs.php" class=" btn btn-default">Retour</a>
					<input name="update" type="submit"  class=" btn btn-large btn-success pull-right" value="Mettre à jour" onclick="return regformhash(this.form, this.form.NOM, this.form.EMAIL, this.form.MDP, this.form.confirmMDP);"/>
			</div>
		</form>   
	<?php
	}
} 
include'../admin/html/footer.php';
?>