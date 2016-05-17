<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION BANNIÈRE ? 
***************************************************************/
if(isset($_POST['suppression'])){ 
	$ID = $_POST['ID'];
	$query = "DELETE FROM SITE_CAROUSEL WHERE ID = :ID";
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
		$query = 'SELECT * FROM SITE_CAROUSEL WHERE ID = :ID';		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));		
		$donnees = $stmt->fetch();		
		echo '<p>Confirmez-vous la suppression irréversible de la bannière <strong>'.$donnees['TITRE'].'</strong> ?</p>
			   <p><form action="carousel.php" method="post" name="post"><br />
					<input name="ID" type="hidden" value="'.$donnees['ID'].'">
					<a href="carousel.php" class=" btn btn-default">Retour</a>
					<input name="suppression" type="submit" class=" btn btn-danger btn-large pull-right" value="Effacer" />
			   </form></p>';
	}
}
/**************************************************************
			LISTING BANNIÈRES 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) {
	/**************************************************************
				AJOUT BANNIÈRE ? 
	***************************************************************/					
	if(isset($_POST['add_post'])){ 
		$URL = $_POST['URL'];
		$IMG = $_POST['IMG'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE'];
		$ORDRE = $_POST['ORDRE']; 
		if(empty($TITRE) OR empty ($VISIBLE) ){
			echo ('<div class="alert alert-danger"><strong>Merci de remplir tous les champs !</strong></div>');
		} else {						
			$query = 'INSERT INTO SITE_CAROUSEL ( URL, IMG, TITRE, CONTENU, VISIBLE, ORDRE ) VALUES ( :URL, :IMG, :TITRE, :CONTENU, :VISIBLE, :ORDRE )';
			$stmt= $bdd->prepare($query);
			if( $stmt->execute(array( 
					':URL' => $URL,
					':IMG' => $IMG,
					':TITRE' => $TITRE,
					':CONTENU' => $CONTENU,
					':VISIBLE' => $VISIBLE,	
					':ORDRE' => $ORDRE ))) { 
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
	<li role="presentation"><a href="#nouveau" aria-controls="nouveau" role="tab" data-toggle="tab"><i class="fa fa-plus fa-1x"></i> Ajouter une bannière</a></li>
	<li role="presentation"><a href="#parametres" aria-controls="parametres" role="tab" data-toggle="tab"><i class="fa fa-cog fa-1x"></i> Paramètres</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="modifications">	
		<br />
		<p>L'affichage du carousel<?php if (parametre(30, $bdd) != 'NON') { echo ' "<strong>' . parametre(30, $bdd) .'</strong>"'; } ?> <strong><?php if (parametre(29, $bdd) != 'NON') { echo 'est activé'; } else { echo 'est désactivé';} ?></strong>. <?php if (parametre(29, $bdd) != 'NON') {  if (parametre(29, $bdd) == 'HOME') { echo 'Il s\'affiche <strong>en haut de la page d\'accueil</strong>'; } elseif (parametre(29, $bdd) == 'HEADER') { echo 'Il s\'affiche <strong>dans le header</strong> sur toutes les pages autres que la page d\'accueil'; } elseif (parametre(29, $bdd) == 'FOOTER') { echo 'Il s\'affiche <strong>dans le footer</strong> sur toutes les pages autres que la page d\'accueil'; } echo " et la durée de transition des bannières est réglée sur <strong>". parametre(31, $bdd) . "ms</strong>"; } ?>.</p> 
		<table class="table table-responsive table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>Ordre</th>
					<th>Titre</th>
					<th style="text-align: center;"></th> 
					<th>Lien ?</th>
					<th>Statut</th>
					<th></th>
					<th style="display:none;">ID</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$reponse = $bdd->query('SELECT * FROM SITE_CAROUSEL WHERE VISIBLE < 4 ORDER BY ORDRE ASC');
				while ($donnees = $reponse->fetch()) {
					echo '
					<tr>
						<td>'. $donnees['ORDRE'].'</td>
						<td><strong>'. $donnees['TITRE'].'</strong></td>
						<td style="text-align: center;"><img src="'. $donnees['IMG'].'"style="height:40px;border: none;"></td>  
						<td>';
							if ($donnees['URL'] != "") {
									echo '<a href="..'. $donnees['URL'].'" target="_blank" class=" btn btn-info" ><i class="fa fa-eye fa-1x"></i></a>';
								} else {
									//echo '<a href="#" target="_blank" class=" btn btn-info disabled"><i class="fa fa-eye-slash fa-1x" title="Aucun lien"></i></a>';
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
						<a href="carousel.php?ID='.$donnees['ID'].'&action=edit" class=" btn btn-success" ><i class="fa fa-edit fa-1x"></i></a>
						<a href="carousel.php?action=suppression&ID='.$donnees['ID'].'" class=" btn btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>
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
		// CAROUSEL ? 
			if (parametre(30, $bdd) != 'NON') {
				echo '<br /><h2>' . parametre(30, $bdd) . '</h2>';
			} else {
				echo "<br />";
			} 
			include_once "../html/carousel.php"; 
		?>
	</div>
	<div role="tabpanel" class="tab-pane" id="nouveau">
		<form action="" method="post" name="post"> 
			
			<div class="form-group">
			
				<p id="clear">&nbsp;</p>
					
				<div class="col-md-6">
					<p><label>Titre</label>
					<input name="TITRE" type="text" value="<?php if(isset($_POST['TITRE'])) echo $TITRE; ?>" required>
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
						while ($listebannieres = $requete->fetch()) {
							echo '<option value ="'.$listebannieres['URL'].'"'; 
								if ($donnees['URL'] == $listebannieres['URL']) {
									echo ' selected';
								}
							echo '>'.$listebannieres['TITRE'].'</option>';
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
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 7 ORDER BY POSITION ASC"); 
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
				MODIFICATION BANNIÈRE ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])){
		$URL = $_POST['URL'];
		$IMG = $_POST['IMG'];
		$TITRE = $_POST['TITRE'];
		$CONTENU = $_POST['CONTENU'];
		$VISIBLE = $_POST['VISIBLE']; 
		$ORDRE = $_POST['ORDRE'];
		$ID = $_POST['ID'];

		
		
		$query = 'UPDATE SITE_CAROUSEL SET
			 URL = :URL, 
			 IMG = :IMG, 
			 TITRE = :TITRE, 
			 CONTENU = :CONTENU,
			 VISIBLE = :VISIBLE, 
			 ORDRE = :ORDRE
			 WHERE ID = :ID';

		$stmt= $bdd->prepare($query);	
			
		if( $stmt->execute(array(
			':URL' => $URL,
			':IMG' => $IMG,
			':TITRE' => $TITRE,
			':CONTENU' => $CONTENU,
			':VISIBLE' => $VISIBLE, 
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
		$query = 'SELECT * FROM SITE_CAROUSEL
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
				<li role="presentation"><a href="/admin/carousel.php"><i class="fa fa-list-ul fa-1x"></i> Retour à la liste</a></li>
				<li role="presentation" class="active"><a href="#modifications" aria-controls="modifications" role="tab" data-toggle="tab"><i class="fa fa-edit fa-1x"></i> Modifications</a></li>
				<li role="presentation"><a href="#apercu" aria-controls="apercu" role="tab" data-toggle="tab"><i class="fa fa-eye fa-1x"></i> Aperçu</a></li>
			</ul>
			
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane" id="apercu">
				<br />
					<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="2000" id="bs-carousel"> 
					<div class="overlay"></div> 
						<ol class="carousel-indicators" > 
							<?php 
							$requete = 'SELECT * FROM SITE_CAROUSEL WHERE ID = '.$donnees['ID'] ;
							$reponse = $bdd->prepare($requete);
							$reponse->execute(); 
							$i=0;
							if ($donnees = $reponse->fetch()) {
								echo '<li data-target="#bs-carousel" data-slide-to="'. $i.'"';
								if ($i == 0) {
									echo ' class="active"'; };
								echo '"></li>';
								$i++;
							}
								$reponse->closeCursor();
							?>
						</ol>
						<div class="carousel-inner">
							<?php 
							$requete = 'SELECT * FROM SITE_CAROUSEL WHERE ID = '.$donnees['ID'] ;
							$reponse = $bdd->prepare($requete);
							$reponse->execute(); 
							
							$i=0;
							if ($donnees = $reponse->fetch()) {
								echo '
								<div class="item slides ';
								if ($i == 0) {
									echo 'active'; };
								echo '">
									<div class="slide-'. $donnees['ID'].'"></div>
										<div class="carousel-legende">
											<h4>'. $donnees['TITRE'].'</h4>
											<p class="description">'. $donnees['CONTENU'].'</p>
										</div>';
										if ($donnees['URL'] != "") {
										echo'
											<a href="'. $donnees['URL'] .'" style="cursor:pointer;">';
										}
										echo '
											<img id="banniere" src="'. $donnees['IMG'].'" alt="'. $donnees['TITRE'].'" title="'. $donnees['TITRE'].'" />';
										if ($donnees['URL'] != "") {
											echo '</a>';
										}
									echo '</div>';
									$i++;
							}
							$reponse->closeCursor();
							?> 
						</div> 
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
									while ($listebannieres = $requete->fetch()) {
										echo '<option value ="'.$listebannieres['URL'].'"'; 
											if ($donnees['URL'] == $listebannieres['URL']) {
												echo ' selected';
											}
										echo '>'.$listebannieres['TITRE'].'</option>';
									}
									?>
								</select> 
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
						</div> 
						
						<p id="clear">&nbsp;</p>
						
						<input name="update" type="submit" class=" btn btn-large btn-success pull-right" value="Mettre à jour"/>
						<?php if ($donnees['URL'] != "/index.php") { ?>
						<a href="carousel.php?action=suppression&ID=<?php echo $donnees['ID']; ?>" class="btn btn-danger">Supprimer</a>
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