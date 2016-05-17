<?php
ob_start();
include "./html/header.php";
require "./html/content.php";
?>
<?php
$requete = "SELECT * FROM SITE_PAGES WHERE URL = '/actualites.php' AND VISIBLE > :VISIBLE";				
$stmt = $bdd->prepare($requete);
$stmt->execute(array(':VISIBLE' => $VISIBILITE)); 
if ($stmt->rowCount() > 0) { 
	/* Afficher les ACTUALITES */
	$requete = 'SELECT * FROM SITE_ACTUS WHERE VISIBLE > :VISIBLE ORDER BY DATE_CREATION DESC';				
	$stmt = $bdd->prepare($requete);
	$stmt->execute(array(':VISIBLE' => $VISIBILITE));  
	if ($stmt->rowCount() < "1") {
		echo '<p>Il n\'y a aucune actualité publiée pour le moment.</p>';
	} else {
		$i = 1;
		//echo '<hr/><br />';
		//echo '<p>Cliquez-sur les titres pour afficher la suite :</p>';
		echo '<div class="panel-group" id="news">';
		while ($donnees = $stmt->fetch()) {
			echo '
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#news" href="#actu'.$i.'"><small>Actu du '.date('d/m/Y', $donnees['DATE_CREATION']).'</small>';
							if ($donnees['VISIBLE'] == "2") {
								echo ' <small style="color:#3498DB;"><strong>CONTENU EN MODE BROUILLON</strong></small>';
							} 
						echo '<br />'.$donnees['TITRE'].'</a>
					</h4>
				</div>
				<div id="actu'.$i.'" class="panel-collapse collapse '; if ($i == '1') { echo 'in'; } echo'">
					<div class="panel-body">'.$donnees['CONTENU'].'</div>';
						if(login_check($bdd) == true)  { 
							echo '<br /><a href="/admin/actualites.php?ID='.$donnees['ID'].'&action=edit" class="btn btn-large btn-info ">Modifier cette Actu <i class="fa fa-arrow-up fa-1x"></i></a>';
			}
						echo '
				</div>
			</div><br />';
			$i++;
		}
		echo '</div>';			
	}
	if(login_check($bdd) == true)  { 
		echo '<br /><a href="/admin/actualites.php" class="btn btn-large btn-info">Publier une Actu <i class="fa fa-arrow-up fa-1x"></i></a><br />';
	}
	$stmt->closeCursor();
} else {
	/* Afficher la page d'accueil */
	header('Location: index.php');
}
$stmt->closeCursor();

include "./html/footer.php";
?>