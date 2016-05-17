<?php 
include_once "../inc/admin-config.php";
require_once "../inc/admin-fonctions.php"; 
if(login_check($bdd) == true)  { 
	$VISIBILITE = "1";
} else {
	$VISIBILITE = "2";
} 
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $titre; ?> - <?php echo parametre(4, $bdd); ?></title>
		<meta name="description" content="<?php echo $titre; ?> du site <?php echo parametre(4, $bdd); ?>"/> 
		<meta name="author" content="Hugo Jousseaume">
		<meta name="robots" content="noindex,nofollow" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/bootstrap.css" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/font-awesome.css" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/css-site.php" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/css-responsive.php" />
		<link type="text/css" rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/css/css-admin.php" />
	</head>
	<body>
		<?php include "./html/menu.php"; ?>
		<div id="conteneur">	
			<div id="colonne">	
				<h1><span><?php echo $titre; ?></span></h1>
				<br />
				<?php include "./html/messages.php"; ?>
				