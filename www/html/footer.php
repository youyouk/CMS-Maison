			<?php
			// J'aime facebook sur les pages
			if (parametre(10, $bdd) != 'NON') {
				// Uniquement sur les pages de contenu 
				if (($_SERVER['PHP_SELF'] != '/extranet.php') && ($_SERVER['PHP_SELF'] != '/erreur-404.php') && ($_SERVER['PHP_SELF'] != '/recherche.php') && ($_SERVER['PHP_SELF'] != '/contact.php') && ($_SERVER['PHP_SELF'] != '/mentions-legales.php')) { ?>
					<p id="clear">&nbsp;</p>
					<div class="fb-like pull-right" style="text-align:center !important;" data-href="<?php echo parametre(6, $bdd); ?><?php echo $_SERVER['PHP_SELF']; ?>" data-layout="standard" data-action="like" data-show-faces="true"></div> <?php 
				}
			}
			// Carousel FOOTER ?
			if ((parametre(29, $bdd) == 'FOOTER') && ($_SERVER['PHP_SELF'] != '/index.php')) {
				echo '</div><div id="footercarousel">';
				if (parametre(30, $bdd) != 'NON') {
					echo '<h2>' . parametre(30, $bdd) . '</h2>';
				} else {
					echo "<br />";
				}
				include "./html/carousel.php"; 
			}
			// Vignettes FOOTER ?
			if ((parametre(38, $bdd) == 'FOOTER') && ($_SERVER['PHP_SELF'] != '/index.php')) {
				echo '</div><div id="footercarousel">';
				if (parametre(18, $bdd) != 'NON') {
					echo '<h2>' . parametre(18, $bdd) . '</h2>';
				} else {
					echo "<br />";
				}
				include "./html/vignettes.php"; 
			} ?>
			
			</div><!-- COLONNE -->

			<!-- <p id="clear">&nbsp;</p>-->
			
			<div id="prefooter"> 
			<?php
				// Vidéo uniquement si sidebar désactivée
				if ((parametre(20, $bdd) != 'SIDEBAR') && (parametre(39, $bdd) != 'NON')) { ?>
				<iframe width="280" height="157" src="https://www.youtube.com/embed/<?php echo parametre(39, $bdd); ?>?rel=0&amp;showinfo=0<?php if (parametre(41, $bdd) != 'NON') { echo ";autoplay=1";} ?>" frameborder="0" allowfullscreen></iframe>
				
			<?php } 
				if (page_publiee("recherche", $bdd) != false) { ?>
				<br />
				<h4>Rechercher sur le site</h4>
				<div style="display: inline-block;margin:10px auto;">
					<form action="recherche.php" method="get">
						<input type="text" name="r" id="r" style="width:120px!important;" value="" placeholder="<?php if (isset($_GET['r'])) { echo $_GET['r']; } else { echo 'Rechercher' ; } ?>" action="recherche.php">
						<input type="submit" class="btn" style="width: 50px !important;" value="Ok">
					</form>
				<br />
				</div>
					<?php if (parametre(9, $bdd) != 'NON') { ?>
					<hr />
					<?php }?> 
				<?php }?>
				<?php if (parametre(9, $bdd) != 'NON') { ?>
				<br />
					<div class="fb-page" data-href="https://www.facebook.com/<?php echo parametre(9, $bdd); ?>" data-tabs=" " data-small-header="false" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="false">
					<div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/<?php echo parametre(9, $bdd); ?>"><a href="https://www.facebook.com/<?php echo parametre(9, $bdd); ?>">Suivez-nous sur Facebook !</a></blockquote></div></div> 
				<br />
				<?php }?>  
			</div>
			
		</div><!-- CONTENEUR -->
		
		<div id="infofooter" style="text-align:center;font-size:1em;">
			<p style="display:none;"><a href="../mentions-legales.php">Mentions légales</a></p>
			<p><label><?php echo parametre(4, $bdd); ?> : <?php echo parametre(7, $bdd); ?><br /> 
				<?php if (parametre(16, $bdd) != 'NON') { ?> 
					<i class="fa fa-info-circle fa-1x"></i> <?php echo parametre(16, $bdd); ?> 
				<?php }?>
				<?php if (parametre(15, $bdd) != 'NON') { ?>
					<i class="fa fa-phone fa-1x" title="Téléphone de <?php echo parametre(4, $bdd); ?>"></i> Appelez-nous au <?php echo parametre(15, $bdd); ?>
				<?php }?>
			</label></p>
			<p>&nbsp;</p>
		</div>
		
		<?php	if (page_publiee("contact", $bdd) != false) {
					if ($_SERVER['PHP_SELF'] != '/contact.php') {	?>
		<div id="footer">
			<div id="pied">
				<span><a href="./contact.php" title="Contact"><i class="fa fa-envelope"></i>&nbsp;Nous contacter</a></span>
			</div>
		</div>
		<?php } 
		} ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/bootstrap.min.js" /></script> 
		<script src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/admin.js" /></script>
		<script src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/masonry.js" /></script>
		<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
		<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
		<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
		<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script> 
		<script type="text/javascript">
		$(document).ready(function() {
			$('.produits').portfolio({
				cols: 3,
				transition: 'fadeIn'
			});
			$(".fancybox").fancybox();
			<?php if (parametre(24, $bdd) != 'NON') { ?>
			$("#colonne img").on("click", function(){
			<?php } else { ?>
			$(".zoom").on("click", function(){ 
			<?php } ?>
				$.fancybox($(this).attr("src"),{ 
					padding : 0,
					arrows : true
				});
			}); 
			
			// Ajout de la classe active sur le bouton de niveau 1 en cas de page sous menu de niveau 3 active 
			if( $('#sousmenu li').hasClass('active') ) {
				//console.log("Page de sous menu de niveau 3 active !"); 
				$("#sousmenu").toggleClass('active');
			}
			
			if ($('#colonne img').css('float') == 'left') {
				$('#colonne img').css('margin-right','10px');
			}
			if ($('#colonne img').css('float') == 'right') {
				$('#colonne img').css('margin-left','10px');
			}
		});
		<?php if (parametre(25, $bdd) != 'NON') {  ?>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php echo parametre(25, $bdd); ?>', 'auto');
			ga('send', 'pageview');
		<?php } ?>
		</script>
	</body>
</html>