<?php

require '../inc/admin-config.php';
require '../inc/admin-fonctions.php';
include '../admin/html/header.php';
/* echo "<pre>";
print_r($_SESSION);
echo "</pre>"; */
 
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
				<?php
				$menu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = 1 ORDER BY ORDRE ASC"); 
				while ($donneesmenu = $menu->fetch()) { 
					if ($donneesmenu['URL'] == $_SERVER['PHP_SELF']) {
						$active = 'active';
					} else {
						$active = ' ';
					};
					$sousmenu = $bdd->query("SELECT * FROM SITE_PAGES WHERE MENU = ". $donneesmenu['ID']." ORDER BY ORDRE ASC");
					if ( $sousmenu->rowCount() > 0) { 
							echo '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$donneesmenu['TITRE'].' <span class="caret"></span></a>';
							echo '<ul class="dropdown-menu">';
								while ($donneessousmenu = $sousmenu->fetch()) { 
									if ($donneessousmenu['URL'] == $_SERVER['PHP_SELF']) {
										$sousmenuactive = 'active';
									} else {
										$sousmenuactive = ' ';
									};
									echo "<li class=\"". $sousmenuactive  ."\"><a href=\"//". $_SERVER['SERVER_NAME'] . $donneessousmenu['URL']."\">".$donneessousmenu['TITRE']."</a>";
								}
							echo '</ul>';
						} else {
							echo "<li class=\"". $active  ."\"><a href=\"//". $_SERVER['SERVER_NAME'] . $donneesmenu['URL']."\">".$donneesmenu['TITRE']."</a>";
						}
					} 
				?>
				</ul> 
			</div>
		</div>
	</nav>
</div>  
<?php	
	
include '../admin/html/footer.php';
?>