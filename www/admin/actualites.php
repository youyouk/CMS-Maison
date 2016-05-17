<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION ACTU ? 
***************************************************************/
if(isset($_POST['suppression'])){ 
	$ID = $_POST['ID'];
	$query = "DELETE FROM SITE_ACTUS WHERE ID = :ID";
	$stmt = $bdd->prepare($query);
	if($stmt->execute(array(':ID' => $ID))) { 
		header('Location: '.$_SERVER['PHP_SELF'].'?m=9');
	} else {
		header('Location: '.$_SERVER['PHP_SELF'].'?e=9');
	}
} 
/**************************************************************
			CONFIRMATION SUPPRESSION
***************************************************************/ 
$check= !empty($_GET['ID']);
if($check==true){
	$action = $_GET['action'];
	$ID = $_GET['ID'];	
	if($action == "suppression"){
		$query = 'SELECT * FROM SITE_ACTUS WHERE ID = :ID';		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));		
		$donnees = $stmt->fetch();		
		echo '<p>Confirmez-vous la suppression irréversible de l\'article <strong>'.$donnees['TITRE'].'</strong> ?</p>
			   <p><form action="actualites.php" method="post" name="post"><br />
					<input name="ID" type="hidden" value="'.$donnees['ID'].'">
					<a href="actualites.php" class=" btn btn-default">Retour</a>
					<input name="suppression" type="submit" class=" btn btn-danger btn-large pull-right" value="Effacer" />
			   </form></p>';
	}
}
/**************************************************************
			LISTING ACTUS 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) {
/**************************************************************
				AJOUT ACTU ? 
***************************************************************/
	if(isset($_POST['add_post'])) {
		$ID = $_POST['ID'];
		$DATE_CREATION = $_POST['DATE_CREATION'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE'];
		if(empty($TITRE) OR empty($CONTENU) OR empty ($VISIBLE)) {
					echo ('<div class="alert alert-danger"><strong>Merci de remplir tous les champs !</strong></div>');
		} else {						
			$query = 'INSERT INTO SITE_ACTUS ( ID, DATE_CREATION, TITRE, CONTENU, VISIBLE)
					 VALUES ( :ID, :DATE_CREATION, :TITRE, :CONTENU, :VISIBLE)';

			$stmt= $bdd->prepare($query);

			if( $stmt->execute(array(
					':ID' => $ID,
					':DATE_CREATION' => $DATE_CREATION,
					':TITRE' => $TITRE,
					':CONTENU' => $CONTENU,
					':VISIBLE' => $VISIBLE))) {
						header('Location: '.$_SERVER['PHP_SELF'].'?m=7');
					} else {
						header('Location: '.$_SERVER['PHP_SELF'].'?e=7');
					}
				}
		}
	$requete = "SELECT * FROM SITE_PAGES WHERE URL = '/actualites.php' AND VISIBLE > 1";				
	$stmt = $bdd->prepare($requete);
	$stmt->execute(); 
	if ($stmt->rowCount() > 0) {
	?>
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-list-ul fa-1x"></i> Liste</a></li>
	<li role="presentation"><a href="#nouveau" aria-controls="nouveau" role="tab" data-toggle="tab"><i class="fa fa-plus fa-1x"></i> Ajouter une actualité</a></li>
</ul>
 
<div class="tab-content"> 
	<div role="tabpanel" class="tab-pane active" id="modifications">
		<br />
		<p>Les visiteurs du site ne voient que le contenu ayant le statut "<span style="color:#47A447;"><strong>Publié</strong></span>". Le mode "<span style="color:#3498DB;"><strong>Brouillon</strong></span>" vous permet de rédiger vos contenus sans que les internautes ne puissent les voir.</p>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>Titre</th> 
					<th>Statut</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php  
			$reponse = $bdd->query('SELECT * FROM SITE_ACTUS ORDER BY DATE_CREATION DESC');
			while ($donnees = $reponse->fetch()) {
			echo '
			<tr>
				<td><small><em>Le '. date('d/m/Y à H:i', $donnees['DATE_CREATION']).'</em></small><br /><strong>'. $donnees['TITRE'].'</strong></td> 
				<td class="';
					if ($donnees['VISIBLE'] == "2") {
							echo 'info';
						} else if ($donnees['VISIBLE'] == "3") {
							echo 'success';
						}else {
							echo 'danger';
						}
				
				echo '"><span style="';
							if ($donnees['VISIBLE'] == "2") {
									echo 'color:#3498DB;';
								} else if ($donnees['VISIBLE'] == "3") {
									echo 'color:#94D094;';
								}else {
									echo 'color:#C02600;';
								}
						
						echo '">';
							if ($donnees['VISIBLE'] == "2") {
									echo 'Brouillon';
								} else if ($donnees['VISIBLE'] == "3") {
									echo 'Publiée';
								}else {
									echo 'Non publiée';
								}
						
						echo '</span></td>
				<td style="text-align:center;">
				<a href="../actualites.php" target="_blank" class=" btn btn-info " ><i class="fa fa-eye fa-1x"></i></a> 
				<a href="actualites.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
				<a href="actualites.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>
				</td>
			</tr>';
			}
			$reponse->closeCursor();
			?>
		  </tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane " id="nouveau">
		 <form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" />
			<input name="DATE_CREATION" type="hidden" value="<?php echo time();?>"/>
			<div class="form-group">
			
				<p id="clear">&nbsp;</p>
			
				<div class="col-md-6">
					<p><label>Titre</label>
					<input name="TITRE" type="text" value="<?php if(isset($_POST['TITRE'])) echo $TITRE; ?>" required>
					</p>
				</div> 
				
				<p id="clear" class="visible-phone">&nbsp;</p>
			
				<div class="col-md-5 ">  
					<p><label>Visibilité</label>
					<select name="VISIBLE" type="select" required>
						<option value ="1">Ne pas publier</option>
						<option value ="2">Visible uniquement par vous</option>
						<option value ="3">Publier immédiatement</option>
					</select>
					</p> 
				</div>
				
				<p id="clear">&nbsp;</p>
			
				<div class="col-md-12">
					<p><label>Contenu</label>
					<textarea name="CONTENU" ><?php if(isset($_POST['CONTENU'])) { echo $CONTENU; } else { echo 'Votre texte…';} ?></textarea>
					</p>
				</div>
			</div>
	 
			<p id="clear">&nbsp;</p>
			
			<input name="add_post" type="submit"  class=" btn btn-large btn-success pull-right" value="Ajouter"/>
			
		</form>
	</div>
</div>
<?php } else { ?>
<p>Vous devez  <strong>publier la page "Actualités"</strong> pour ajouter du contenu (<a href="pages.php?ID=2&action=edit">modifier</a>).</p>
<?php }
}
$check= !empty($_GET['ID']);
if($check==true) { 
	/**************************************************************
				MODIFICATION ACTUS ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])){
		$DATE_CREATION = $_POST['DATE_CREATION'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE'];
		$ID = $_POST['ID'];

		
		
		$query = 'UPDATE SITE_ACTUS SET
			 DATE_CREATION = :DATE_CREATION, 
			 TITRE = :TITRE, 
			 CONTENU = :CONTENU,
			 VISIBLE = :VISIBLE
			 WHERE ID = :ID';

		$stmt= $bdd->prepare($query);	
			
		if( $stmt->execute(array(
			':DATE_CREATION' => $DATE_CREATION,
			':TITRE' => $TITRE,
			':CONTENU' => $CONTENU,
			':VISIBLE' => $VISIBLE,
			':ID' => $ID))) {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&m=8');
			} else {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&e=8');
			}
	}
	/**************************************************************
				MODE MODIFICATION
	***************************************************************/ 
	if($action == "edit"){
		$query = 'SELECT * FROM SITE_ACTUS
		WHERE ID = :ID';				
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));				
		$donnees = $stmt->fetch(); ?>
		<div>
			<p><strong>État : <span style="<?php 
			if ($donnees['VISIBLE'] == "2") {
					echo 'color:#3498DB;';
				} else if ($donnees['VISIBLE'] == "3") {
					echo 'color:#94D094;';
				}else {
					echo 'color:#C02600;';
				}
				?>"><?php if ($donnees['VISIBLE'] == "2") {
							echo 'Brouillon';
						} else if ($donnees['VISIBLE'] == "3") {
							echo 'Publiée';
						}else {
							echo 'Non publiée';
						}
			?></span></strong></p>
			<br />
			
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation"><a href="/admin/actualites.php"><i class="fa fa-list-ul fa-1x"></i> Retour à la liste</a></li>
				<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-edit fa-1x"></i> Modifications</a></li>
				<li role="presentation"><a href="#apercu" aria-controls="apercu" role="tab" data-toggle="tab"><i class="fa fa-eye fa-1x"></i> Aperçu</a></li>
				<li role="presentation"><a href="../actualites.php" target="_blank">Afficher</a></li>
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane" id="apercu">
					<br />
					<h3><?php echo $donnees['TITRE']; ?></h3>
					<div style="background-color:#f6f6f6;padding-top: 5px;"><?php echo $donnees['CONTENU']; ?><br /></div>
				</div>
				<div role="tabpanel" class="tab-pane active" id="modifications">
					<form action="" method="post" name="post">
						<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" /> 
						<input name="DATE_CREATION" type="hidden" value="<?php echo $donnees['DATE_CREATION']; ?>" />
						
						<div class="form-group">
						
							<p id="clear">&nbsp;</p> 
						
							<div class="col-md-6">
								<p><label>Titre</label>
								<input name="TITRE" type="text" value="<?php echo $donnees['TITRE']; ?>"required/>
								</p>
								
							</div> 
							
							<p id="clear" class="visible-phone">&nbsp;</p>
			
							<div class="col-md-5">  
								<p><label>Visibilité</label>
								<select name="VISIBLE" type="select" required>
									<option value ="<?php echo $donnees['VISIBLE']; ?>">
										<?php if ($donnees['VISIBLE'] == "3") {
											echo 'Publiée';
										} else if ($donnees['VISIBLE'] == "1") {
											echo 'Non publiée';
										} else {
											echo 'Visible uniquement par vous';
										} ?>
									</option>
									<option>******</option>
									<option value ="1">Ne pas publier</option>
									<option value ="2">Visible uniquement par vous</option>
									<option value ="3">Publier immédiatement</option>
								</select>
								</p> 
							</div>
							
						<p id="clear">&nbsp;</p>
			
							<div class="col-md-12">
								<p><label>Contenu</label>
								<textarea name="CONTENU"  ><?php echo $donnees['CONTENU']; ?></textarea>
								</p>
							</div>
						</div>
						
						<p id="clear">&nbsp;</p>
						
						<input name="update" type="submit" class=" btn btn-large btn-success pull-right" value="Mettre à jour"/>
						<a href="actualites.php?action=suppression&ID=<?php echo $donnees['ID']; ?>" class="btn btn-danger">Supprimer</a>
					</form>
				</div>
			<p id="clear">&nbsp;</p>
			</div>
		</div> 
	<?php
	}
}	
include'../admin/html/footer.php';
?>