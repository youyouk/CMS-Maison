<?php
	include_once "../../inc/admin-config.php";
	require_once "../../inc/admin-fonctions.php"; 
	header("Content-type: text/css; charset: UTF-8");
	$couleur_principale = "".parametre(12, $bdd)." !important";
	$couleur_secondaire = "".parametre(13, $bdd)." !important";
	$couleur_background = "".parametre(27, $bdd)." !important";
?>

@media screen and (min-width: 801px) {
	<?php  if (parametre(11, $bdd) != 'NON') { ?>
	#conteneur {
		width: 96%;
		margin: 2% auto;
	}
	<?php } ?>
	.navbar .navbar-nav {
		display: inline-block;
		float: none;
		vertical-align: top;
	} 
	.navbar .navbar-collapse {
		text-align: center;
	}
	.visible-phone{
		display: none!important;
	}
	.navbar-default { 
    border-bottom: none !important;
	}
}
 
@media screen and (max-width: 800px) {
	<?php  if (parametre(11, $bdd) != 'NON') { ?>
	#conteneur {
		width: 100%;
		margin: -15px 0% 5%;
	}
	<?php } else { ?>
	#conteneur {
		width: 92% !important;
		padding: 0 2% 2%;
	}
	<?php } ?>
	img {
		width: auto;
		max-width: 100%;
	}

	h1 {
		font-size: 2.2em;
	}

	img#banniere {
		width: 100%;
		margin:0 auto !important;
	} 
	#logo {
		width: 40%;
		padding: 0% 0% 4% 0%;
		margin: 0;
		position: relative;
	}
	.logoseul img {
		max-width: 80%;
		margin: 0 auto;
	}
	.navbar-default .navbar-nav .open .dropdown-menu > li > a {
		color: white;
	}
	#banniere { 
		width: 97%;
		margin: 0 1.5% 0 1.5%;
		display: block;
	} 
	#sidebar { 
		width: 0%;
		display:none;
	}
	#infos {
		width: 0%;
		display: none;
	} 
	#sous-navigation {
		width: 0%;
		display: none;
	} 
	.log-box {
		display: none !important;
	}
	.log-box-mobile {
		display: block !important;
	} 
	#colonne {
	width: 96%;
	border-left: none;
	} 
	#actualite {
	margin-top: 50px;
	display: inline-block;
	} 
	#information {
		margin-top: 80px;
		display: block;
		width: 202px;
		margin: 0 auto;
		text-align: center;
		float: none;
	} 
	.important.sidebar {
		display: none;
	} 
	#video {
		display: none;
	}
	form label {
		display: inline-block;
	}
	.well {
		width:96%;
	}
	input, textarea, .uneditable-input, select {
		float:right;
	}
	.visible-phone {
		display: inline-block!important;
	}/* Force table to not be like tables anymore */
  #table-responsive table, 
	#table-responsive thead, 
	#table-responsive tbody, 
	#table-responsive th, 
	#table-responsive td, 
	#table-responsive tr {
    display: block;
    border: none !important;
  }

  #table-responsive .cellules {
    display: none;
  }
 
	/* Hide table headers (but not display: none;, for accessibility) */
  #table-responsive thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  #table-responsive tr {
    border: 1px solid #ccc;
  }

  #table-responsive td {
		/* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee;
    position: relative;
    padding-left: 50%;
    white-space: normal;
    text-align: left;
  }

  #table-responsive td:before {
		/* Now like a table header */
    position: absolute;
		/* Top/left values mimic padding */
    top: 6px;
    left: 6px;
    width: 45%;
    padding-right: 10px;
		/* white-space: nowrap; */
    text-align: left;
    font-weight: bold;
    font-size: 0.8em !important;
    font-style: italic;
  }
 
	/*
	Label the data
	*/
  #table-responsive td:before {
    content: attr(data-title);
  }
} 