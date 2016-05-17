<?php
	/* Affiche le contenu associé à la page */  
	$requete = 'SELECT * FROM SITE_PAGES WHERE URL = :URL AND VISIBLE > :VISIBLE';				
	$stmt = $bdd->prepare($requete);
	$stmt->execute(array(':URL' => $_SERVER['PHP_SELF'],':VISIBLE' => $VISIBILITE)); 
	if ($stmt->rowCount() > 0) {
		while ($donnees = $stmt->fetch()) { 
			echo($donnees['CONTENU']);
				if(login_check($bdd) == true)  { 
					echo '<br /><a href="/admin/pages.php?ID='.$donnees['ID'].'&action=edit" class="btn btn-block btn-large btn-info">Modifier ce contenu <i class="fa fa-arrow-up fa-1x"></i></a><br />';
				}
		}
	}
	$stmt->closeCursor(); 
?>