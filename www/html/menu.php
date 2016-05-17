<div class="nav">
	<div <?php if (parametre(20, $bdd) != 'TOP') { ?>class="visible-phone" <?php }?> style="margin-bottom: 60px;">
		<nav class="navbar navbar-default navbar-fixed-top <?php if (parametre(20, $bdd) != 'TOP') { ?>visible-phone<?php }?>">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button> 
				</div>
				<div id="site-nom"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>" class="bottom_tooltip" title="Accueil du site <?php echo parametre(4, $bdd); ?>" ><?php echo parametre(4, $bdd); ?></a></div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
					<?php 
					if (parametre(34, $bdd) != 'NON') {
						if ((parametre(35, $bdd) == 'OUI') || (parametre(35, $bdd) == 'NON') && (($_SERVER['PHP_SELF'] != '/index.php'))) {
							echo '<li '; if ($_SERVER['PHP_SELF'] == '/index.php') { echo 'class="active"'; } echo '><a style="display:inline-block;margin-right:4px;" href="/" title="Retour à l\'accueil"><i class="fa fa-home" style="vertical-align:middle;"></i></a></li>';
						}	 
					}	 
					$menu = ("SELECT * FROM SITE_PAGES WHERE MENU = 1 AND VISIBLE > :VISIBLE ORDER BY ORDRE ASC"); 
					$stmt = $bdd->prepare($menu);
					$stmt->execute(array(':VISIBLE' => $VISIBILITE)); 
					while ($donneesmenu = $stmt->fetch()) { 
						if ($donneesmenu['URL'] == $_SERVER['PHP_SELF']) {
							$active = 'active';
						} else {
							$active = '';
						};
						$sousmenu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneesmenu['ID']." ORDER BY ORDRE ASC");
						if ( $sousmenu->rowCount() > 0) { 
							$sousmenunumero = "";
							$sousmenunumero = $donneesmenu['ID'];
							echo '<li id="sousmenu'. $sousmenunumero .'" class="dropdown'; 
								// On détermine si Sous-menu de niveau 1 est parent (active) du lien en cours 
								$sousmenuactif = $bdd->query("SELECT * FROM SITE_PAGES WHERE URL = '". $_SERVER['PHP_SELF'] ."' AND MENU = ". $donneesmenu['ID']." ORDER BY ORDRE ASC");
								if ( $sousmenuactif->rowCount() > 0) {
									echo ' active'  ;
								}  
								// On détermine si Sous-menu de niveau 2 est enfant (active) du menu en cours 
								$sousmenutroisactif = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = '". $donneesmenu['ID'] ."'   AND  VISIBLE = 4 ORDER BY ORDRE ASC"); 
								while ($donneessousmenutroisparent = $sousmenutroisactif->fetch()) { 
									//echo ' '. $donneessousmenutroisparent['ID']  ;
									$sousmenuquatreactif = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = '". $donneessousmenutroisparent['ID'] ."' AND URL = '". $_SERVER['PHP_SELF'] ."'  AND  VISIBLE = 3 ORDER BY ORDRE ASC"); 
									while ($donneessousmenuquatre = $sousmenuquatreactif->fetch()) {
										if ($donneessousmenuquatre['URL'] == $_SERVER['PHP_SELF']) {
											echo ' active ';
											 
										}
									} 
								}
							echo  '"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$donneesmenu['TITRE'].' <span class="caret"></span></a> ';
							echo '<ul class="dropdown-menu">';
								while ($donneessousmenu = $sousmenu->fetch()) { 
									// On détermine si le lien du Sous-menu de niveau 2 est enfant (active) du menu en cours 
									if ($donneessousmenu['URL'] == $_SERVER['PHP_SELF']) {
										$sousmenuactive = 'active'; 
									} else {
										$sousmenuactive = '';
									} 
									if ($donneessousmenu['VISIBLE'] == '4') {
										// Sous menu de niveau 2 
										echo '<li class="dropdown-header">'.$donneessousmenu['TITRE'].''; 
											$sousmenudeux = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenu['MENU']." AND VISIBLE = 4 ORDER BY ORDRE ASC");
											if ( $sousmenudeux->rowCount() > 0) {
												while ($donneessousmenudeux = $sousmenudeux->fetch()) {
													$sousmenutrois = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenudeux['ID']." AND (VISIBLE = 3 OR VISIBLE = 5) ORDER BY ORDRE ASC");
													while ($donneessousmenutrois = $sousmenutrois->fetch()) {
														if ($donneessousmenu['ID'] == $donneessousmenutrois['MENU'] ) {
															echo "<li class=\"";
															if ($donneessousmenutrois['URL'] == $_SERVER['PHP_SELF']) {
																echo 'active'; 
															} 
															 echo "\"><a href=\"";
																if ($donneessousmenutrois['VISIBLE'] == '5') {
																	echo  $donneessousmenutrois['URL']."\" target=\"_blank\" title=\"Lien externe\""; 
																} else {
																	echo "//". $_SERVER['SERVER_NAME'] . $donneessousmenutrois['URL']."\" title=\"".$donneessousmenutrois['TITRE']."\"";
																};
															echo " >";
																if ($donneessousmenutrois['VISIBLE'] == '5') {
																	echo  '<i class="fa fa-link fa-1x"></i> '; 
																} 
															echo  "└ ".$donneessousmenutrois['TITRE']."</a> ";  
														}
													}
												}
											}  
									} else {
										echo "<li class=\"". $sousmenuactive  ."\"><a href=\"";
											if ($donneessousmenu['VISIBLE'] == '5') {
												echo  $donneessousmenu['URL']."\" target=\"_blank\" title=\"Lien externe\""; 
											} else {
												echo "//". $_SERVER['SERVER_NAME'] . $donneessousmenu['URL']."\" title=\"".$donneessousmenu['TITRE']."\"";
											};
										echo " >";
											if ($donneessousmenu['VISIBLE'] == '5') {
												echo  '<i class="fa fa-link fa-1x"></i> '; 
											} 
										echo  $donneessousmenu['TITRE']."</a> "; 
									}
								}
							echo '</ul>';
						} else {
							echo "<li class=\"". $active  ."\"><a href=\"";
								if ($donneesmenu['VISIBLE'] == '5') {
									echo  $donneesmenu['URL']."\" target=\"_blank\" title=\"Lien externe\""; 
								} else {
									echo "//". $_SERVER['SERVER_NAME'] . $donneesmenu['URL']."\" title=\"".$donneesmenu['TITRE']."\"";
								};
								echo " >";
								if ($donneesmenu['VISIBLE'] == '5') {
									echo  '<i class="fa fa-link fa-1x"></i> '; 
								} 
							echo $donneesmenu['TITRE']."</a></li>";
						}
					}
					if (login_check($bdd) == true) {  ?>
						<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/admin/parametres.php" class="label label-info" style="border-radius: 0;" ><i class="fa fa-cog" style=" "></i></a></li> 
					<?php } ?>
					</ul> 
				</div>
			</div>
		</nav>
	</div> 
</div> 