<?php
include "./html/header.php";
require "./html/content.php"; 
    $r_mini = 3; 
	if (isset($_GET['r'])) { 
		$r = $_GET['r'];
	} else {
		$r = "";
	} 
    if(strlen($r) >= $r_mini) { 
		$requete = "SELECT * FROM SITE_PAGES  WHERE URL NOT LIKE :ERREUR AND VISIBLE > :VISIBLE AND  (TITRE LIKE :QUERY OR CONTENU LIKE :QUERY2 )";	
		$stmt = $bdd->prepare($requete);
		$stmt->execute(array(':ERREUR' => "/erreur-404.php", ':VISIBLE' => $VISIBILITE, ':QUERY' => '%'.$r.'%' , ':QUERY2' =>  '%'.$r.'%'));
		if($stmt->rowCount() > 0 ) { 
				echo "<p>Votre recherche \"".$r."\" :</p>";
				while($donnees = $stmt->fetch()) {
					echo "<a href='".$donnees['URL']."' class='btn btn-block btn-large' style='text-decoration:none;'>".$donnees['TITRE']."</a>"; 
				} 
		} else { 
        echo "<p>Aucun résultat.</p>";
    }
    } else { 
        echo "<p>Votre recherche doit comporter au moins  ".$r_mini. " lettres.</p>";
    }
include "./html/footer.php";
?>