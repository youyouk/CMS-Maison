<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION PAGE ? 
***************************************************************/
if(isset($_POST['suppression'])){ 
	$URL = '/'.$_POST['URL'].'.php'; 

	$query = "DELETE FROM SITE_PAGES 
		WHERE URL = :URL";
	
	$stmt = $bdd->prepare($query);
	$stmt->execute(array(
		':URL' => $URL));

	if($stmt) {
		unlink('..'.$URL);
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
		$query = 'SELECT * FROM SITE_PAGES
		WHERE ID = :ID';
		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		
		$donnees = $stmt->fetch();
		
		$clean = array("/", ".php");
		$CLEANURL = str_replace($clean, "", $donnees['URL']);
		
		echo ('<p>Confirmez-vous la suppression irréversible de la page <strong>'.$donnees['TITRE'].'</strong> ?</p>
			   <p><form action="pages.php" method="post" name="post"><br />
					<input name="URL" type="hidden" value="'.$CLEANURL.'">
					<a href="pages.php" class=" btn btn-default">Retour</a>
					<input name="suppression" type="submit" class=" btn btn-danger btn-large pull-right" value="Effacer" />
			   </form></p>');
	}
}
/**************************************************************
			LISTING PAGES 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) {
/**************************************************************
				AJOUT PAGE ? 
***************************************************************/	 						
	if(isset($_POST['add_post'])){ 
		$URL = $_POST['URL'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE'];
		$ORDRE = $_POST['ORDRE'];
		$MENU = $_POST['MENU'];
		if(empty($TITRE) OR empty($CONTENU) OR empty ($VISIBLE) ){
			echo ('<div class="alert alert-danger"><strong>Merci de remplir tous les champs !</strong></div>');
		} else {
			$requete = "SELECT * FROM SITE_PAGES WHERE URL = :URL";
			$stmtcheck = $bdd->prepare($requete);
			$stmtcheck->execute(array(':URL' => $URL));
			if($stmtcheck->rowCount() > "0" ) {
				header('Location: '.$_SERVER['PHP_SELF'].'?&action=nouveau&e=10');
			} else {
				$query = 'INSERT INTO SITE_PAGES ( URL, TITRE, CONTENU, VISIBLE, ORDRE, MENU) VALUES ( :URL, :TITRE, :CONTENU, :VISIBLE, :ORDRE, :MENU)';
				$stmt= $bdd->prepare($query);
				if($stmt->execute(array( 
						':URL' => $URL,
						':TITRE' => $TITRE,
						':CONTENU' => $CONTENU,
						':VISIBLE' => $VISIBLE,	
						':ORDRE' => $ORDRE,	
						':MENU' => $MENU))) {	
$content = '<?php
include "./html/header.php";
require "./html/content.php"; 
include "./html/footer.php";
?>'; 
					$file = ($_SERVER['DOCUMENT_ROOT'] . "" . $URL);
					$fp = fopen($file, "wb");
					$file = "\xEF\xBB\xBF".$file; // UTF-8 :)
					fputs($fp, $content);
					fclose($fp);
					header('Location: '.$_SERVER['PHP_SELF'].'?m=7');
				} else {
					header('Location: '.$_SERVER['PHP_SELF'].'?&action=nouveau&e=7');
				}
			}
		}
	}	
?>

<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-list-ul fa-1x"></i> Liste</a></li>
	<li role="presentation"><a href="#nouveau" aria-controls="nouveau" role="tab" data-toggle="tab"><i class="fa fa-plus fa-1x"></i> Ajouter une page</a></li>
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
				$reponse = $bdd->query('SELECT * FROM SITE_PAGES WHERE VISIBLE < 4 ORDER BY TITRE ASC');
				while ($donnees = $reponse->fetch()) {
					echo '
					<tr>
						<td><strong>'. $donnees['TITRE'].'</strong><br /><em><small>'. $donnees['URL'].'</small></em></td>
						<td class="';
							if ($donnees['VISIBLE'] == "2") {
									echo 'info';
								} else if ($donnees['VISIBLE'] == "3") {
									echo 'success';
								}else {
									echo 'danger';
								}
						
						echo '" style="padding: 10px 5px;" ><span style="';
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
						<td style="text-align:left;">
						<a href="..'. $donnees['URL'].'" target="_blank" class=" btn btn-info" ><i class="fa fa-eye fa-1x"></i></a>
						<a href="pages.php?ID='.$donnees['ID'].'&action=edit" class=" btn btn-success" ><i class="fa fa-edit fa-1x"></i></a>';
						if (($donnees['URL'] != '/actualites.php') && ($donnees['URL'] != '/extranet.php') && ($donnees['URL'] != '/erreur-404.php') && ($donnees['URL'] != '/recherche.php') && ($donnees['URL'] != '/contact.php') && ($donnees['URL'] != '/mentions-legales.php') && ($donnees['URL'] != '/index.php') && ($donnees['URL'] != '/qui-sommes-nous.php')) {
							echo ' <a href="pages.php?action=suppression&ID='.$donnees['ID'].'" class=" btn btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
						}
						echo '</td> 
					</tr>';
				}
				$reponse->closeCursor();
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane " id="nouveau">
		<br />
		<p>Renseignez le titre pour déterminer l'URL de la page (se remplira automatiquement). Attention, cette URL ne sera pas modifiable par la suite, contrairement au titre. <strong>L'URL est un élément important pour le référencement</strong>, veillez donc bien à garder une cohérence entre celle-ci et le contenu de la page.</p>
		<br />
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value=""/> 
			<div class="form-group">
				<div class="col-md-6">
					<p><label>Titre</label>
					<input id="TITRE" name="TITRE" type="text" value="<?php if(isset($_POST['TITRE'])) echo $TITRE; ?>" required>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Menu</label>
					<select name="MENU" > 
						<option value="0">Ne pas afficher dans le menu</option>
						<option value="1">Dans le MENU PRINCIPAL</option> 
						<?php 
						$requete = $bdd->query("SELECT * FROM SITE_PAGES WHERE VISIBLE = 4 ORDER BY TITRE ASC");
						while ($listepages = $requete->fetch()) {
							echo '<option value ="'.$listepages['ID'].'"'; 
								if ($donnees['MENU'] == $listepages['ID']) {
									echo ' selected';
								} 
							echo'>Dans le SOUS MENU '.$listepages['TITRE'].'</option>';
						} ?>
					</select> 
					</p> 
					 
				</div> 
				
				<p id="clear" class="visible-phone">&nbsp;</p>
			
				<div class="col-md-5 ">
					<p><label>URL <small><em>(Automatique)</em></small></label>
					<input id="URL" name="URL" type="hidden" value="<?php if(isset($_POST['URL'])) echo $URL; ?>" />
					<p id="URLtexte" class="label label-primary"></p>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<div class="form-group">
						<div class="col-md-4"> 
							<p><label>Ordre</label>
							<select name="ORDRE"> 
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
							</select> 
							</p>
						</div>
						<div class="col-md-8"> 
							<p id="clear" class="visible-phone">&nbsp;</p>
							<p><label>Visibilité</label>
							<select name="VISIBLE" type="select" required>
								<option value ="1">Ne pas publier</option>
								<option value ="2">Visible uniquement par vous</option>
								<option value ="3">Publier immédiatement</option>
							</select>
							</p>
						</div>
					</div>
				</div>
				
				<p id="clear">&nbsp;</p>
					
				<div class="col-md-12">
					<p><label>Contenu</label>
					<textarea name="CONTENU" ><?php if(isset($_POST['CONTENU'])) { echo $CONTENU; } else { echo 'Votre texte…';} ?></textarea>
					</p>
				</div>
			</div>
			
			<p id="clear">&nbsp;</p>
			
			<input name="add_post" type="submit" class="btn btn-large btn-success pull-right" value="Ajouter"/>
			
		</form> 
	</div>
</div>
<?php }
$check= !empty($_GET['ID']);
if($check==true) { 
	/**************************************************************
				MODIFICATION PAGE ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])){
		$URL = $_POST['URL'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE'];
		$MENU = $_POST['MENU'];
		$ORDRE = $_POST['ORDRE'];
		$ID = $_POST['ID'];

		
		
		$query = 'UPDATE SITE_PAGES SET
			 URL = :URL, 
			 TITRE = :TITRE, 
			 CONTENU = :CONTENU,
			 VISIBLE = :VISIBLE,
			 MENU = :MENU,
			 ORDRE = :ORDRE
			 WHERE ID = :ID';

		$stmt= $bdd->prepare($query);	
			
		if( $stmt->execute(array(
			':URL' => $URL,
			':TITRE' => $TITRE,
			':CONTENU' => $CONTENU,
			':VISIBLE' => $VISIBLE,
			':MENU' => $MENU,
			':ORDRE' => $ORDRE,
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
		$query = 'SELECT * FROM SITE_PAGES
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
				<li role="presentation"><a href="/admin/pages.php"><i class="fa fa-list-ul fa-1x"></i> Retour à la liste</a></li>
				<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-edit fa-1x"></i> Modifications</a></li>
				<li role="presentation"><a href="#apercu" aria-controls="apercu" role="tab" data-toggle="tab"><i class="fa fa-eye fa-1x"></i> Aperçu</a></li> 
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane" id="apercu">
					<br />
					<div id="entete">	
						<div id="logo"><img src="<?php echo parametre(8, $bdd); ?>" alt="<?php echo parametre(4, $bdd); ?> - <?php echo parametre(7, $bdd); ?>" style="box-shadow:none;cursor:default;border:none;" /></div>
						<div id="banniere">
							<h1><span><?php echo $donnees['TITRE']; ?></span></h1>
						</div>
					</div>
					<div id="colonne">
						<?php echo $donnees['CONTENU']; ?><br />
					</div>
				</div>
				<div role="tabpanel" class="tab-pane active" id="modifications">
					<form action="" method="post" name="post">
						<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" /> 
						
						<div class="form-group">
						
							<p id="clear">&nbsp;</p>
						
							<div class="col-md-6">
								<p><label>Titre</label> 
								<input name="TITRE" type="text" value="<?php echo $donnees['TITRE']; ?>" required/>
								</p>
								
								<p id="clear">&nbsp;</p>
								
								<p><label>Menu</label>
								<?php if ($donnees['ID'] != "1") { ?>
								<select name="MENU" > 
									<option value="0" <?php if ($donnees['MENU'] == "0") { echo 'selected'; } ?>>Ne pas afficher dans le menu</option>
									<option value="1" <?php if ($donnees['MENU'] == "1") { echo 'selected'; } ?>>Dans le MENU PRINCIPAL</option> 
									<?php 
									$requete = $bdd->query("SELECT * FROM SITE_PAGES WHERE VISIBLE = 4 AND ID NOT LIKE ".$donnees['ID']." ORDER BY TITRE ASC");
									while ($listepages = $requete->fetch()) {
										echo '<option value ="'.$listepages['ID'].'"'; 
											if ($donnees['MENU'] == $listepages['ID']) {
												echo ' selected';
											} 
										echo'>Dans le SOUS MENU '.$listepages['TITRE'].'</option>';
									}
								echo '</select>';
								} else { ?>
									<p><strong><?php if (parametre(34, $bdd) != 'NON') { echo 'Activé'; } else { echo 'Désactivé'; } ?></strong> (<a href="parametres.php">modifier</a>)</p>
									<?php } ?>	 
								</p> 
								 
							</div> 
							
							<p id="clear" class="visible-phone">&nbsp;</p>
			
							<div class="col-md-5  "> 
								<p><label>URL <small><em>Ne peut pas être modifiée</em></small></label>
								<input name="URL" type="hidden" size="120" value="<?php echo $donnees['URL']; ?>"/>
								<p class="mute"><?php echo $donnees['URL']; ?> (<a href="<?php echo $donnees['URL']; ?>">Afficher</a>)</p> 
								</p>
								
								<p id="clear">&nbsp;</p>
								
								<div class="form-group">
									<div class="col-md-4"> 
										<p><label>Ordre</label>
										<select name="ORDRE">  
											<option value="<?php echo $donnees['ORDRE']; ?>"><?php echo $donnees['ORDRE']; ?></option>
											<option value="<?php echo $donnees['ORDRE']; ?>">*****</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
										</select> 
										</p>
									</div>
									<div class="col-md-8"> 
										<p id="clear" class="visible-phone">&nbsp;</p>
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
								</div>
							</div>
							
							<p id="clear">&nbsp;</p>
								
							<div class="col-md-12">
								<p><label>Contenu</label>
								<textarea name="CONTENU" ><?php echo $donnees['CONTENU']; ?></textarea>
								</p>
							</div>
						</div>
						
						<p id="clear">&nbsp;</p>
						
						<input name="update" type="submit" class=" btn btn-large btn-success pull-right" value="Mettre à jour"/>
						<?php if (($donnees['URL'] != '/actualites.php') && ($donnees['URL'] != '/extranet.php') && ($donnees['URL'] != '/erreur-404.php') && ($donnees['URL'] != '/recherche.php') && ($donnees['URL'] != '/contact.php') && ($donnees['URL'] != '/index.php') && ($donnees['URL'] != '/index.php')) { ?>
						<a href="pages.php?action=suppression&ID=<?php echo $donnees['ID']; ?>" class="btn btn-danger">Supprimer</a>
						<?php } ?>
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