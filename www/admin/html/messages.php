<?php
// Erreur ?
if (isset($_GET['e'])) {
	echo '<div class="alert alert-danger"><strong>';
		if ($_GET['e'] == "1") {
			echo "Mauvaise combinaison";
		} else if ($_GET['e'] == "2") {
			echo "Merci de remplir tous les champs";
		} else if ($_GET['e'] == "3") {
			echo "Ouverture de session impossible";
		} else if ($_GET['e'] == "4") {
			echo "Connexion bloquée ".  parametre_contenu(2, $bdd)." minutes";
		} else if ($_GET['e'] == "5") {
			echo "Connexion impossible";
		} else if ($_GET['e'] == "6") {
			echo "Vous devez être connecté pour voir ce contenu";
		} else if ($_GET['e'] == "7") {
			echo "Echec de l'ajout de contenu";
		} else if ($_GET['e'] == "8") {
			echo "Echec de la mise à jour";
		} else if ($_GET['e'] == "9") {
			echo "Echec de la suppression";
		} else if ($_GET['e'] == "10") {
			echo "Ce contenu existe déjà (URL)";
		} else if ($_GET['e'] == "11") {
			echo "Echec de la mise à jour du mot de passe";
		} else if ($_GET['e'] == "12") {
			echo "Les mots de passe ne correspondent pas";
		}
	echo ' <i class="fa fa-times fa-1x"></i></strong></div>';
}
// Message ?
if (isset($_GET['m'])) {
	echo '<div class="alert alert-success"><strong>';					
		if ($_GET['m'] == "1") {
			echo "Connexion réussie";
		} else if ($_GET['m'] == "2") {
			echo "Vous êtes déjà connecté";
		} else if ($_GET['m'] == "3") {
			echo "Déconnexion réussie";
		} else if ($_GET['m'] == "4") {
			echo "...";
		} else if ($_GET['m'] == "7") {
			echo "Contenu ajouté";
		} else if ($_GET['m'] == "8") {
			echo "Contenu mis à jour";
		} else if ($_GET['m'] == "9") {
			echo "Contenu supprimé";
		} else if ($_GET['m'] == "10") {
			echo 'Mot de passe mis à jour <a href="./login.php" class=" btn btn-primary">Connexion</a>';
		} else if ($_GET['m'] == "11") {
			echo "Consultez vos emails pour mettre à jour votre mot de passe";
		}
	echo ' <i class="fa fa-check fa-1x"></i></strong></div>';
}
// Erreur création d'utilisateur ?
if (isset($_GET['u'])) {
	echo '<div class="alert alert-danger"><strong>';
		if ($_GET['u'] == "1") {
			echo "Email invalide";
		} else if ($_GET['u'] == "2") {
			echo "Mot de passe invalide";
		} else if ($_GET['u'] == "3") {
			echo "Email déjà associé à un autre utilisateur";
		} else if ($_GET['u'] == "4") {
			echo "Erreur de connexion à la base de données";
		} else if ($_GET['u'] == "5") {
			echo "Erreur";
		} else if ($_GET['u'] == "6") {
			echo "OK";
		} else if ($_GET['u'] == "7") {
			echo "Lien de réinitialisation incorrect";
		} else if ($_GET['u'] == "8") {
			echo "Réinitialisation du mot de passe impossible";
		} else if ($_GET['u'] == "9") {
			echo "Utilisateur inexistant";
		}
	echo ' <i class="fa fa-user-times fa-1x"></i></strong></div>';
} ?>