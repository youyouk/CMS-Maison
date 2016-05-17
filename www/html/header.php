<?php 
include_once "./inc/admin-config.php";
require_once "./inc/admin-fonctions.php";
require_once "./inc/motsclefs.php"; 
error_reporting(E_ERROR | E_PARSE);
sec_session_start();
if(login_check($bdd) == true)  { 
	$VISIBILITE = "1";
} else {
	$VISIBILITE = "2";
} 
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?php echo $titre ; ?> - <?php echo parametre(4, $bdd); ?></title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible"	content="IE=edge">
		<meta name="viewport"				content="width=device-width, initial-scale=1">
		<meta name="description"			content="<?php echo $titre; ?> - <?php echo parametre(4, $bdd); ?>"/>
		<meta name="keywords"				content="<?php echo $keyword->get_keywords(); ?>"/>
		<meta name="author"					content="Youyouk">
		<meta name="robots"					content="index,follow" />
		<meta property="og:url"				content="http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $_SERVER['PHP_SELF']; ?>" />
		<meta property="og:type"			content="website" />
		<meta property="og:title"			content="<?php echo parametre(4, $bdd); ?>" />
		<meta property="og:description"		content="<?php echo $titre; ?>" />
		<meta property="og:image"			content="http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo substr(parametre(8, $bdd),  2); ?>" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/bootstrap.css" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/font-awesome.css" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/css-site.php" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/css-responsive.php" /> 
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/css-special.php" />
		<link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
		<link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" /> 
	</head>
	<body>
	
	<?php if (parametre(9, $bdd) != 'NON') { ?>
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.5&appId=<?php echo $AppFB ; ?>";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script> 
	<?php } ?>
		<?php include "./html/menu.php"; ?>  
		<div id="conteneur">
			<div id="entete" <?php if (parametre(21, $bdd) != 'NON') { ?>style="background: url('<?php echo parametre(22, $bdd);?>') no-repeat center center;background-size:cover;padding:2% 0px 1%;"<?php } ?>>  
			<?php
				// Si la page Extranet n'a pas le statut Publié on masque la pop-up 
				if (page_publiee("extranet", $bdd) != false) {
					if ((parametre(20, $bdd) != 'SIDEBAR') && ($_SERVER['PHP_SELF'] != '/extranet.php')) {
						include "./html/extranet.php"; ?>
					<?php }
					if ($_SERVER['PHP_SELF'] != '/extranet.php') {?>
					<div class="log-box-mobile visible-phone"> 
						<p class="pull-right"><a href="/extranet.php" rel="nofollow" class="" style="display:inline;color:white !important;"><i class="fa fa-user fa-1x" style="vertical-align:middle;color:white !important;"></i>&nbsp;EXTRANET</a></p> 
					</div>
				<?php }
				} ?>
			<?php if ((parametre(29, $bdd) == 'HEADER') || (parametre(38, $bdd) == 'HEADER')) { ?> 
				<div id="logo"><a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>" alt="Logo <?php echo parametre(4, $bdd); ?>" title="Accueil du site <?php echo parametre(4, $bdd); ?>"><img src="<?php echo parametre(8, $bdd); ?>" alt="<?php echo parametre(4, $bdd); ?> - <?php echo parametre(7, $bdd); ?>" /></a></div> 
				<div id="banniere">
				<?php
					// Carousel HEADER ?
					if (parametre(29, $bdd) == 'HEADER') { 
						if (parametre(30, $bdd) != 'NON') {
							echo '<h2>' . parametre(30, $bdd) . '</h2>';
						} else {
							echo "";
						}
						include "./html/carousel.php"; 
					}
					// Vignettes HEADER ?
					if ((parametre(38, $bdd) == 'HEADER') && ($_SERVER['PHP_SELF'] != '/index.php')) { 
						if (parametre(18, $bdd) != 'NON') {
						
							echo '<h2>' . parametre(18, $bdd) . '</h2>';
						} else {
							echo "";
						}
						include "./html/vignettes.php"; 
					}
				?>
				</div>
			<?php } else { ?>
				<div class="logoseul"> 
					<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>" alt="Logo <?php echo parametre(4, $bdd); ?>" title="Accueil du site <?php echo parametre(4, $bdd); ?>"><img src="<?php echo parametre(8, $bdd); ?>" alt="<?php echo parametre(4, $bdd); ?> - <?php echo parametre(7, $bdd); ?>" style="<?php if ($_SERVER['PHP_SELF'] == "/index.php") { ?>max-height:200px;padding: 3% 0;<?php } else { ?>max-height:120px;padding: 2% 0;<?php } ?>"/></a></div>
			<?php } ?>
			</div> 
			<?php if ((parametre(20, $bdd) == 'SIDEBAR') || ((parametre(20, $bdd) == 'SIDEBAR') && (parametre(39, $bdd) != 'NON')) || ((parametre(20, $bdd) == 'SIDEBAR') && (parametre(40, $bdd) != 'NON') && ($_SERVER['PHP_SELF'] != '/actualites.php'))) { ?>
				<div id="sidebar">
					<?php
						if (login_check($bdd) == true) {
							echo "<br /><p style=\"line-height:1.2em;width: 90% !important;\"><a href=\"//". $_SERVER['SERVER_NAME']."/admin/parametres.php\" class=\"btn btn-info\" style=\"border-radius: 0;\" ><i class=\"fa fa-cog\" style=\" \"></i> ADMIN</a></p>";
						}
						// Vidéo uniquement si sidebar
						if ((parametre(20, $bdd) == 'SIDEBAR') && (parametre(39, $bdd) != 'NON')) { ?>
							<div id="video" style="width: 95%;">
								<!--<h4 style="color:white;border-bottom:3px dotted white">&nbsp;</h4>-->
								<br />
								<iframe width="280" height="157" src="https://www.youtube.com/embed/<?php echo parametre(39, $bdd); ?>?rel=0&amp;showinfo=0<?php if (parametre(41, $bdd) != 'NON') { echo ";autoplay=1";} ?>" frameborder="0" allowfullscreen></iframe>
							</div><br />
						<?php }
						// Actus uniquement si sidebar ET si page actualites.php est Publiée
						if (page_publiee("actualites", $bdd) != false) {
							if ((parametre(20, $bdd) == 'SIDEBAR') && (parametre(40, $bdd) != 'NON') && ($_SERVER['PHP_SELF'] != '/actualites.php')) { 
								// Uniquement Actus Publiées ET depuis moins de 45 jours
								$requetebis = 'SELECT * FROM SITE_ACTUS WHERE VISIBLE > :VISIBLE AND DATE_CREATION >= (UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 45 day))) ORDER BY DATE_CREATION DESC LIMIT 1';
								$stmtbis = $bdd->prepare($requetebis);
								$stmtbis->execute(array(':VISIBLE' => $VISIBILITE));
								if ($stmtbis->rowCount() > 0) { ?>
									<h4 style="color:white;border-bottom:3px dotted white">Actu récente</h4> 
									<div id="news" style="width: 95%;">
										<?php
										/* Afficher les ACTUS */
										while ($donnees = $stmtbis->fetch()) { 
											echo '<small>Actu du '.date('d/m/Y', $donnees['DATE_CREATION']).'</small>';
												if ($donnees['VISIBLE'] == "2") {
													echo ' <small style="color:#3498DB;"><strong>BROUILLON</strong></small>';
												} 
											echo '<br /><span style="margin-right:2px;border-left:2px solid '. parametre(12, $bdd).';display: block;"><strong style="display:block; margin-left:5px;">'.$donnees['TITRE'].'</strong></span><br /><a href="./actualites.php" class="btn plus-info" style="width:95%;" title="Lire la suite">En savoir +</a> 
											<br /><br />';
										}
										$stmtbis->closeCursor();
										?> 
									</div>
							<?php }
							} 
						} 
						
						// Extranet Sidebar ?
						if (page_publiee("extranet", $bdd) != false) {
							if ($_SERVER['PHP_SELF'] != '/extranet.php') {
								include "./html/extranet.php"; 
							}
						}
						
						// Menu Sidebar ?
						if (parametre(20, $bdd) == 'SIDEBAR') {
							include "./html/sidebar.php";
						}
					?>
				</div>
			<?php }?>  
			<div id="colonne" <?php if ((parametre(20, $bdd) ) != 'SIDEBAR') { ?>class="pleinelargeur"<?php }?>"> 
				<?php
					/* Affiche le titre de la page */ 
					$query = 'SELECT * FROM SITE_PAGES WHERE URL = :URL AND VISIBLE > :VISIBLE';				
					$stmt = $bdd->prepare($query);
					$stmt->execute(array(':URL' => $_SERVER['PHP_SELF'], ':VISIBLE' => $VISIBILITE));
					$donnees = $stmt->fetch();
					if ($_SERVER['PHP_SELF'] == '/index.php') {
						//echo '<h4 style="margin-bottom: -20px;margin-top: 5px;color:'.parametre(12, $bdd).'">'.parametre(4, $bdd).'</h4>';
						echo "<h1><span>";
						echo parametre(7, $bdd);
						echo "</span></h1>";
					} else {
						echo "<h1><span>";
						echo $donnees['TITRE'];
						echo "</span></h1>";
					}
				?>