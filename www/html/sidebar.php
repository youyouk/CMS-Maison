<p><h4 style="color:white;border-bottom:3px dotted white">Menu</h4><ul style="padding: 0;list-style: none;"> 
<?php
if (parametre(34, $bdd) != 'NON') {
	if ((parametre(35, $bdd) == 'OUI') || (parametre(35, $bdd) == 'NON') && (($_SERVER['PHP_SELF'] != '/index.php'))) {
		echo '<li  style="line-height:1.5em;"><a '; if ($_SERVER['PHP_SELF'] == '/index.php') { echo 'class="active"'; } echo ' style="display:inline-block;margin-left:-5px;padding:2px 5px;" href="/">Accueil</a></li>';
	}
}
$menu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = 1 AND VISIBLE > 2 ORDER BY ORDRE ASC"); 
while ($donneesmenu = $menu->fetch()) {
	$sousmenu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneesmenu['ID']." AND VISIBLE > 2 ORDER BY ORDRE ASC");
	if ( $sousmenu->rowCount() > 0) { 
			echo '<li style="line-height:1.5em;"><h2>'.$donneesmenu['TITRE'].'</h2>';
			echo '<br />';
				while ($donneessousmenu = $sousmenu->fetch()) { 
					if ($donneessousmenu['VISIBLE'] == '4') {
						// Sous menu Niveau 2
						echo '<ul><li style="font-size: 1em; margin-left: -37px;"><h4>'.$donneessousmenu['TITRE'].'</h4>';
						$sousmenudeux = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenu['MENU']." AND VISIBLE = 4 ORDER BY ORDRE ASC");
						if ( $sousmenudeux->rowCount() > 0) {
							while ($donneessousmenudeux = $sousmenudeux->fetch()) {
								$sousmenutrois = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneessousmenudeux['ID']." AND (VISIBLE = 3 OR VISIBLE = 5) ORDER BY ORDRE ASC");
								while ($donneessousmenutrois = $sousmenutrois->fetch()) {
									echo "<ul>";
									if ($donneessousmenu['ID'] == $donneessousmenutrois['MENU'] ) {
										echo "<li style=\"font-size: 1em;list-style: none;margin-left: -30px;\"><a "; 
											if ($donneessousmenutrois['URL'] == $_SERVER['PHP_SELF']) {
												echo ' class ="active" ';
											}
											echo "href=\"";
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
										// Sous menu Niveau 3
										echo $donneessousmenutrois['TITRE']."</a></li>"; 
									}
									echo "</ul>";
								}
							}
						}
						echo "</li></ul>"; 
				} else {
					echo "<ul><li style=\"font-size: 1em;list-style: none;margin-left: -20px;\"><a"; 
					if ($donneessousmenu['URL'] == $_SERVER['PHP_SELF']) {
						echo ' class ="active" ';
					}
					echo " href=\"";
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
			echo '';
		} else {
			echo "<li style=\"line-height:1.2em; \"><a";
			if ($donneesmenu['URL'] == $_SERVER['PHP_SELF']) {
				echo ' class ="active" '; 
			}
			echo " style=\"display:inline-block;margin-left:-5px;padding: 5px;\" href=\"//". $_SERVER['SERVER_NAME'] . $donneesmenu['URL']."\">".$donneesmenu['TITRE']."</a></li>";
		}
	} ?> 
</ul></p>