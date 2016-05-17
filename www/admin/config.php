<?php
require_once "../inc/admin-config.php";
require_once "../inc/motsclefs.php";
if(!isset($_SESSION)) { 
	sec_session_start(); 
}  
if ((login_check($bdd) == true) && ((($_SERVER['PHP_SELF']) == "/admin/login.php") || ((($_SERVER['PHP_SELF']) == "/admin/reinitialiser.php") || (($_SERVER['PHP_SELF']) === "/admin/nouveau-mdp.php")))) {
	// Connexion OK - On masque la page de login
	header("Location: ../admin/index.php?m=2");
} else if ((login_check($bdd) == true) && (($_SERVER['PHP_SELF']) != "/admin/login.php")) { 
	// Connexion OK - Navigation
	ini_set('display_errors', 1); 
	error_reporting(E_ALL);
	$ADMIN = "oui";
	$VISIBILITE = '2';
} else if ((login_check($bdd) == false) && ((($_SERVER['PHP_SELF']) == "/admin/reinitialiser.php") || (($_SERVER['PHP_SELF']) == "/admin/nouveau-mdp.php")) ) {
	// Connexion NON - Page de changement de mot de passe
	//header("Location: ../admin/reinitialiser.php?m=2");
} else if ((login_check($bdd) == false) && (($_SERVER['PHP_SELF']) != "/admin/login.php") && ((($_SERVER['PHP_SELF']) != "/admin/reinitialiser.php") || (($_SERVER['PHP_SELF']) != "/admin/nouveau-mdp.php"))) {
	// Connexion NON - On redirige vers la page Login
	header("Location: ../admin/login.php?e=6");
} 
?>