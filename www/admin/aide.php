<?php
require '../admin/config.php';
include '../admin/html/header.php';  
?>
<h2>Structure du site</h2>
<p>En fonction des <a href="parametres.php">paramètres</a> activés ou non, la structure du site peut prendre différente formes :<br />
<ul>
<li>Affichage ou non du Menu fixé en haut de l'écran</li>
<li>Logo du Header en pleine largeur ou réduit pour afficher le Carousel ou les Vignettes</li>
<li>Contenu pleine largeur ou réduit avec la sidebar de Menu à gauche</li>
<li>Affichage du Carousel et des Vignettes en Footer, ou uniquement sur la page d'accueil</li>
</ul></p>
<p>Le site affichera systématiquement le Menu en haut en mode Responsive (écrans de moins de 800 pixels de largeur), même si son affichage est désactivé en mode "Normal".</p>

<h2>Paramètres</h2>
<table class="table table-responsive table-striped table-condensed table-hover" style="display: ;">
	<tbody>
	<?php  
	$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE ID = 20 OR ID = 22 OR ID = 29 OR ID = 38   ORDER BY POSITION ASC"); 
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
	$reponse->closeCursor(); 
	?> 
	</tbody>
</table>

<h2>Aperçu des configurations possibles</h2>
<p><img src="../img/CMS-Aide.jpg" alt="" /></p>	 
<?php 
include '../admin/html/footer.php';
?>
