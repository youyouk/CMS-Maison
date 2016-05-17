<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION MESSAGE ? 
***************************************************************/
if(isset($_POST['suppression'])){ 
	$ID = $_POST['ID']; 

	$query = 'DELETE FROM ADMIN_MESSAGES 
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
		$query = 'SELECT * FROM ADMIN_MESSAGES
		WHERE ID = :ID';
		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		
		$donnees = $stmt->fetch();
		echo ('<p>Confirmez-vous la suppression irréversible du message <strong>'.$donnees['NOM'].'</strong> ?</p>
			<p><form action="messages.php" method="post" name="post"><br />
				<input name="ID" type="hidden" value="'.$donnees['ID'].'">
				<input name="no" ONCLICK="history.go(-1)" type="button" class=" btn  btn-default" value="Annuler" />
				<input name="suppression" type="submit" class=" btn btn-large btn-danger pull-right" value="Effacer" />
			</form></p>');
	}
}
/**************************************************************
			LISTING MESSAGES 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) { 
	$requete = "SELECT * FROM SITE_PAGES WHERE URL = '/contact.php' AND VISIBLE > 2";				
	$stmt = $bdd->prepare($requete);
	$stmt->execute(); 
	if ($stmt->rowCount() > 0) {
	?>
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-list-ul fa-1x"></i> Liste</a></li> 
	<li role="presentation"><a href="#parametres" aria-controls="parametres" role="tab" data-toggle="tab"><i class="fa fa-cog fa-1x"></i> Paramètres</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="modifications"> 
		<br /> 
	<p>Les messages du formulaires de contact sont enregistrés ici puis transmis à <strong><?php echo parametre(1, $bdd); ?></strong>.</p> 
	<table class="table table-responsive table-striped table-condensed table-hover">
		<thead>
			<tr>
				<th>Date</th>
				<th>Nom</th> 
				<th>Aperçu</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php  
			$reponse = $bdd->query('SELECT * FROM ADMIN_MESSAGES ORDER BY DATE DESC');
			while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td>Le '. date('d/m/Y à H:i', $donnees['DATE']).'</td>
					<td><strong>'. $donnees['NOM'].'</strong><br /><small><em>'. $donnees['EMAIL'].'</em></small></td>
					<td>'. substr(strip_tags($donnees['MESSAGE']), 0, 40).'…</td>
					<td style="text-align:center;"> 
					<a href="messages.php?ID='.$donnees['ID'].'&action=edit" class="btn" ><i class="fa fa-eye fa-1x"></i></a> 
					<a href="messages.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>
					</td>
				</tr>';
				}
			$reponse->closeCursor();
			?>
		</tbody>
	</table> 
<?php } else { ?> 
	<p>Vous devez  <strong>publier la page "Contact"</strong> pour activer le formulaire de contact (<a href="pages.php?ID=6&action=edit">modifier</a>).</p>
	<br />
<?php } ?>
</div>
	<div role="tabpanel" class="tab-pane" id="parametres"> 
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 2 AND ID = 1 OR ID = 17 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>'; 
				echo'<td>';
					if ($donnees['CONTENU'] == "OUI") {
						echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
					} else if ($donnees['CONTENU'] == "NON") {
						echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
					} else {
						echo''.  $donnees['CONTENU'] . ''; 
					}
					echo'</td> ';
				echo'
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
$check= !empty($_GET['ID']);
if($check==true) { 
	/**************************************************************
				MODIFICATION MESSAGE ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])) {
		$DATE 		= $_POST['DATE'];
		$TYPE 		= $_POST['TYPE'];
		$NOM 		= $_POST['NOM'];
		$EMAIL 		= $_POST['EMAIL'];
		$TELEPHONE 	= $_POST['TELEPHONE'];
		$ADRESSE 	= $_POST['ADRESSE'];
		$CP 		= $_POST['CP'];
		$VILLE 		= $_POST['VILLE'];
		$MESSAGE 	= $_POST['MESSAGE'];
		$IP 		= $_POST['IP'];
		$ID 		= $_POST['ID'];
		$DESTINATAIRE 		= $_POST['DESTINATAIRE'];

		
		
		$query = 'UPDATE ADMIN_MESSAGES SET
			 DATE 		= :DATE, 
			 TYPE 		= :TYPE,
			 NOM 		= :NOM, 
			 EMAIL 		= :EMAIL,
			 TELEPHONE 	= :TELEPHONE,
			 ADRESSE 	= :ADRESSE,
			 CP 		= :CP,
			 VILLE 		= :VILLE,
			 IP 		= :IP,
			 DESTINATAIRE 		= :DESTINATAIRE,
			 MESSAGE 	= :MESSAGE
			 WHERE ID 	= :ID';

		$stmt= $bdd->prepare($query);	
			
		if( $stmt->execute(array(
			':DATE' 	=> $DATE,
			':TYPE' 	=> $TYPE,
			':NOM' 		=> $NOM,
			':EMAIL' 	=> $EMAIL,
			':TELEPHONE'=> $TELEPHONE,
			':ADRESSE' 	=> $ADRESSE,
			':CP' 		=> $CP,
			':VILLE' 	=> $VILLE,
			':IP' 		=> $IP,
			':MESSAGE' 	=> $MESSAGE,
			':DESTINATAIRE' 	=> $DESTINATAIRE,
			':ID' 		=> $ID))) {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&m=8');
			} else {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&e=8');
			}
	}	
	/**************************************************************
				MODE MODIFICATION
	***************************************************************/ 
	if($action == "edit"){
		$query = 'SELECT * FROM ADMIN_MESSAGES WHERE ID = :ID';
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		$donnees = $stmt->fetch(); ?> 
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation"><a href="/admin/messages.php"><i class="fa fa-list-ul fa-1x"></i> Retour à la liste</a></li>
				<li role="presentation" class="active"><a href="#apercu" aria-controls="apercu" role="tab" data-toggle="tab"><i class="fa fa-eye fa-1x"></i> Aperçu</a></li> 
				<li role="presentation"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-edit fa-1x"></i> Modifications</a></li>
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="apercu">
					<br />
					<h3><?php echo 'Le '. date('d/m/Y à H:i', $donnees['DATE']); ?></h3> 
						<p><strong>Type de contact :</strong> <?php echo $donnees['TYPE']; ?></p>
						<p><strong>Nom :</strong> <?php echo $donnees['NOM']; ?></p>
						<p><strong>Téléphone :</strong> <?php echo $donnees['TELEPHONE']; ?></p>
						<p><strong>Email :</strong> <?php echo $donnees['EMAIL']; ?></p>
						<p><strong>Adresse :</strong> <?php echo $donnees['ADRESSE']; ?> <?php echo $donnees['CP']; ?> <?php echo $donnees['VILLE']; ?></p>
						<p><strong>Message :</strong> <?php echo $donnees['MESSAGE']; ?></p>
						<p><strong>IP :</strong> <?php echo $donnees['IP']; ?></p>
						<br /> 
					<br />
				<a href="messages.php" class=" btn btn-default">Retour</a>

				</div>
				<div role="tabpanel" class="tab-pane" id="modifications">
					<form action="" method="post" name="post">
						<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" /> 
						<input name="DATE" type="hidden"  value="<?php echo $donnees['DATE']; ?>" />
						<input name="IP" type="hidden"  value="<?php echo $donnees['IP']; ?>"  />
						
				<div class="form-group">
					
					<p id="clear">&nbsp;</p> 
					
					<div class="col-md-6">
						
						<p><label>Nom</label>
						<input name="NOM" type="text"  value="<?php echo $donnees['NOM']; ?>"/>
						</p>
						
						<p id="clear">&nbsp;</p>
						
						<p><label>Email</label>
						<input name="EMAIL" type="email"  value="<?php echo $donnees['EMAIL']; ?>"/>
						</p>
						
						<p id="clear">&nbsp;</p>
						
						<p><label>Téléphone</label>
						<input name="TELEPHONE" type="text"  value="<?php echo $donnees['TELEPHONE']; ?>"/>
						</p>
						
						<p id="clear">&nbsp;</p>
						
						<p><label>Destinataire du message</label>
							<select name="DESTINATAIRE" required>
								<option value="<?php echo $donnees['DESTINATAIRE']; ?>"><?php echo $donnees['DESTINATAIRE']; ?></option>
								<option value="Service commercial">Service commercial</option>
								<option value="Webmaster">Webmaster</option>
							</select> 
						</p>
						
					</div>
					
					<div class="col-md-5 ">
					
						<p id="clear" class="visible-phone">&nbsp;</p> 
						
						<p><label>Type de contact</label> 
						<select name="TYPE">
							<option value="<?php echo $donnees['TYPE']; ?>"><?php echo $donnees['TYPE']; ?></option>
							<option value="Particulier">Particulier</option>
							<option value="Professionnel">Professionnel</option>
							<option value="Collectivité">Collectivité</option>
							<option value="Autre">Autre</option>
						</select>
						</p>
						
						<p id="clear">&nbsp;</p> 
						
						<p><label>Adresse</label>
						<input name="ADRESSE" type="text"  value="<?php echo $donnees['ADRESSE']; ?>"/>
						</p>
						
						<p id="clear">&nbsp;</p>
						
						<p><label>Code postal</label>
						<input name="CP" type="text"  value="<?php echo $donnees['CP']; ?>"/>
						</p>
						
						<p id="clear">&nbsp;</p>
						
						<p><label>Ville</label>
						<input name="VILLE" type="text"  value="<?php echo $donnees['VILLE']; ?>"/>
						</p>
						
					</div> 
					 
					<div class="col-md-12">
						<p id="clear">&nbsp;</p>
						<p><label>Message</label>
						<textarea name="MESSAGE" ><?php echo $donnees['MESSAGE']; ?></textarea> 
						</p>
					</div>  
				</div>  
				
				<p id="clear">&nbsp;</p>
				 
				<a href="messages.php?action=suppression&ID=<?php echo $donnees['ID']; ?>" class="btn btn-danger">Supprimer</a>
				<input name="update" type="submit" class=" btn btn-large btn-success pull-right" value="Mettre à jour"/>
				
			</form>
		</div> 
	</div> 
	<?php
	}
}		
include'../admin/html/footer.php';
?>