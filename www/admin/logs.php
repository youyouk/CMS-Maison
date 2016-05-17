<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION LOG ? 
***************************************************************/
if(isset($_POST['suppression'])) { 
	$ID = $_POST['ID']; 

	$query = 'DELETE FROM ADMIN_LOGS 
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
if(isset($_POST['vidertableOK'])) { 

	$query = 'TRUNCATE TABLE ADMIN_LOGS';
	
	$stmt = $bdd->prepare($query);
	$stmt->execute();

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
		$query = 'SELECT * FROM ADMIN_LOGS
		WHERE ID = :ID';
		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		
		$donnees = $stmt->fetch();
		echo ('<p>Confirmez-vous la suppression irréversible du log en date du <strong>'.date('d/m/Y à H:i', $donnees['DATE']).'</strong> ?</p>
			<p><form action="logs.php" method="post" name="post"><br />
				<input name="ID" type="hidden" value="'.$donnees['ID'].'"> 
				<a href="logs.php" class=" btn btn-default">Retour</a>
				<input name="suppression" type="submit" class="btn btn-large btn-danger pull-right" value="Effacer" />
			</form></p>');
	}
} 
if (isset($_GET['action']) && ($_GET['action'] == "vidertable")){ 
	echo ('<p>Confirmez-vous la suppression irréversible <strong>de tous les logs de connexion</strong> ?</p>
		<p><form action="logs.php" method="post" name="post"><br /> 
			<a href="logs.php" class=" btn btn-default">Retour</a>
			<input name="vidertableOK" type="submit" class="btn btn-large btn-danger pull-right" value="Effacer" />
		</form></p>'); 
}  
/**************************************************************
			LISTING LOGS 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) { ?>
<ul class="nav nav-tabs" role="tablist"> 
	<li role="presentation" class="active"><a href="#apercu" aria-controls="apercu" role="tab" data-toggle="tab"><i class="fa fa-list-ul fa-1x"></i> Liste</a></li> 
	<li role="presentation"><a href="#parametres" aria-controls="parametres" role="tab" data-toggle="tab"><i class="fa fa-cog fa-1x"></i> Paramètres</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="apercu"> 
		<br />
		<p>Après <strong><?php echo parametre(3, $bdd); ?></strong> tentatives incorrectes au cours des <strong><?php echo parametre(32, $bdd); ?></strong> dernières minutes,  les connexions sont bloquées durant <strong><?php echo parametre(2, $bdd); ?></strong> minutes.</p>
		
		<table class="table table-responsive table-striped table-condensed table-hover">
			<thead>
				<tr> 
					<th>Date</th> 
					<th>Identifiant</th> 
					<th style="text-align:center;">Statut</th>
					<th>IP</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody style="max-height:400px !important;overflow:none;"> 
				<?php  
				$query = 'SELECT * FROM ADMIN_LOGS ORDER BY DATE DESC';
				$reponse = $bdd->prepare($query);
				$reponse->execute();
				while ($donnees = $reponse->fetch()) {
					echo '
					<tr> 
						<td>Le '. date('d/m/Y à H:i', $donnees['DATE']).'</td>
						<td>'. $donnees['EMAIL'].'</td>
						<td style="text-align:center !important;" class="';
						if (($donnees['OK'] == "5") || ($donnees['OK'] == "6")) {
							echo 'info';
						} else if (($donnees['OK'] == "9")) {
							echo 'success';
						} else {
							echo 'danger';
						}
						echo '"><span style="';
							if (($donnees['OK'] == "5") || ($donnees['OK'] == "6")) {
									echo 'color:#3498DB;';
								} else if (($donnees['OK'] == "9")) {
									echo 'color:#94D094;';
								}else {
									echo 'color:#C02600;';
								}
						
						echo '">';
							if ($donnees['OK'] == "1") {
								echo 'Mauvais Email';
							} else if ($donnees['OK'] == "2") {
								echo 'Mauvais Email (renvoi)';
							}  else if ($donnees['OK'] == "3") {
								echo 'Mauvais MDP';
							}  else if ($donnees['OK'] == "4") {
								echo 'Echec réinit. MDP';
							}  else if ($donnees['OK'] == "5") {
								echo 'Renvoi MDP';
							}  else if ($donnees['OK'] == "6") {
								echo 'Nouveau MDP';
							}  else if ($donnees['OK'] == "7") {
								echo 'Blocage';
							}  else if ($donnees['OK'] == "9") {
								echo 'Connexion';
							} else {
								echo 'Echec';
							}
						
						echo '</span></td> 
						<td>'. $donnees['IP'].'</td>
						<td style="text-align:center;">
							<a href="logs.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>
						</td>
					</tr>';
				}
				?> 
			</tbody>
		</table>
		<?php 
			if ($reponse->rowCount() < 1 ) {
				echo '<p>Rien à afficher</p>';
			} 
			if ($reponse->rowCount() > 1) {
				echo '<p id="clear">&nbsp;</p><a href="logs.php?action=vidertable" class="btn btn-danger btn-large pull-right"><i class="fa fa-trash-o fa-1x"></i> TOUT EFFACER</a>';
			}
			$reponse->closeCursor();
		?>
	</div>
	<div role="tabpanel" class="tab-pane" id="parametres">
		
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php 
				$reponse->closeCursor(); 
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 5 ORDER BY POSITION ASC"); 
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
				echo'<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				$reponse->closeCursor();
				?>
			</tbody>
		</table>
	</div>
</div>	
<?php 
}
include'../admin/html/footer.php'; ?>