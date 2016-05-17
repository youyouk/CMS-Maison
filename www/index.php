<?php
include "./html/header.php";

// CAROUSEL ?
if (parametre(29, $bdd) == 'HOME') { 
	if (parametre(30, $bdd) != 'NON') {
		echo '<h2>' . parametre(30, $bdd) . '</h2>';
	} else {
		echo "";
	}
	include "./html/carousel.php";
}

// CONTENU ?
require "./html/content.php";

// VIGNETTES ?
if (parametre(38, $bdd) == 'HOME') { 
	if (parametre(18, $bdd) != 'NON') {
		echo '<h2>' . parametre(18, $bdd) . '</h2>';
	} else {
		echo "";
	}
	include "./html/vignettes.php";
}

include "./html/footer.php";
?>