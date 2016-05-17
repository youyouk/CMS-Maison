<?php 
	// Carousel OUI ou NON ?
	if (parametre(29, $bdd) != 'NON') { ?>
	<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="<?php echo parametre(31, $bdd); ?>" id="bs-carousel"> 
		<div class="overlay"></div> 
		<ol class="carousel-indicators" > 
			<?php 
			// Carousel aléatoire ?
			if (parametre(37, $bdd) != 'NON') { 
				$requete = ('SELECT * FROM SITE_CAROUSEL WHERE VISIBLE > :VISIBLE ORDER BY RAND(UNIX_TIMESTAMP(NOW()))');
			} else { 	
				$requete = ('SELECT * FROM SITE_CAROUSEL WHERE VISIBLE > :VISIBLE ORDER BY ORDRE ASC');	
			}  
			$reponse = $bdd->prepare($requete);
			$reponse->execute(array(':VISIBLE' => $VISIBILITE)); 
			$i=0;
			while ($donnees = $reponse->fetch()) {
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
			// Carousel aléatoire ?
			if (parametre(37, $bdd) != 'NON') { 
				$requete = ('SELECT * FROM SITE_CAROUSEL WHERE VISIBLE > :VISIBLE ORDER BY RAND(UNIX_TIMESTAMP(NOW()))');
			} else { 	
				$requete = ('SELECT * FROM SITE_CAROUSEL WHERE VISIBLE > :VISIBLE ORDER BY ORDRE ASC');	
			} 
			$reponse = $bdd->prepare($requete);
			$reponse->execute(array(':VISIBLE' => $VISIBILITE)); 
			
			$i=0;
			while ($donnees = $reponse->fetch()) {
				echo '
				<div class="item slides ';
				if ($i == 0) {
					echo 'active'; };
				echo '">
				  <div class="slide-'. $donnees['ID'].'"></div>';
				  
					// On vérifie que la page associée au lien est Publiée ? 
					$requete = "SELECT * FROM SITE_PAGES  WHERE URL LIKE :LIEN AND VISIBLE > 2";	
					$stmt = $bdd->prepare($requete);
					$stmt->execute(array(':LIEN' => $donnees['URL']));
					if($stmt->rowCount() > 0 ) { 
						if ($donnees['URL'] != "") {
						echo'
							<a href="'. $donnees['URL'] .'" class="toto" style="cursor:pointer;">';
						}
					}
					echo '
						<img id="banniere" src="'. $donnees['IMG'].'" alt="'. $donnees['TITRE'].'" title="'. $donnees['TITRE'].'"';
						
					// On vérifie que la page associée au lien est Publiée ? 
					$requete = "SELECT * FROM SITE_PAGES  WHERE URL LIKE :LIEN AND VISIBLE > 2";	
					$stmt = $bdd->prepare($requete);
					$stmt->execute(array(':LIEN' => $donnees['URL']));
					if (($stmt->rowCount() < 1 ) || ($donnees['URL'] == "")) {
								echo 'style="cursor:default!important;"';
							} 
						echo '/>';
					// On vérifie que la page associée au lien est Publiée ? 
					$requete = "SELECT * FROM SITE_PAGES  WHERE URL LIKE :LIEN AND VISIBLE > 2";	
					$stmt = $bdd->prepare($requete);
					$stmt->execute(array(':LIEN' => $donnees['URL']));
					if($stmt->rowCount() > 0 ) { 
						if ($donnees['URL'] != "") {
							echo '</a>';
						}
					}
					echo ' 
						<div class="carousel-legende"';
						if (parametre(28, $bdd) != 'OUI') {
							echo 'style="display:none;"';
						}
						echo '><h4>';
						if ($donnees['VISIBLE'] == "2") {
							echo '<small><span style=color:#3498DB;">Brouillon</span></small> ';
						}
						echo $donnees['TITRE'].'</h4>
							<span class="description">'. $donnees['CONTENU'].'</span>';
						// On vérifie que la page associée au lien est Publiée ? 
						$requete = "SELECT * FROM SITE_PAGES  WHERE URL LIKE :LIEN AND VISIBLE > 2";	
						$stmt = $bdd->prepare($requete);
						$stmt->execute(array(':LIEN' => $donnees['URL']));
						if($stmt->rowCount() > 0 ) { 
							if ($donnees['URL'] != "") {
								echo '<a class="btn plus-info" alt="En savoir + sur '. $donnees['CONTENU'].'" href="'. $donnees['URL'].'">En savoir +</a>';
							}
						}
						 echo '</div> 
				</div>';
				$i++;
			}
			$reponse->closeCursor();
			?> 
		</div> 
	</div>
	<?php
		if ((login_check($bdd) == true) && ($_SERVER['PHP_SELF'] != '/admin/carousel.php')) { 
			echo '<br /><a href="/admin/carousel.php" class="btn btn-block btn-large btn-info">Modifier le carousel <i class="fa fa-arrow-up fa-1x"></i></a><br />';
		}
	?>
	<br />
<?php } ?>