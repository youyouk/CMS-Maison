<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);

/* Paramètres BDD à modifier : */
define('BDD_HOST', '******************');
define('BDD_USER', '******************');
define('BDD_PASS', '******************');
define('BDD_NAME', '******************'); 

/* Paramètrage particulier des fichiers du dossier Admin/Backup :

/cron.php 							-> Ligne 27 : http://www.URL-DE-VOTRE-SITE.fr 
/api/class/MysqlDump				-> Ligne 25 : Nom de la base de données
/api/component/common.php			-> Ligne 261 : Nom de la base de données
/gui/viewmodels/DatabaseSettings.js -> Lignes 7/11 : Paramètres BDD

App Facebook (Partages et J'aime) */
$AppFB = "xxxxxxxxxxxxxxx";
	
/* On ne touche plus à rien ;) */	
try {
	$bdd = new PDO('mysql:host='. BDD_HOST .';dbname='. BDD_NAME . ';charset=utf8', BDD_USER, BDD_PASS);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
}

$_TITRE_GENERAL = parametre_contenu(4, $bdd);
$MAIL_DESTINATAIRE = parametre_contenu(1, $bdd);
$url = $_SERVER['PHP_SELF'];

function sec_session_start() {
    $session_name = 'sec_session_id';
    $secure = false;
    $httponly = true;
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../admin/login.php?e=3");
        exit();
    }
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
	session_name($session_name);
	if (session_status() == PHP_SESSION_NONE) {
		session_start();   
	}
	session_regenerate_id();  
}

function login($EMAIL, $MDP, $IP, $bdd) { 
		$now = time();
	if (checkbrute($EMAIL, $bdd) != true) { 
		$stmt = $bdd->prepare("SELECT * FROM ADMIN_UTILISATEURS WHERE EMAIL = :EMAIL");  
		$stmt->execute(array(':EMAIL' => $EMAIL));  
		if ($stmt->rowCount() == 1) { 
			$donnees = $stmt->fetch();
			$SEL= $donnees['SEL'];
			$MDP_HASH = hash('sha512', $MDP . $donnees['SEL']);   
				if ($donnees['MDP'] != $MDP_HASH) {
					// Mauvais MDP 
					$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '3', '$IP')");
					// DEBUG URL header("Location: ../admin/login.php?e=1&MDPDD=".$donnees['MDP']."&MPHASH=".$MDP_HASH."&MDP=".$MDP."&SEL=".$donnees['SEL']); 
					header("Location: ../admin/login.php?e=1"); 
					return false;
				} else {
					// OK
					$ID = preg_replace("/[^0-9]+/", "", $donnees['ID']);
					$NOM = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $donnees['NOM']);
					$NAVIGATEUR = $_SERVER['HTTP_USER_AGENT'];
					$_SESSION['ID'] = $ID;
					$_SESSION['NOM'] = $NOM;
					$_SESSION['IP'] = $IP;
					$_SESSION['login_string'] = hash('sha512', $donnees['MDP'] . $NAVIGATEUR);
					$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '9', '$IP')");
					header("Location: ../admin/login.php?m=1");
					return true;
				} 
		} else { 
			// Utilisateur inconnu  
			$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '1', '$IP')");
			header("Location: ../admin/login.php?e=5");
			return false;
		}  
	} else  {
		// Bruteforce
		$bdd->query("INSERT INTO ADMIN_LOGS(EMAIL, DATE, OK, IP) VALUES ('$EMAIL', '$now', '7', '$IP')");
		header("Location: ../admin/login.php?e=4");
		return false;
	} 
}

function checkbrute($EMAIL, $bdd) { 
	$now = time(); 
	$TENTATIVES = parametre_contenu(3, $bdd);						// Nombre d'essais avant blocage
	$DUREE_TENTATIVES = $now - (parametre_contenu(32, $bdd) * 60);	// Minutes pour comptabiliser les tentatives échouées
	$DUREE_BLOCAGE = $now - (parametre_contenu(2, $bdd) * 60);		// xx dernières minutes 
	$stmt = $bdd->prepare("SELECT DATE FROM ADMIN_LOGS WHERE EMAIL = :EMAIL AND ( DATE > :DUREE_BLOCAGE OR DATE > :DUREE_TENTATIVES) AND OK < 5 ");
	$stmt->execute(array(':EMAIL' => $EMAIL, ':DUREE_BLOCAGE' => $DUREE_BLOCAGE, ':DUREE_TENTATIVES' => $DUREE_TENTATIVES)); 
	if ($stmt->rowCount() < $TENTATIVES ) {
		return false;
	} else {
		return true;
	} 
}

function login_check($bdd) { 
    $now = time();
    if (isset($_SESSION['ID'], $_SESSION['NOM'], $_SESSION['IP'], $_SESSION['login_string'])) {
        $ID = $_SESSION['ID'];
        $NOM = $_SESSION['NOM'];
        $login_string = $_SESSION['login_string'];
        $NAVIGATEUR = $_SERVER['HTTP_USER_AGENT']; 
        if ($stmt = $bdd->prepare("SELECT MDP FROM ADMIN_UTILISATEURS WHERE ID = :ID LIMIT 1")) {  
            $stmt->execute(array(':ID' => $ID)); 
            if ($stmt->rowCount() == 1) {  
				$donnees = $stmt->fetch();
				$MDP= $donnees['MDP'];
                $login_check = hash('sha512', $donnees['MDP'] . $NAVIGATEUR); 
                if ($login_check == $login_string) { 
					//header("Location: ../admin/login.php?m=3"); 
					return true;
                } else { 
                    return false;
					//header("Location: ../admin/login.php?m=33");
                }
            } else {
                return false;
				//header("Location: ../admin/login.php?m=55");
            }
        } else { 
            return false;
			//header("Location: ../admin/login.php?m=66");
        }
    } else { 
        return false;
		//header("Location: ../admin/login.php?m=77");
    }
}

function parametre_contenu($ID, $bdd) {
	$requete = 'SELECT * FROM ADMIN_PARAMETRES WHERE ID = :ID';
	$stmt= $bdd->prepare($requete);
	if($stmt->execute(array(':ID' => $ID))) {
		while ($parametre = $stmt->fetch()) {
			return $parametre['CONTENU'];
		}
	}	
}
function parametre($ID, $bdd) {
	$requete = 'SELECT * FROM ADMIN_PARAMETRES WHERE ID = :ID';
	$stmt= $bdd->prepare($requete);
	if($stmt->execute(array(':ID' => $ID))) {
		while ($parametre = $stmt->fetch()) {
			return $parametre['CONTENU'];
		}
	}	
}

/* Page publiée ? */
function page_publiee($URL, $bdd) {
	$requete = "SELECT * FROM SITE_PAGES  WHERE URL LIKE :RECHERCHE AND VISIBLE > 2";	
	$stmt = $bdd->prepare($requete);
	$stmt->execute(array(':RECHERCHE' => "/".$URL.".php"));
	if($stmt->rowCount() > 0 ) {
		return true;
	} else {
		return false;
	}
}