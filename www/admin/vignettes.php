<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION VIGNETTE ? 
***************************************************************/
if(isset($_POST['suppression'])){ 
	$ID = $_POST['ID'];
	$query = "DELETE FROM SITE_VIGNETTES WHERE ID = :ID";
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
		$query = 'SELECT * FROM SITE_VIGNETTES WHERE ID = :ID';		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));		
		$donnees = $stmt->fetch();		
		echo '<p>Confirmez-vous la suppression irréversible de la vignette <strong>'.$donnees['TITRE'].'</strong> ?</p>
			   <p><form action="vignettes.php" method="post" name="post"><br />
					<input name="ID" type="hidden" value="'.$donnees['ID'].'">
					<a href="vignettes.php" class=" btn btn-default">Retour</a>
					<input name="suppression" type="submit" class=" btn btn-danger btn-large pull-right" value="Effacer" />
			   </form></p>';
	}
}
/**************************************************************
			LISTING VIGNETTES 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) {
	/**************************************************************
				AJOUT VIGNETTE ? 
	***************************************************************/							
	if(isset($_POST['add_post'])){
		$ID = $_POST['ID'];
		$URL = $_POST['URL'];
		$IMG = $_POST['IMG'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE'];
		$ORDRE = $_POST['ORDRE'];
		$CATEGORIE = $_POST['CATEGORIE'];
		if(empty($TITRE) OR empty($CONTENU) OR empty ($VISIBLE) ){
			echo ('<div class="alert alert-danger"><strong>Merci de remplir tous les champs !</strong></div>');
		} else {						
			$query = 'INSERT INTO SITE_VIGNETTES ( ID, URL, IMG, TITRE, CONTENU, VISIBLE, ORDRE, CATEGORIE) VALUES ( :ID, :URL, :IMG, :TITRE, :CONTENU, :VISIBLE, :ORDRE, :CATEGORIE)';
			$stmt= $bdd->prepare($query);
			if( $stmt->execute(array(
					':ID' => $ID,
					':URL' => $URL,
					':IMG' => $IMG,
					':TITRE' => $TITRE,
					':CONTENU' => $CONTENU,
					':VISIBLE' => $VISIBLE,	
					':ORDRE' => $ORDRE,	
					':CATEGORIE' => $CATEGORIE))) { 
					header('Location: '.$_SERVER['PHP_SELF'].'?m=7');
				} else {
					header('Location: '.$_SERVER['PHP_SELF'].'?e=7');
				}
		}
	}
?> 

<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-list-ul fa-1x"></i> Liste</a></li>
	<li role="presentation"><a href="#apercu" aria-controls="apercu" role="tab" data-toggle="tab"><i class="fa fa-eye fa-1x"></i> Aperçu</a></li>
	<li role="presentation"><a href="#nouveau" aria-controls="nouveau" role="tab" data-toggle="tab"><i class="fa fa-plus fa-1x"></i> Ajouter une vignette</a></li>
	<li role="presentation"><a href="#parametres" aria-controls="parametres" role="tab" data-toggle="tab"><i class="fa fa-cog fa-1x"></i> Paramètres</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="modifications">	
		<br />
		<p>L'affichage des vignettes <?php if (parametre(18, $bdd) != 'NON') { echo '"<strong>' . parametre(18, $bdd) .'</strong>"'; } ?> est <strong><?php if (parametre(38, $bdd) != 'NON') { echo 'activé'; } else { echo 'désactivé';} ?></strong><?php if (parametre(38, $bdd) != 'NON') {  if (parametre(38, $bdd) == 'HOME') { echo '. Elles s\'affichent <strong>sur la page d\'accueil</strong>'; } else if (parametre(38, $bdd) == 'HEADER') { echo '. Elles s\'affichent <strong>dans le header</strong> sur toutes les pages autres que la page d\'accueil'; } else if (parametre(38, $bdd) == 'FOOTER') { echo '. Elles s\'affichent <strong>dans le footer</strong> sur toutes les pages autres que la page d\'accueil'; } } ?>.</p> 
		<table class="table table-responsive table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>Ordre</th>
					<th>Titre</th>
					<th style="text-align: center;">Image</th> 
					<th>Lien</th>
					<th>Statut</th>
					<th></th>
					<th style="display:none;">ID</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$reponse = $bdd->query('SELECT * FROM SITE_VIGNETTES WHERE VISIBLE < 4 ORDER BY ORDRE ASC');
				while ($donnees = $reponse->fetch()) {
					echo '
					<tr>
						<td>'. $donnees['ORDRE'].'</td>
						<td><small>Catégorie : '. $donnees['CATEGORIE'].'</small><br /><strong>'. $donnees['TITRE'].'</strong></td>
						<td style="text-align: center;"><img src="'. $donnees['IMG'].'"style="height:40px;border: none;"></td> 
						<td>';
							if ($donnees['URL'] != "") {
									echo '<a href="..'. $donnees['URL'].'" target="_blank" class=" btn btn-info" ><i class="fa fa-eye fa-1x"></i></a>';
								} else {
									echo '<a href="#" target="_blank" class=" btn btn-info disabled"><i class="fa fa-eye-slash fa-1x" title="Aucun lien"></i></a>';
								}
						
						echo '</td>
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
						<a href="vignettes.php?ID='.$donnees['ID'].'&action=edit" class=" btn btn-success" ><i class="fa fa-edit fa-1x"></i></a>
						<a href="vignettes.php?action=suppression&ID='.$donnees['ID'].'" class=" btn btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>
						</td>
						<td style="display:none;">'. $donnees['ID'].'</td>
					</tr>';
				}
				$reponse->closeCursor();
				?>
			</tbody>
		</table> 
	</div>
	<div role="tabpanel" class="tab-pane" id="apercu"> 
		<?php
		// VIGNETTES ?
		if (parametre(14, $bdd) != 'NON') {
			if (parametre(18, $bdd) != 'NON') {
				echo '<br /><h2>' . parametre(18, $bdd) . '</h2>';
			} else {
				echo "<br />";
			} 
			include_once "../html/vignettes.php";
		}
		?>
	</div>
	<div role="tabpanel" class="tab-pane" id="nouveau">
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value=""/>
			
			<div class="form-group">
			
				<p id="clear">&nbsp;</p>
			
				<div class="col-md-6">
					<p><label>Titre</label>
					<input name="TITRE" type="text" value="<?php if(isset($_POST['TITRE'])) echo $TITRE; ?>" required>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Catégorie</label>
					<input name="CATEGORIE" type="text" value="<?php if(isset($_POST['CATEGORIE'])) echo $CATEGORIE; ?>"/>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Contenu</label>
					<input name="CONTENU" type="text" value="<?php if(isset($_POST['CONTENU'])) echo $CONTENU; ?>"/>
					</p>
					
					<p id="clear">&nbsp;</p>
				</div>
				
				<div class="col-md-5">
					<p><label>Image</label>
					<input type="text" id="IMG" name="IMG" value="<?php if(isset($_POST['IMG'])) echo $IMG; ?>" readonly="readonly">
					<a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/admin/tinymce/plugins/filemanager/dialog.php?type=1&field_id=IMG&lang=fr_FR&relative_url=1" class="btn iframe-btn btn-info" type="button">Choisir</a>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>Lien au clic</label>
					<select name="URL" >  
						<option value ="">Aucun</option>
						<option value ="">-----------</option>
						<?php 
						$requete = $bdd->query("SELECT * FROM SITE_PAGES WHERE VISIBLE < 4 ORDER BY TITRE ASC");
						while ($listevignettes = $requete->fetch()) {
							echo '<option value ="'.$listevignettes['URL'].'"'; 
								if ($donnees['URL'] == $listevignettes['URL']) {
									echo ' selected';
								}
							echo '>'.$listevignettes['TITRE'].'</option>';
						}
						?>
					</select> 
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
			</div>
			
			<p id="clear">&nbsp;</p>
			
			<input name="add_post" type="submit" class="btn btn-large btn-success pull-right" value="Ajouter"/>
			
		</form>
	</div>
	<div role="tabpanel" class="tab-pane" id="parametres"> 
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 6 ORDER BY POSITION ASC"); 
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
<?php }
$check= !empty($_GET['ID']);
if($check==true) { 
	/**************************************************************
				MODIFICATION VIGNETTE ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])){
		$URL = $_POST['URL'];
		$IMG = $_POST['IMG'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE'];
		$CATEGORIE = $_POST['CATEGORIE'];
		$ORDRE = $_POST['ORDRE'];
		$ID = $_POST['ID'];

		
		
		$query = 'UPDATE SITE_VIGNETTES SET
			 URL = :URL, 
			 IMG = :IMG, 
			 TITRE = :TITRE, 
			 CONTENU = :CONTENU,
			 VISIBLE = :VISIBLE,
			 CATEGORIE = :CATEGORIE,
			 ORDRE = :ORDRE
			 WHERE ID = :ID';

		$stmt= $bdd->prepare($query);	
			
		if( $stmt->execute(array(
			':URL' => $URL,
			':IMG' => $IMG,
			':TITRE' => $TITRE,
			':CONTENU' => $CONTENU,
			':VISIBLE' => $VISIBLE,
			':CATEGORIE' => $CATEGORIE,
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
		$query = 'SELECT * FROM SITE_VIGNETTES
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
				<li role="presentation"><a href="/admin/vignettes.php"><i class="fa fa-list-ul fa-1x"></i> Retour à la liste</a></li>
				<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-edit fa-1x"></i> Modifications</a></li>
				<li role="presentation"><a href="#apercu" aria-controls="apercu" role="tab" data-toggle="tab"><i class="fa fa-eye fa-1x"></i> Aperçu</a></li> 
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane" id="apercu">
					<p id="clear">&nbsp;</p>
					<ul class="produits">
						<?php 
						$reponse = $bdd->query('SELECT * FROM SITE_VIGNETTES WHERE ID = '.$donnees['ID'] );
						if ($donnees = $reponse->fetch()) {
							echo '<li><a href="#lien'. $donnees['ID'].'" class="thumbnail" style="background-image: url(\''. $donnees['IMG'].'\')"><h4>'. $donnees['CATEGORIE'].'</h4><span class="description">'. $donnees['TITRE'].'</span></a></li>';
						}
							$reponse->closeCursor();
						?>
					</ul>
					<div class="portfolio-content">
						<?php 
						$reponse = $bdd->query('SELECT * FROM SITE_VIGNETTES WHERE ID = '.$donnees['ID'] );
						if ($donnees = $reponse->fetch()) {
							echo '
								<div id="lien'. $donnees['ID'].'"> ';
								if ($donnees['URL'] != "") { echo '<div class="link"><a href="'. $donnees['URL'].'" class="btn btn-info btn-large" style="color:white;">EN SAVOIR +</a></div>'; }
							echo   '<h2>'. $donnees['TITRE'].'</h2>
									<p>'. $donnees['CONTENU'].'</p>
								</div>';
						}
						$reponse->closeCursor();
						?>
					</div> 
					<br />
				</div>
				<div role="tabpanel" class="tab-pane active" id="modifications">
					<form action="" method="post" name="post">
						<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" />

						<div class="form-group">
							
							<p id="clear">&nbsp;</p>
								
							<div class="col-md-6">
								<p><label>Titre</label>
								<input name="TITRE" type="text" value="<?php echo $donnees['TITRE']; ?>"required/>
								</p>
								
								<p id="clear">&nbsp;</p>
								
								<p><label>Catégorie</label>
								<input name="CATEGORIE" type="text" value="<?php echo $donnees['CATEGORIE']; ?>"required/>
								</p>
								
								<p id="clear">&nbsp;</p>
								
								<p><label>Contenu</label>
								<input name="CONTENU" type="text" value="<?php echo $donnees['CONTENU']; ?>"/>
								</p>
								
								<p id="clear">&nbsp;</p>
							</div>
							
							<div class="col-md-5">							
								<p><label>Image</label>
								<input type="text" id="IMG" name="IMG" value="<?php echo $donnees['IMG']; ?>" readonly="readonly">
								<a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/admin/tinymce/plugins/filemanager/dialog.php?type=1&field_id=IMG&lang=fr_FR&relative_url=1" class="btn iframe-btn btn-info" type="button">Choisir</a>
								</p>
								
								<p id="clear">&nbsp;</p>
								
								<p><label>Lien au clic</label>
								<select name="URL" >
									<option value ="">Aucun</option> 
									<option value ="">-------</option>   
									<?php 
									$requete = $bdd->query("SELECT * FROM SITE_PAGES WHERE VISIBLE < 4 ORDER BY TITRE ASC");
									while ($listevignettes = $requete->fetch()) {
										echo '<option value ="'.$listevignettes['URL'].'"'; 
											if ($donnees['URL'] == $listevignettes['URL']) {
												echo ' selected';
											}
										echo '>'.$listevignettes['TITRE'].'</option>';
									}
									?>
								</select> 
								</p>
										
								<p id="clear">&nbsp;</p>
								
								<div class="form-group">
									<div class="col-md-4"> 
										<p><label>Ordre</label>
										<select name="ORDRE" > 
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
										<select name="VISIBLE" required>
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
						</div>
			  
						<p id="clear">&nbsp;</p>
						
						<input name="update" type="submit" class=" btn btn-large btn-success pull-right" value="Mettre à jour"/>
						<?php if ($donnees['URL'] != "/index.php") { ?>
						<a href="vignettes.php?action=suppression&ID=<?php echo $donnees['ID']; ?>" class="btn btn-danger">Supprimer</a>
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