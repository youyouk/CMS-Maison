<?php 
	// Vignettes OUI ou NON ?
	if (parametre(38, $bdd) != 'NON') { ?>
	<p><ul class="produits">
		<?php 
		// Vignettes aléatoires ?
		if (parametre(36, $bdd) != 'NON') { 
			$requete = ('SELECT * FROM SITE_VIGNETTES WHERE VISIBLE > :VISIBLE ORDER BY RAND(UNIX_TIMESTAMP(NOW()))');
		} else { 	
			$requete = ('SELECT * FROM SITE_VIGNETTES WHERE VISIBLE > :VISIBLE ORDER BY ORDRE ASC');	
		} 
		$reponse = $bdd->prepare($requete);
		$reponse->execute(array(':VISIBLE' => $VISIBILITE)); 
		while ($donnees = $reponse->fetch()) {
			/* if ((login_check($bdd) == true) && ($_SERVER['PHP_SELF'] == '/admin/vignettes.php')) {
				 echo '<pre>'.print_r($donnees,true).'</pre>';
			} */
			echo '<li><a href="#lien'. $donnees['ID'].'" class="thumbnail" style="background-image: url(\''. $donnees['IMG'].'\')"><h4>';
			if ($donnees['VISIBLE'] == "2") {
				echo '<span style=color:#3498DB;">Brouillon</span> ';
			}
			echo $donnees['CATEGORIE'] . '</h4><span class="description">'. $donnees['TITRE'].'</span></a></li>';
		}
			$reponse->closeCursor();
		?>
	</ul></p>
	<div class="portfolio-content">
		<?php 
		$requete = ('SELECT * FROM SITE_VIGNETTES WHERE VISIBLE > :VISIBLE ORDER BY ORDRE ASC');
		$reponse = $bdd->prepare($requete);
		$reponse->execute(array(':VISIBLE' => $VISIBILITE)); 
		while ($donnees = $reponse->fetch()) {
			echo '
				<div id="lien'. $donnees['ID'].'"> ';
				if ($donnees['URL'] != "") {
					echo '<div class="link"><a href="'. $donnees['URL'].'" class="btn btn-info btn-large" style="color:white;">EN SAVOIR +</a></div>';
				}
			echo   '<h2>'. $donnees['TITRE'].'</h2>
					<p>'. $donnees['CONTENU'].'</p>
				</div>';
		}
		$reponse->closeCursor();
		?>
	</div> 
	<?php
		if ((login_check($bdd) == true) && ($_SERVER['PHP_SELF'] != '/admin/vignettes.php')) { 
			echo '<br /><a href="/admin/vignettes.php" class="btn btn-block btn-large btn-info">Modifier les vignettes <i class="fa fa-arrow-up fa-1x"></i></a><br />';
		} ?>
	<br />
<?php } ?>