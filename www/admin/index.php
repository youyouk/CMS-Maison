<?php
require '../admin/config.php';
include '../admin/html/header.php';
?> 
<h2>Contenus</h2> 
<p>Les visiteurs du site ne voient que le contenu ayant le statut "<span style="color:#47A447;"><strong>Publié</strong></span>". Le mode "<span style="color:#3498DB;"><strong>Brouillon</strong></span>" vous permet de rédiger vos articles et contenus sans que les internautes ne puissent les voir.</p>
<br />
<table class="table table-responsive table-striped" style="text-align:center;">
	<thead>
		<tr>
			<th style="text-align:center;">Actualités</th> 
			<th style="text-align:center;">Pages</th> 
			<th style="text-align:center;">Messages</th> 
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php /* Afficher les ACTUALITES */
				if (page_publiee("actualites", $bdd) != false) {
					$reponse = $bdd->query('SELECT * FROM SITE_ACTUS WHERE VISIBLE  = "3"');
					$nombre = $reponse->rowCount();
					if ($nombre > 1) {
						echo('Il y a <span style="color:#47A447;"><strong>'.$nombre.' actualités publiées</strong></span>.');
					} else if ($nombre == 1) {
						echo('Il y a <span style="color:#47A447;"><strong>1 actualité publiée</strong></span>.');
					} else {
						echo('Aucune actualité publiée.');
					}
					$reponse->closeCursor();
				} else {
					echo 'Page Actus <strong><a href="pages.php?ID=2&action=edit">inactive</a></strong>.';
				} ?></td>
			<td><?php /* Afficher les PAGES */
				$reponse = $bdd->query('SELECT * FROM SITE_PAGES WHERE VISIBLE  = "3"');
				$nombre = $reponse->rowCount();
				print('Il y a <span style="color:#47A447;"><strong>'.$nombre.' pages en ligne</strong></span>.');
				$reponse->closeCursor(); ?></td> 
			<td><?php if (page_publiee("contact", $bdd) != false) {
					/* Afficher les MESSAGES */
					$reponse = $bdd->query('SELECT * FROM ADMIN_MESSAGES ');
					$nombre = $reponse->rowCount();
					if ($nombre > 1) {
						echo('Il y a <span style="color:#47A447;"><strong>'.$nombre.' messages enregistrés</strong></span>.');
					} else if ($nombre == 1) {
						echo('Il y a <span style="color:#47A447;"><strong>1 message enregistré</strong></span>.');
					} else {
						echo('Aucun message.');
					}
					$reponse->closeCursor(); ?>
				<?php } else { 
					echo 'Page Contact <strong><a href="pages.php?ID=6&action=edit">inactive</a></strong>.';} ?>
				</td> 
		</tr>
		<tr>
			<td>
			<?php if (page_publiee("actualites", $bdd) != false) { ?>
				<a href="actualites.php?action=nouveau" class=" btn btn-info" ><i class="fa fa-plus fa-1x"></i></a> <a href="actualites.php" class=" btn btn-success" ><i class="fa fa-edit fa-1x"></i></a>
			<?php } ?></td>
			<td><a href="pages.php?action=nouveau" class=" btn btn-info" ><i class="fa fa-plus fa-1x"></i></a> <a href="pages.php" class=" btn btn-success" ><i class="fa fa-edit fa-1x"></i></a></td>
			<?php if (page_publiee("contact", $bdd) != false) { ?>
				<td><a href="messages.php" class=" btn btn-success" ><i class="fa fa-edit fa-1x"></i></a></td>
			<?php } ?>
		</tr>
  </tbody>
</table>
 
<h2>Carousel</h2>  
<p>Les bannières défilantes <?php if (parametre(30, $bdd) != 'NON') { echo '"<strong>' . parametre(30, $bdd) .'</strong>"'; } ?> sont <strong><?php if (parametre(29, $bdd) != 'NON') { echo 'activées'; } else { echo 'désactivées';} ?></strong>. Elles s'affichent <?php if (parametre(29, $bdd) != 'NON') {  if (parametre(29, $bdd) == 'HOME') { echo '<strong>en haut de la page d\'accueil</strong>'; } else if (parametre(29, $bdd) == 'HEADER') { echo '<strong>dans le header</strong> sur toutes les pages autres que la page d\'accueil'; } else if (parametre(29, $bdd) == 'FOOTER') { echo '<strong>dans le footer</strong> sur toutes les pages autres que la page d\'accueil'; } } ?> (<a href="carousel.php">modifier</a>).</p>

<br />

<h2>Vignettes</h2>
<p>L'affichage des vignettes <?php if (parametre(18, $bdd) != 'NON') { echo '"<strong>' . parametre(18, $bdd) .'</strong>"'; } ?> est <strong><?php if (parametre(38, $bdd) != 'NON') { echo 'activé'; } else { echo 'désactivé';} ?></strong> <?php if (parametre(38, $bdd) != 'NON') {  if (parametre(38, $bdd) == 'HOME') { echo '. Elles s\'affichent <strong>sur la page d\'accueil</strong>'; } else if (parametre(38, $bdd) == 'HEADER') { echo '. Elles s\'affichent <strong>dans le header</strong> sur toutes les pages autres que la page d\'accueil'; } else if (parametre(38, $bdd) == 'FOOTER') { echo '. Elles s\'affichent <strong>dans le footer</strong> sur toutes les pages autres que la page d\'accueil'; } } ?> (<a href="vignettes.php">modifier</a>).</p>

<?php include'../admin/html/footer.php'; ?>