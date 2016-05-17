<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			SUPPRESSION SOUS MENU ? 
***************************************************************/
if(isset($_POST['suppression'])){ 
	$ID = $_POST['ID']; 

	$query = 'DELETE FROM SITE_PAGES 
		WHERE ID = :ID AND VISIBLE = 4';
	
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
if($check==true){

	$action = $_GET['action'];
	$ID = $_GET['ID'];
	
	if($action == "suppression"){
		$query = 'SELECT * FROM SITE_PAGES
		WHERE ID = :ID AND VISIBLE = 4';
		
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		
		$donnees = $stmt->fetch();
		echo ('<p>Confirmez-vous la suppression irréversible du sous menu <strong>'.$donnees['TITRE'].'</strong> ?</p>
			<p><form action="menus.php" method="post" name="post"><br />
				<input name="ID" type="hidden" value="'.$donnees['ID'].'">
				<a href="menus.php" class=" btn btn-default">Retour</a>
				<input name="suppression" type="submit" class=" btn btn-danger btn-large pull-right" value="Effacer" />
			</form></p>');
	}
}
/**************************************************************
			LISTING SOUS MENU 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) { 
/**************************************************************
			AJOUT SOUS MENU ? 
***************************************************************/					
if(isset($_POST['add_post'])){
	$ID = $_POST['ID']; 
	$URL = $_POST['URL']; 
	$TITRE = $_POST['TITRE'];
	$CONTENU = $_POST['CONTENU']; 
	$VISIBLE = $_POST['VISIBLE']; 
	$ORDRE = $_POST['ORDRE']; 
	$MENU = $_POST['MENU'];
	if(empty($TITRE) OR empty ($VISIBLE)){
		echo ('<div class="alert alert-danger"><strong>Merci de remplir tous les champs !</strong></div>');
	} else {						
		$query = 'INSERT INTO SITE_PAGES ( ID, URL, TITRE, CONTENU, VISIBLE, MENU, ORDRE) VALUES ( :ID, :URL, :TITRE, :CONTENU, :VISIBLE, :MENU, :ORDRE)';
		$stmt= $bdd->prepare($query);
		if( $stmt->execute(array(
				':ID' => $ID,
				':URL' => $URL,
				':TITRE' => $TITRE,
				':CONTENU' => $CONTENU,
				':ORDRE' => $ORDRE,	
				':VISIBLE' => $VISIBLE,	 	
				':MENU' => $MENU))) { 
				header('Location: '.$_SERVER['PHP_SELF'].'?m=7');
			} else {
				header('Location: '.$_SERVER['PHP_SELF'].'?e=7');
			}
		}
	}	
/**************************************************************
			AJOUT LIEN EXTERNE ? 
***************************************************************/					
if(isset($_POST['add_lien'])){
	$ID = $_POST['ID']; 
	$URL = $_POST['URL']; 
	$TITRE = $_POST['TITRE'];
	$CONTENU = $_POST['CONTENU']; 
	$VISIBLE = $_POST['VISIBLE']; 
	$ORDRE = $_POST['ORDRE']; 
	$MENU = $_POST['MENU'];
	if(empty($TITRE) OR empty ($VISIBLE)){
		echo ('<div class="alert alert-danger"><strong>Merci de remplir tous les champs !</strong></div>');
	} else {						
		$query = 'INSERT INTO SITE_PAGES ( ID, URL, TITRE, CONTENU, VISIBLE, MENU, ORDRE) VALUES ( :ID, :URL, :TITRE, :CONTENU, :VISIBLE, :MENU, :ORDRE)';
		$stmt= $bdd->prepare($query);
		if( $stmt->execute(array(
				':ID' => $ID,
				':URL' => $URL,
				':TITRE' => $TITRE,
				':CONTENU' => $CONTENU,
				':ORDRE' => $ORDRE,	
				':VISIBLE' => $VISIBLE,	 	
				':MENU' => $MENU))) { 
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
	<li role="presentation"><a href="#nouveau" aria-controls="nouveau" role="tab" data-toggle="tab"><i class="fa fa-plus fa-1x"></i> Ajouter un sous-menu</a></li>
	<li role="presentation"><a href="#lien" aria-controls="lien" role="tab" data-toggle="tab"><i class="fa fa-link fa-1x"></i> Ajouter un lien externe</a></li>
	<li role="presentation"><a href="#parametres" aria-controls="parametres" role="tab" data-toggle="tab"><i class="fa fa-cog fa-1x"></i> Paramètres</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="modifications"> 
		<br />
		<p>Si aucun Ordre n'est défini pour les liens d'un sous menu, ceux-ci se classeront par défaut par ordre alphabétique. L'affichage de l'icône "Page d'accueil" <strong><?php if (parametre(34, $bdd) != 'NON') { echo 'est activé'; if (parametre(35, $bdd) != 'NON') { echo ', sur toutes les pages du site'; } else { echo ', uniquement sur les pages autres que la page d\'accueil'; } } else { echo 'est désactivé'; } ?></strong>.</p> 
		<table class="table table-responsive table-striped table-condensed table-hover">
			<thead>
				<tr> 
					<th style="display:none;">Menu</th>
					<th>Ordre</th>
					<th>Type</th> 
					<th>Titre</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php  
				$reponse = $bdd->query('SELECT * FROM SITE_PAGES WHERE MENU = 1 ORDER BY MENU, ORDRE, TITRE ASC');
				while ($donnees = $reponse->fetch()) {
					
					$sousmenu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donnees['ID']." ORDER BY ORDRE ASC");
					if ( $sousmenu->rowCount() > 0) { 
							echo '
								<tr> 
									<td style="display:none;">';
										if ($donnees['MENU'] == "1") {
											echo ''; 
										} else {
											echo '';
											$requete = $bdd->query('SELECT * FROM SITE_PAGES WHERE ID = '.$donnees['MENU'].' ORDER BY TITRE ASC');
												if ($donneeslien = $requete->fetch()) {
													echo $donneeslien['TITRE'] . ' '/* . $donneeslien['URL'] */;
												}
												$requete->closeCursor();
										}	
										echo '
									</td> 
									<td>';
										if ($donnees['ORDRE'] != "0") {
											echo '<strong>'.$donnees['ORDRE'].'</strong>'; 
										}
										echo '
									</td>
									<td class="';
										if ($donnees['VISIBLE'] == "2") {
												echo 'info';
											} else if ($donnees['VISIBLE'] == "3") {
												echo 'success';
											} else if ($donnees['VISIBLE'] == "4") {
												echo 'warning';
											} else if ($donnees['VISIBLE'] == "5") {
												echo 'info';
											} else {
												echo 'danger';
											} 
										echo '" style="padding: 10px 5px;" ><span style="';
											if ($donnees['VISIBLE'] == "2") {
													echo 'color:#3498DB;';
												} else if ($donnees['VISIBLE'] == "3") {
													echo 'color:#94D094;';
												} else if ($donnees['VISIBLE'] == "4") {
													echo 'color:#94D094;';
												} else if ($donnees['VISIBLE'] == "5") {
													echo 'color:#ffffff;';
												} else {
													echo 'color:#C02600;';
												}
										
										echo '">';
											if ($donnees['VISIBLE'] == "2") {
													echo 'Brouillon';
												} else if ($donnees['VISIBLE'] == "3") {
													echo 'Page';
												} else if ($donnees['VISIBLE'] == "4") {
													echo 'Sous menu niveau 1';
												} else if ($donnees['VISIBLE'] == "5") {
													echo 'Lien externe';
												} else {
													echo 'Non publiée';
												}
										
										echo '</span>
									</td>	
									<td><i class="fa fa-arrow-right fa-1x"></i> <strong>'.$donnees['TITRE'].'</strong></td>	
									<td style="text-align:left;">';
										if ($donnees['VISIBLE'] < "4") {	
										echo '
											<a href="..'. $donnees['URL'].'" target="_blank" class=" btn  btn-info"><i class="fa fa-eye fa-1x"></i></a>
											<a href="pages.php?ID='.$donnees['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a>';
										 }
										if ($donnees['VISIBLE'] == "4") {	
										echo '
											<a href="..'. $donnees['URL'].'" target="_blank" class=" btn" style="cursor:default;background-color:transparent;color:transparent;"disabled><i class="fa fa-eye-slash fa-1x"></i></a>
											<a href="menus.php?ID='.$donnees['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
											<a href="menus.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
										 }
										if ($donnees['VISIBLE'] == "5") {	
										echo '
											<a href="'. $donnees['URL'].'" target="_blank" class=" btn" style="cursor:default;background-color:transparent;color:transparent;"disabled><i class="fa fa-eye-slash fa-1x"></i></a>
											<a href="menus.php?ID='.$donnees['ID'].'&action=edit_lien" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
											<a href="menus.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
										 }
										echo '
									</td>
								</tr>';
						
					
						while ($donneessousmenu = $sousmenu->fetch()) {
							/**************************/					
							/***** 2 EME SOUS MENU ****/					
							/**************************/					
							if ($donneessousmenu['VISIBLE'] == '4') { 
								echo '
									<tr> 
										<td style="display:none;">';
											if ($donneessousmenu['MENU'] == "1") {
												echo ''; 
											} else {
												echo '';
												$requete = $bdd->query('SELECT * FROM SITE_PAGES WHERE ID = '.$donneessousmenu['MENU'].' ORDER BY TITRE ASC');
													if ($donneeslien = $requete->fetch()) {
														echo $donneeslien['TITRE'] . ' '/* . $donneeslien['URL'] */;
													}	
													$requete->closeCursor();
												}
											echo '
										</td>
										<td>';
											if ($donneessousmenu['ORDRE'] != "0") {
												echo '<strong>└&nbsp;'.$donneessousmenu['ORDRE']."</strong>"; 
											}
											echo '
										</td>
										<td class="';
											if ($donneessousmenu['VISIBLE'] == "2") {
													echo 'info';
												} else if ($donneessousmenu['VISIBLE'] == "3") {
													echo 'success';
												} else if ($donneessousmenu['VISIBLE'] == "4") {
													echo 'warning';
												} else if ($donneessousmenu['VISIBLE'] == "5") {
													echo 'info';
												} else {
													echo 'danger';
												}
										
										echo '" style="padding: 10px 5px;" ><span style="';
													if ($donneessousmenu['VISIBLE'] == "2") {
															echo 'color:#3498DB;';
														} else if ($donneessousmenu['VISIBLE'] == "3") {
															echo 'color:#94D094;';
														} else if ($donneessousmenu['VISIBLE'] == "4") {
															echo 'color:#94D094;';
														} else if ($donneessousmenu['VISIBLE'] == "5") {
															echo 'color:#ffffff;';
														} else {
															echo 'color:#C02600;';
														}
												
												echo '">';
													if ($donneessousmenu['VISIBLE'] == "2") {
															echo 'Brouillon';
														} else if ($donneessousmenu['VISIBLE'] == "3") {
															echo 'Page';
														} else if ($donneessousmenu['VISIBLE'] == "4") {
															echo 'Sous menu niveau 2';
														} else if ($donneessousmenu['VISIBLE'] == "5") {
															echo 'Lien externe';
														} else {
															echo 'Non publiée';
														}
												
												echo '</span></td> 
										<td><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right fa-1x"></i> '. $donneessousmenu['TITRE'].'</strong></td> 
										<td style="text-align:left;">';
											if ($donneessousmenu['VISIBLE'] < "4") {	
											echo '
												<a href="..'. $donneessousmenu['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a>
												<a href="pages.php?ID='.$donneessousmenu['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a>';
											 }
											if ($donneessousmenu['VISIBLE'] == "4") {	
											echo '
												<a href="..'. $donnees['URL'].'" target="_blank" class=" btn" style="cursor:default;background-color:transparent;color:transparent;"disabled><i class="fa fa-eye-slash fa-1x"></i></a>
												<a href="menus.php?ID='.$donneessousmenu['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
												<a href="menus.php?action=suppression&ID='.$donneessousmenu['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
											 }
											if ($donneessousmenu['VISIBLE'] == "5") {	
											echo '
												<a href="'. $donneessousmenu['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a>
												<a href="menus.php?ID='.$donneessousmenu['ID'].'&action=edit_lien" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
												<a href="menus.php?action=suppression&ID='.$donneessousmenu['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
											 }
											 echo '
										</td>
									</tr>';
								$sousmenudeux = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenu['MENU']." AND VISIBLE = 4 ORDER BY ORDRE ASC");
								if ( $sousmenudeux->rowCount() > 0) {
									while ($donneessousmenudeux = $sousmenudeux->fetch()) { 
										$sousmenutrois = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenudeux['ID']." AND (VISIBLE = 3 OR VISIBLE = 5) ORDER BY ORDRE ASC");
										while ($donneessousmenutrois = $sousmenutrois->fetch()) { 
											if ($donneessousmenu['ID'] == $donneessousmenutrois['MENU'] ) {
												echo '
													<tr> 
														<td style="display:none;">';
															if ($donneessousmenutrois['MENU'] == "1") {
																echo ''; 
															} else {
																echo '';
																$requete = $bdd->query('SELECT * FROM SITE_PAGES WHERE ID = '.$donneessousmenutrois['MENU'].' ORDER BY TITRE ASC');
																	if ($donneeslien = $requete->fetch()) {
																		echo $donneeslien['TITRE'] . ' ; '/* . $donneeslien['URL'] */;
																	}	
																	$requete->closeCursor();
																}
															echo '
														</td>
														<td>';
															if ($donneessousmenutrois['ORDRE'] != "0") {
																echo '&nbsp;&nbsp;&nbsp;&nbsp;└&nbsp;'.$donneessousmenutrois['ORDRE']; 
															}
															echo '
														</td>
														<td class="';
															if ($donneessousmenutrois['VISIBLE'] == "2") {
																	echo 'info';
																} else if ($donneessousmenutrois['VISIBLE'] == "3") {
																	echo 'success';
																} else if ($donneessousmenutrois['VISIBLE'] == "4") {
																	echo 'warning';
																} else if ($donneessousmenutrois['VISIBLE'] == "5") {
																	echo 'info';
																} else {
																	echo 'danger';
																}
														
														echo '" style="padding: 10px 5px;" ><span style="';
																	if ($donneessousmenutrois['VISIBLE'] == "2") {
																			echo 'color:#3498DB;';
																		} else if ($donneessousmenutrois['VISIBLE'] == "3") {
																			echo 'color:#94D094;';
																		} else if ($donneessousmenutrois['VISIBLE'] == "4") {
																			echo 'color:#94D094;';
																		} else if ($donneessousmenutrois['VISIBLE'] == "5") {
																			echo 'color:#ffffff;';
																		} else {
																			echo 'color:#C02600;';
																		}
																
																echo '">';
																	if ($donneessousmenutrois['VISIBLE'] == "2") {
																			echo 'Brouillon';
																		} else if ($donneessousmenutrois['VISIBLE'] == "3") {
																			echo 'Page';
																		} else if ($donneessousmenutrois['VISIBLE'] == "4") {
																			echo 'Sous menu';
																		} else if ($donneessousmenutrois['VISIBLE'] == "5") {
																			echo 'Lien externe';
																		} else {
																			echo 'Non publiée';
																		}
																
																echo '</span></td> 
														<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└&nbsp;'. $donneessousmenutrois['TITRE'].'</td> 
														<td style="text-align:left;">';
															if ($donneessousmenutrois['VISIBLE'] < "4") {	
															echo '
																<a href="..'. $donneessousmenutrois['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a>
																<a href="pages.php?ID='.$donneessousmenutrois['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a>';
															 }
															if ($donneessousmenutrois['VISIBLE'] == "4") {	
															echo '
																<a href="..'. $donneessousmenutrois['URL'].'" target="_blank" class=" btn  btn-warning" ><i class="fa fa-eye fa-1x"></i></a>
																<a href="menus.php?ID='.$donneessousmenutrois['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
																<a href="menus.php?action=suppression&ID='.$donneessousmenutrois['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
															 }
															if ($donneessousmenutrois['VISIBLE'] == "5") {	
															echo '
																<a href="'. $donneessousmenutrois['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a>
																<a href="menus.php?ID='.$donneessousmenutrois['ID'].'&action=edit_lien" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
																<a href="menus.php?action=suppression&ID='.$donneessousmenutrois['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
															 }
															 echo '
														</td>
													</tr>'; 
											}
										}
									}
								}
							} else {
								echo '
									<tr> 
										<td style="display:none;">';
											if ($donneessousmenu['MENU'] == "1") {
												echo ''; 
											} else {
												echo '';
												$requete = $bdd->query('SELECT * FROM SITE_PAGES WHERE ID = '.$donneessousmenu['MENU'].' ORDER BY TITRE ASC');
													if ($donneeslien = $requete->fetch()) {
														echo $donneeslien['TITRE'] . ' '/* . $donneeslien['URL'] */;
													}	
													$requete->closeCursor();
												}
											echo '
										</td>
										<td>';
											if ($donneessousmenu['ORDRE'] != "0") {
												echo '└&nbsp;'.$donneessousmenu['ORDRE']; 
											}
											echo '
										</td>
										<td class="';
											if ($donneessousmenu['VISIBLE'] == "2") {
													echo 'info';
												} else if ($donneessousmenu['VISIBLE'] == "3") {
													echo 'success';
												} else if ($donneessousmenu['VISIBLE'] == "4") {
													echo 'warning';
												} else if ($donneessousmenu['VISIBLE'] == "5") {
													echo 'info';
												} else {
													echo 'danger';
												}
										
										echo '" style="padding: 10px 5px;" ><span style="';
													if ($donneessousmenu['VISIBLE'] == "2") {
															echo 'color:#3498DB;';
														} else if ($donneessousmenu['VISIBLE'] == "3") {
															echo 'color:#94D094;';
														} else if ($donneessousmenu['VISIBLE'] == "4") {
															echo 'color:#94D094;';
														} else if ($donneessousmenu['VISIBLE'] == "5") {
															echo 'color:#ffffff;';
														} else {
															echo 'color:#C02600;';
														}
												
												echo '">';
													if ($donneessousmenu['VISIBLE'] == "2") {
															echo 'Brouillon';
														} else if ($donneessousmenu['VISIBLE'] == "3") {
															echo 'Page';
														} else if ($donneessousmenu['VISIBLE'] == "4") {
															echo 'Sous menu';
														} else if ($donneessousmenu['VISIBLE'] == "5") {
															echo 'Lien externe';
														} else {
															echo 'Non publiée';
														}
												
												echo '</span></td> 
										<td>└&nbsp;'. $donneessousmenu['TITRE'].'</td> 
										<td style="text-align:left;">';
											if ($donneessousmenu['VISIBLE'] < "4") {	
											echo '
												<a href="..'. $donneessousmenu['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a>
												<a href="pages.php?ID='.$donneessousmenu['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a>';
											 }
											if ($donneessousmenu['VISIBLE'] == "4") {	
											echo '
												<a href="..'. $donneessousmenu['URL'].'" target="_blank" class=" btn  btn-warning" ><i class="fa fa-eye fa-1x"></i></a>
												<a href="menus.php?ID='.$donneessousmenu['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
												<a href="menus.php?action=suppression&ID='.$donneessousmenu['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
											 }
											if ($donneessousmenu['VISIBLE'] == "5") {	
											echo '
												<a href="'. $donneessousmenu['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a>
												<a href="menus.php?ID='.$donneessousmenu['ID'].'&action=edit_lien" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
												<a href="menus.php?action=suppression&ID='.$donneessousmenu['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
											 }
											 echo '
										</td>
									</tr>';
							}
							/**************/					
							/**************/					
							/**************/					
						}
					
					} else {
						echo '
						<tr>  
							<td style="display:none;">';
								if ($donnees['MENU'] == "1") {
									echo ''; 
								} else {
									echo '';
									$requete = $bdd->query('SELECT * FROM SITE_PAGES WHERE ID = '.$donnees['MENU'].' ORDER BY TITRE ASC');
										if ($donneeslien = $requete->fetch()) {
											echo $donneeslien['TITRE'] . ' '/* . $donneeslien['URL'] */;
										}
										$requete->closeCursor();
								}	
								echo '
							</td>
							<td>';
								if ($donnees['ORDRE'] != "0") {
									echo '<strong>'.$donnees['ORDRE'].'</strong>'; 
								}
								echo '
							</td>
							<td class="';
								if ($donnees['VISIBLE'] == "2") {
										echo 'info';
									} else if ($donnees['VISIBLE'] == "3") {
										echo 'success';
									} else if ($donnees['VISIBLE'] == "4") {
										echo 'warning';
									} else if ($donnees['VISIBLE'] == "5") {
										echo 'info';
									} else {
										echo 'danger';
									}
							
								echo '" style="padding: 10px 5px;" ><span style="';
									if ($donnees['VISIBLE'] == "2") {
											echo 'color:#3498DB;';
										} else if ($donnees['VISIBLE'] == "3") {
											echo 'color:#94D094;';
										} else if ($donnees['VISIBLE'] == "4") {
											echo 'color:#94D094;';
										} else if ($donnees['VISIBLE'] == "5") {
											echo 'color:#ffffff;';
										} else {
											echo 'color:#C02600;';
										}
								
								echo '">';
									if ($donnees['VISIBLE'] == "2") {
											echo 'Brouillon';
										} else if ($donnees['VISIBLE'] == "3") {
											echo 'Page';
										} else if ($donnees['VISIBLE'] == "4") {
											echo 'Sous menu';
										} else if ($donnees['VISIBLE'] == "5") {
											echo 'Lien externe';
										} else {
											echo 'Non publiée';
										}
								
								echo '</span>
							</td>
							<td><i class="fa fa-arrow-right fa-1x"></i> <strong>'.$donnees['TITRE'].'</strong></td>
							<td style="text-align:left;">';
								if ($donnees['VISIBLE'] < "4") {	
								echo '
									<a href="..'. $donnees['URL'].'" target="_blank" class=" btn  btn-info"><i class="fa fa-eye fa-1x"></i></a>
									<a href="pages.php?ID='.$donnees['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a>';
								 }
								if ($donnees['VISIBLE'] == "4") {	
								echo '
									<a href="..'. $donnees['URL'].'" target="_blank" class=" btn" style="cursor:default;background-color:transparent;color:transparent;"disabled><i class="fa fa-eye-slash fa-1x"></i></a>
									<a href="menus.php?ID='.$donnees['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
									<a href="menus.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
								 }
								if ($donnees['VISIBLE'] == "5") {	
								echo '
									<a href="'. $donnees['URL'].'" target="_blank" class=" btn  btn-info" ><i class="fa fa-eye fa-1x"></i></a>
									<a href="menus.php?ID='.$donnees['ID'].'&action=edit_lien" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
									<a href="menus.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
								 }
								echo '</td>
						</tr>';
					}
				}
				$reponse->closeCursor();
				?>
			</tbody>
		</table> 
		
		<h2>Eléments non affichés dans le menu</h2>
		 <table class="table table-responsive table-striped table-condensed table-hover">
			<thead>
				<tr> 
					<th>Type</th> 
					<th>Titre</th>
					<th>URL</th>  
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$reponse = $bdd->query('SELECT * FROM SITE_PAGES WHERE MENU = 0 AND ID NOT LIKE 1 AND URL NOT LIKE "/erreur-404.php" AND URL NOT LIKE "/recherche.php" AND URL NOT LIKE "/mentions-legales.php" ORDER BY VISIBLE, TITRE ASC');
				while ($donnees = $reponse->fetch()) {
					echo '
						<tr> 
							<td class="';
								if ($donnees['VISIBLE'] == "2") {
										echo 'info';
									} else if ($donnees['VISIBLE'] == "3") {
										echo 'success';
									} else if ($donnees['VISIBLE'] == "4") {
										echo 'warning';
									} else if ($donnees['VISIBLE'] == "5") {
										echo 'info';
									} else {
										echo 'danger';
									}
							
							echo '" style="padding: 10px 5px;" ><span style="';
										if ($donnees['VISIBLE'] == "2") {
												echo 'color:#3498DB;';
											} else if ($donnees['VISIBLE'] == "3") {
												echo 'color:#94D094;';
											} else if ($donnees['VISIBLE'] == "4") {
												echo 'color:#94D094;';
											} else if ($donnees['VISIBLE'] == "5") {
												echo 'color:#ffffff;';
											} else {
												echo 'color:#C02600;';
											}
									
									echo '">';
										if ($donnees['VISIBLE'] == "2") {
												echo 'Brouillon';
											} else if ($donnees['VISIBLE'] == "3") {
												echo 'Page';
											} else if ($donnees['VISIBLE'] == "4") {
												echo 'Sous menu';
											} else if ($donnees['VISIBLE'] == "5") {
												echo 'Lien externe';
											} else {
												echo 'Non publiée';
											}
									
									echo '</span></td>
							<td><strong>'. $donnees['TITRE'].'</strong></td>
							<td>'. $donnees['URL'].'</td>
							<td>';
								if ($donnees['VISIBLE'] < "4") {	
								echo '
									<a href="..'. $donnees['URL'].'" target="_blank" class=" btn  btn-info"><i class="fa fa-eye fa-1x"></i></a>
									<a href="pages.php?ID='.$donnees['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a>';
								 }
								if ($donnees['VISIBLE'] > "3") {	
								echo '
									<a href="..'. $donnees['URL'].'" target="_blank" class=" btn" style="cursor:default;background-color:transparent;color:transparent;"disabled><i class="fa fa-eye-slash fa-1x"></i></a>
									<a href="menus.php?ID='.$donnees['ID'].'&action=edit" class=" btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> 
									<a href="menus.php?action=suppression&ID='.$donnees['ID'].'" class=" btn  btn-danger"><i class="fa fa-trash-o fa-1x"></i></a>';
								 }
								echo '   
							</td>
						</tr>';
					}
				$reponse->closeCursor();
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="apercu">
		<br />
		<p>Voici le menu actuellement paramétré sur le site :</p> 
		<p><ul style="padding: 0 8%; "> 
		<?php
		if (parametre(34, $bdd) != 'NON') {
			echo '<li '; if ($_SERVER['PHP_SELF'] == '/index.php') { echo 'class="active"'; } echo '><a style="display:inline-block;margin-right:4px;" href="/"><i class="fa fa-home" style="vertical-align:middle;"></i></a></li>';
		}
		$menu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = 1 AND VISIBLE > 2 ORDER BY ORDRE ASC"); 
		while ($donneesmenu = $menu->fetch()) {
			$sousmenu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneesmenu['ID']." AND VISIBLE > 2 ORDER BY ORDRE ASC");
			if ( $sousmenu->rowCount() > 0) { 
					echo '<li style="line-height:2em;"><a href="#" >'.$donneesmenu['TITRE'].' <span class="caret"></span></a>';
					echo '<br />';
						while ($donneessousmenu = $sousmenu->fetch()) { 
							if ($donneessousmenu['VISIBLE'] == '4') {
										echo '<ul style=\"margin:0%;\"><li style=\"font-size: 0.8em;\">'.$donneessousmenu['TITRE'].'';
								$sousmenudeux = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenu['MENU']." AND VISIBLE = 4 ORDER BY ORDRE ASC");
								if ( $sousmenudeux->rowCount() > 0) {
									while ($donneessousmenudeux = $sousmenudeux->fetch()) {
										$sousmenutrois = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenudeux['ID']." AND (VISIBLE = 3 OR VISIBLE = 5) ORDER BY ORDRE ASC");
										while ($donneessousmenutrois = $sousmenutrois->fetch()) {
											echo "<ul style=\"margin:0%;\">";
											if ($donneessousmenu['ID'] == $donneessousmenutrois['MENU'] ) {
												echo "<li style=\"font-size: 0.8em;\"><a href=\"";
													if ($donneessousmenutrois['VISIBLE'] == '5') {
														echo  $donneessousmenutrois['URL']."\" target=\"_blank\" title=\"Lien externe\""; 
													} else {
														echo "//". $_SERVER['SERVER_NAME'] . $donneessousmenutrois['URL']."\" title=\"".$donneessousmenutrois['TITRE']."\"";
													};
												echo " >";
													if ($donneessousmenutrois['VISIBLE'] == '5') {
														echo  '<i class="fa fa-link fa-1x"></i> '; 
													} else {
														echo "";
													};
												echo $donneessousmenutrois['TITRE']."</a>"; 
											}
											echo "</ul>";
										}
									}
								}
								echo "</li></ul>";
							 	
							} else {
								echo "<ul style=\"margin:0%;\"><li style=\"font-size: 1em;\"><a href=\"";
									if ($donneessousmenu['VISIBLE'] == '5') {
										echo  $donneessousmenu['URL']."\" target=\"_blank\" title=\"Lien externe\""; 
									} else {
										echo "//". $_SERVER['SERVER_NAME'] . $donneessousmenu['URL']."\" title=\"".$donneessousmenu['TITRE']."\"";
									};
								echo " >";
									if ($donneessousmenu['VISIBLE'] == '5') {
										echo  '<i class="fa fa-link fa-1x"></i> '; 
									} else {
										echo "";
									};
								echo $donneessousmenu['TITRE']."</a></li></ul>";
						}
					}
					echo ' ';
				} else {
					echo "<li style=\"line-height:2em;\"><a href=\"//". $_SERVER['SERVER_NAME'] . $donneesmenu['URL']."\">".$donneesmenu['TITRE']."</a>";
				}
			} 
		?> 
		</ul> </p>
	</div>
	<div role="tabpanel" class="tab-pane" id="nouveau">
		<br />
		<p>Cet élément permet d'afficher le <strong>sous-menu</strong> des pages qui y sont associées.</p> 
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value=""/> 
			<input name="URL" type="hidden" size="0" value="#"/>
			<input name="VISIBLE" type="hidden" size="0" value="4"/>
			<input name="CONTENU" type="hidden" size="0" value=""/>
			
			<div class="form-group">
			
				<p id="clear">&nbsp;</p>
			
				<div class="col-md-6"> 
					<p><label>Titre</label>
					<input name="TITRE" type="text" class="form-control" value="<?php if(isset($_POST['TITRE'])) echo $TITRE; ?>" required>
					</p> 
				</div> 
		
				<p id="clear" class="visible-phone">&nbsp;</p>
			
				<div class="col-md-5 ">
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
							echo'>En tant que SOUS MENU de '.$listepages['TITRE'].'</option>';
						} /* */
						?>
					</select> 
					</p>
									
					<p id="clear">&nbsp;</p>
					
					<p><label>Ordre</label>
					<select name="ORDRE" > 
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
			</div> 
			
			<p id="clear">&nbsp;</p>
			
			<a href="menus.php" class=" btn btn-default">Retour</a>
			<input name="add_post" type="submit" class=" btn btn-large btn-success pull-right" value="Ajouter"/>
		</form> 
	</div>
	<div role="tabpanel" class="tab-pane" id="lien">
		<br />
		<p>Permet d'ajouter un bouton dans le menu qui redirige <strong>vers un autre site internet</strong>.</p> 
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value=""/>  
			<input name="VISIBLE" type="hidden" size="0" value="5"/>
			<input name="CONTENU" type="hidden" size="0" value=""/>
			
			<div class="form-group">
				
				<p id="clear">&nbsp;</p>
			
				<div class="col-md-6"> 
					<p><label>Titre</label>
					<input name="TITRE" type="text" class="form-control" value="<?php if(isset($_POST['TITRE'])) echo $TITRE; ?>" required>
					</p> 
					
					<p id="clear">&nbsp;</p>
					
					<p><label>URL <small><em></em></small></label>
					<input id="URL" name="URL" type="text" value="<?php if(isset($_POST['URL'])) echo $URL; ?>" />
					</p>
					
				</div> 
		
				<p id="clear" class="visible-phone">&nbsp;</p>
			
				<div class="col-md-5 ">
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
							echo'>En tant que SOUS MENU de '.$listepages['TITRE'].'</option>';
						} /* */
						?>
					</select> 
					</p>
									
					<p id="clear">&nbsp;</p>
					
					<p><label>Ordre</label>
					<select name="ORDRE" > 
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
			</div> 
			
			<p id="clear">&nbsp;</p>
			
			<a href="menus.php" class=" btn btn-default">Retour</a>
			<input name="add_lien" type="submit" class=" btn btn-large btn-success pull-right" value="Ajouter"/>
		</form> 
	</div>
	<div role="tabpanel" class="tab-pane" id="parametres"> 
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 8 ORDER BY POSITION ASC"); 
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
				MODIFICATION SOUS MENU ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])){ 
		$TITRE = $_POST['TITRE']; 
		$MENU = $_POST['MENU'];
		$ORDRE = $_POST['ORDRE'];
		$ID = $_POST['ID'];

		
		
		$query = 'UPDATE SITE_PAGES SET 
			 TITRE = :TITRE,  
			 MENU = :MENU,
			 ORDRE = :ORDRE
			 WHERE ID = :ID';

		$stmt= $bdd->prepare($query);	
			
		if( $stmt->execute(array( 
			':TITRE' => $TITRE, 
			':MENU' => $MENU,
			':ORDRE' => $ORDRE,
			':ID' => $ID))) {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&m=8');
			} else {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&e=8');
			}
	}
	if(isset($_POST['update_lien'])){ 
		$TITRE = $_POST['TITRE']; 
		$URL = $_POST['URL']; 
		$MENU = $_POST['MENU'];
		$ORDRE = $_POST['ORDRE'];
		$ID = $_POST['ID'];

		
		
		$query = 'UPDATE SITE_PAGES SET 
			 TITRE = :TITRE,  
			 URL = :URL,  
			 MENU = :MENU,
			 ORDRE = :ORDRE
			 WHERE ID = :ID';

		$stmt= $bdd->prepare($query);	
			
		if( $stmt->execute(array( 
			':TITRE' => $TITRE, 
			':URL' => $URL, 
			':MENU' => $MENU,
			':ORDRE' => $ORDRE,
			':ID' => $ID))) {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit_lien&m=8');
			} else {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit_lien&e=8');
			}
	}
	/**************************************************************
				MODE MODIFICATION SOUS MENU
	***************************************************************/ 
	if($action == "edit"){
		$query = 'SELECT * FROM SITE_PAGES
		WHERE ID = :ID AND VISIBLE = 4';
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		$donnees = $stmt->fetch(); ?>
		<p>Cet élément permet d'afficher le <strong>sous-menu</strong> des pages qui y sont associées.</p> 
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" />
			
			<div class="form-group">
				
				<p id="clear">&nbsp;</p>
			
				<div class="col-md-6">
					<p><label>Titre</label>
					<input name="TITRE" type="text" value="<?php echo $donnees['TITRE']; ?>"required/>
					</p>
				</div> 
			
				<p id="clear" class="visible-phone">&nbsp;</p>
			
				<div class="col-md-5 ">
					<p><label>Menu</label>
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
						?> 
					</select> 
					</p>  
									
					<p id="clear">&nbsp;</p>
					
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
			</div>
				
			<p id="clear">&nbsp;</p>
			
			<a href="menus.php" class=" btn btn-default">Retour</a>
			<input name="update" type="submit" class=" btn btn-large btn-success pull-right" value="Mettre à jour"/>
			<a href="menus.php?action=suppression&ID=<?php echo $donnees['ID']; ?>" class="btn btn-danger">Supprimer</a>
		</form>
	<?php
	}
	/**************************************************************
				MODE MODIFICATION LIEN EXTERNE
	***************************************************************/ 
	if($action == "edit_lien"){
		$query = 'SELECT * FROM SITE_PAGES
		WHERE ID = :ID AND VISIBLE = 5';
		$stmt = $bdd->prepare($query);
		$stmt->execute(array(':ID' => $ID));
		$donnees = $stmt->fetch(); ?>
		<p>Permet d'ajouter un lien <strong>vers un autre site internet</strong> qui s'ouvre automatiquement dans un nouvel onglet.</p> 
		<form action="" method="post" name="post">
			<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" />
			
			<div class="form-group">
				
				<p id="clear">&nbsp;</p>
			
				<div class="col-md-6">
					<p><label>Titre</label>
					<input name="TITRE" type="text" value="<?php echo $donnees['TITRE']; ?>"required/>
					</p>
					
					<p id="clear">&nbsp;</p>
					
					<p><label>URL</label>
					<input name="URL" type="text" value="<?php echo $donnees['URL']; ?>"required/>
					</p>
				</div> 
			
				<p id="clear" class="visible-phone">&nbsp;</p>
			
				<div class="col-md-5 ">
					<p><label>Menu</label>
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
						?>
					</select> 
					</p>  
									
					<p id="clear">&nbsp;</p>
					
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
			</div>
				
			<p id="clear">&nbsp;</p>
			
			<a href="menus.php" class=" btn btn-default">Retour</a>
			<input name="update_lien" type="submit" class=" btn btn-large btn-success pull-right" value="Mettre à jour"/>
			<a href="menus.php?action=suppression&ID=<?php echo $donnees['ID']; ?>" class="btn btn-danger">Supprimer</a>
		</form>
	<?php
	}
}	
  
?> 
<?php include'../admin/html/footer.php'; ?>