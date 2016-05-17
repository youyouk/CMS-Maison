<?php
	include_once "../../inc/admin-config.php";
	require_once "../../inc/admin-fonctions.php"; 
	header("Content-type: text/css; charset: UTF-8");
	$couleur_principale = "".parametre(12, $bdd)." !important";
	$couleur_secondaire = "".parametre(13, $bdd)." !important";
?>


/* .mce-textbox, .mce-abs-layout-item {
	border-right: 1px solid #c5c5c5;
}

#mceu_25, .mce-panel, .mce-container { 
    border: 1px solid #F5F5F5!important;
    background-color: #F0F0F0;!important;
    border-radius: 4px!important;
} 
 */ 
 #sidebar { 
    width: 0%!important;
    display:none !important;
  } 
  #colonne {
    width: 96%!important;
    border-left-width: 0px!important;
  }