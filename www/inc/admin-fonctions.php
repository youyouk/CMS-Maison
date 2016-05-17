<?php  
/* Chercher TITRE dans la page consultée */
$titre="";	
$requete = 'SELECT TITRE FROM SITE_PAGES WHERE URL = :URL ';				
$statement = $bdd->prepare($requete);
$statement->execute(array(':URL' => $_SERVER['PHP_SELF']));
while ($donnees = $statement->fetch()) {
	$titre .=  (html_entity_decode($donnees['TITRE']));
}	
$statement->closeCursor();

/* Chercher ID dans la page consultée */
$ID="";	
$requete = 'SELECT ID FROM SITE_PAGES WHERE URL = :URL ';				
$statement = $bdd->prepare($requete);
$statement->execute(array(':URL' => $_SERVER['PHP_SELF']));
while ($donnees = $statement->fetch()) {
	$ID .=  (html_entity_decode($donnees['ID']));
}	
$statement->closeCursor();

/* Chercher TITRE ADMIN dans la page consultée */
$titre_admin="";	
$requete = 'SELECT TITRE FROM ADMIN_PAGES WHERE URL = :URL ';				
$statement = $bdd->prepare($requete);
$statement->execute(array(':URL' => $_SERVER['PHP_SELF']));
while ($donnees = $statement->fetch()) {
	$titre .=  (html_entity_decode($donnees['TITRE']));
}	
$statement->closeCursor();

/* Chercher ID ADMIN dans la page consultée */
$ID_ADMIN="";	
$requete = 'SELECT ID FROM ADMIN_PAGES WHERE URL = :URL ';				
$statement = $bdd->prepare($requete);
$statement->execute(array(':URL' => $_SERVER['PHP_SELF']));
while ($donnees = $statement->fetch()) {
	$ID_ADMIN .=  (html_entity_decode($donnees['ID']));
}	
$statement->closeCursor();

/* Chercher texte récurrent dans la page consultée */
$motsclefs="";	
$x=1;	
$requete = 'SELECT * FROM SITE_PAGES WHERE URL = :URL  ';				
$statement = $bdd->prepare($requete);
$statement->execute(array(':URL' => $_SERVER['PHP_SELF'] ));
while ($donnees = $statement->fetch()) {
	$motsclefs .= ' '. (html_entity_decode($donnees['CONTENU'])).' ';
	$x++;
}	
$statement->closeCursor();

// Fonctions inutilisées

/* Detecter les serveurs de Facebook */
function is_facebook(){
	if(stristr($_SERVER["HTTP_USER_AGENT"],'facebook') == TRUE){
		return true;
	}
}

// Jours en français pour la Météo
function joursFr($str) {
	$a = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	$b = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
	return str_replace($a, $b, $str);
} 
function tempsFr($str) {
	$a = array('chanceflurries', 'chancerain', 'chancesleet', 'chancesnow', 'chancetstorms', 'clear', 'flurries', 'fog', 'hazy', 'mostlycloudy', 'mostlysunny', 'partlycloudy', 'partlysunny', 'sleet', 'rain', 'snow', 'sunny', 'tstorms', 'cloudy');
	$b = array('Risques<br />de neige', 'Risques<br />de pluie', 'Risques<br />de verglas', 'Risques<br />de neige', 'Risques<br />de tempête', 'Temps<br />dégagé', 'Averses<br />de neige', 'Brouillard<br />', 'Brumeux<br />', 'Nuageux<br />', 'Temps<br />clair', 'Partiellement<br />nuageux', 'Partiellement<br />ensoleillé', 'Verglas<br />', 'Pluie<br />', 'Neige<br />', 'Ensoleillé<br />', 'Tempête<br />', 'Couvert<br />');
	return str_replace($a, $b, $str);
} 

/* Rendre du texte PLAIN au kilomètre */
function html2text($Document) {
    $Rules = array ('@<script[^>]*?>.*?</script>@si',
                    '@<[\/\!]*?[^<>]*?>@si',
                    '@([\r\n])[\s]+@',
                    '@&(quot|#34);@i',
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    '@&(iexcl|#161);@i',
                    '@&(cent|#162);@i',
                    '@&(pound|#163);@i',
                    '@&(copy|#169);@i',
                    '@&(reg|#174);@i',
                    '@&#(d+);@e'
             );
    $Replace = array ('',
                      '',
                      '',
                      '',
                      '&',
                      '<',
                      '>',
                      ' ',
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      chr(174),
                      'chr()'
                );
  return preg_replace_callback($Rules, $Replace, $Document);
}

// Surligne les terme d'une recherche dans la page consultée ensuite
function highlight($str) {
	$recherche=trim($_GET['R']);
	if ((strlen($recherche) < 3) || (strpos($_SERVER["PHP_SELF"],"header")!==false)){
		return $str;
	} else {
		$keywords = preg_replace('/\s\s+/', ' ', strip_tags(trim($recherche))); // Filtre
		$var = '';

		/* On applique le Style CSS */
		foreach(explode(' ', $keywords) as $keyword)
		{
		$replacement = "<span class='highlight'>".$keyword."</span>";
		$var .= $replacement." ";
		$str = str_ireplace($keyword, $replacement, $str);
		$strdeux = preg_replace("/($keyword)(?=[^>]*(<|$))/i",$replacement,$str);
		}
		return $str;
	}
}

function dateFR($date) { 
	list($annee, $mois, $jour) =  preg_split('[-]', $date);
	return "$jour/$mois/$annee";
}

// Converti une date au format MySQL 0000-00-00 00:00:00 en format francais JJ/MM/AAAA
function convert_date($date){
	list($date_demande,$heure_demande)=split(" ",$date);
	list($annee,$mois,$jour)=split("-",$date_demande);
	if($jour=="")
		return $date_demande;
	else
		return $jour."/".$mois."/".$annee;
}

function esc_url($url) {
    if ('' == $url) {
        return $url;
    }
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    $url = str_replace(';//', '://', $url);
    $url = htmlentities($url);
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
    if ($url[0] !== '/') { 
        return '';
    } else {
        return $url;
    }
}
?>