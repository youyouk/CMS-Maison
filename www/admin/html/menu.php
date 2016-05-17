<?php 
require './config.php';
?>
<div class="nav" style="margin-bottom: 60px;">
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Menu</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button> 
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav"> 
						<?php if (login_check($bdd) === true) :  ?>
						<li class="<?php if ($ID_ADMIN == '1') echo "active";?>"><a href="index.php"><i class="fa fa-home fa-1x"></i></a></li> 
						<li class="<?php if ($ID_ADMIN == '2') echo "active";?>"><a href="actualites.php">Actus</a></li>						
						<li class="<?php if ($ID_ADMIN == '3') echo "active";?>"><a href="pages.php">Pages</a></li>
						<li class="<?php if ($ID_ADMIN == '5') echo "active";?>"><a href="messages.php">Messages</a></li>
						<li class="<?php if ($ID_ADMIN == '13') echo "active";?>"><a href="menus.php">Menu</a></li>
						<li class="<?php if ($ID_ADMIN == '15') echo "active";?>"><a href="carousel.php">Carousel</a></li>
						<li class="<?php if ($ID_ADMIN == '14') echo "active";?>"><a href="vignettes.php">Vignettes</a></li>
						<li class="<?php if ($ID_ADMIN == '11') echo "active";?>"><a href="parametres.php">Paramètres</a></li>
						<li class="dropdown <?php if (($ID_ADMIN == '4') || ($ID_ADMIN == '8') || ($ID_ADMIN == '9') || ($ID_ADMIN == '10') || ($ID_ADMIN == '18') || ($ID_ADMIN == '19') /* || ($ID_ADMIN == '11') */ || ($ID_ADMIN == '12')) { echo 'active';} ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Maintenance <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<!--<li class="<?php if ($ID_ADMIN == '11') echo "active";?>"><a href="parametres.php"><i class="fa fa-cog fa-1x"></i> Paramètres</a></li>-->
							<li class="<?php if ($ID_ADMIN == '18') echo "active";?>"><a href="aide.php">Aide</a></li>
							<li class="<?php if ($ID_ADMIN == '19') echo "active";?>"><a href="fichiers.php">Fichiers</a></li>
							<li class="<?php if ($ID_ADMIN == '8') echo "active";?>"><a href="logs.php">Logs</a></li>
							<li class="<?php if ($ID_ADMIN == '4') echo "active";?>"><a href="backup.php">Sauvegardes</a></li>
							<!--<li class="<?php if ($ID_ADMIN == '10') echo "active";?>"><a href="statistiques.php">Statistiques</a></li>-->
							<li class="<?php if ($ID_ADMIN == '12') echo "active";?>"><a href="sitemap.php">Sitemap</a></li>
							<li class="<?php if ($ID_ADMIN == '9') echo "active";?>"><a href="utilisateurs.php">Utilisateurs</a></li>
						</ul>
						</li> 
						<li><a href="../"><i class="fa fa-eye fa-1x"></i></a></li> 
						<li><a href="../inc/admin-logout.php"><i class="fa fa-sign-out fa-1x"></i></a></li>
					<?php else : ?>
						<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/">Retourner sur le site <?php echo parametre(4, $bdd); ?></a></li> 
					<?php endif; ?>
				</ul> 
			</div>
		</div>
	</nav>
</div>