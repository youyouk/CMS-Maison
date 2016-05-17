<?php
require '../admin/config.php';
include '../admin/html/header.php';

/**************************************************************
			LISTING PARAMETRES 
***************************************************************/		
$check= empty($_GET['action']);
if($check==true) { ?> 
<ul class="nav nav-tabs" role="tablist" style="padding: 0 1em!important;">
	<li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab"><i class="fa fa-cogs fa-1x"></i></a></li>
	<li role="presentation"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab"><i class="fa fa-envelope fa-1x"></i> Contact</a></li>
	<li role="presentation"><a href="#habillage" aria-controls="habillage" role="tab" data-toggle="tab"><i class="fa fa-picture-o fa-1x"></i> Habillage</a></li>
	<li role="presentation"><a href="#menu" aria-controls="menu" role="tab" data-toggle="tab"><i class="fa fa-list fa-1x"></i> Menu</a></li>
	<li role="presentation"><a href="#carousel" aria-controls="carousel" role="tab" data-toggle="tab"><i class="fa fa-exchange fa-1x"></i> Carousel</a></li>
	<li role="presentation"><a href="#vignettes" aria-controls="vignettes" role="tab" data-toggle="tab"><i class="fa fa-th fa-1x"></i> Vignettes</a></li>
	<li role="presentation"><a href="#facebook" aria-controls="facebook" role="tab" data-toggle="tab"><i class="fa fa-facebook fa-1x"></i> Facebook</a></li>
	<li role="presentation"><a href="#admin" aria-controls="admin" role="tab" data-toggle="tab"><i class="fa fa-lock fa-1x"></i></a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="general"> 
		<h3>Options générales</h3>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 1 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>'; 
				echo'<td>';
					if ($donnees['CONTENU'] == "OUI") {
						echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
					} else if ($donnees['CONTENU'] == "NON") {
						echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
					} else {
						echo''.  $donnees['CONTENU'] . ''; 
					}
				echo'</td> ';
				echo'
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				$reponse->closeCursor(); 
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="contact">
		<h3>Informations de contact</h3>
		<?php if (page_publiee("contact", $bdd) != true) { ?>
			<p>Vous devez <strong>publier la page "Contact"</strong> pour activer le formulaire de contact (<a href="pages.php?ID=6&action=edit">modifier</a>).</p>
		<?php } ?>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 2 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>'; 
						echo'<td>';
						if ($donnees['CONTENU'] == "OUI") {
							echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
						} else if ($donnees['CONTENU'] == "NON") {
							echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
						} else {
							echo''.  $donnees['CONTENU'] . ''; 
						}
						echo'</td> ';
				echo'
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				$reponse->closeCursor(); 
				?>
			</tbody>
		</table> 
	</div>
	<div role="tabpanel" class="tab-pane" id="habillage">
		<h3>Habillage graphique</h3>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 3 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>';
					if ($donnees['TYPE'] == "colorpicker") {
						echo '<td><label class="btn " style="cursor:default;width:60px;background-color:'.  $donnees['CONTENU'] . '"/>&nbsp;</span></td>';
					} else if ($donnees['TYPE'] == "imgpicker") {
						echo '<td><img src="'. $donnees['CONTENU'].'"style="height:40px;border: none;" title="Cliquez pour agrandir"></td>';
					} else if ($donnees['TYPE'] == "iconpicker") {
						echo '<td><h2 style="margin: 0;">&nbsp;</h2></td>';
					} else if (($donnees['TYPE'] == "repeat") && ($donnees['CONTENU'] == "repeat")) {
						echo '<td><span class="success" style="color:#94D094;font-weight:bold;">OUI</span></td>';
					} else if (($donnees['TYPE'] == "repeat") && ($donnees['CONTENU'] == "no-repeat")) {
						echo '<td><span class="danger" style="color:#C02600;font-weight:bold;">NON</span></td>';
					} else {
						echo'<td>';
						if ($donnees['CONTENU'] == "OUI") {
							echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
						} else if ($donnees['CONTENU'] == "NON") {
							echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
						} else {
							echo''.  $donnees['CONTENU'] . ''; 
						}
						echo'</td> ';
					}
				
				echo '
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="menu">
		<h3>Menu de navigation</h3>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 8 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>'; 
				echo'<td>';
					if ($donnees['CONTENU'] == "OUI") {
						echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
					} else if ($donnees['CONTENU'] == "NON") {
						echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
					} else {
						echo''.  $donnees['CONTENU'] . ''; 
					}
					echo'</td> ';
				echo'
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="carousel">
		<h3>Carousel avec photos défilantes</h3>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 7 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>'; 
				echo'<td>';
					if ($donnees['CONTENU'] == "OUI") {
						echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
					} else if ($donnees['CONTENU'] == "NON") {
						echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
					} else {
						echo''.  $donnees['CONTENU'] . ''; 
					}
					echo'</td> ';
				echo'
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="vignettes">
	<h3>Vignettes cliquables</h3>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php  
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 6 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>'; 
				echo'<td>';
					if ($donnees['CONTENU'] == "OUI") {
						echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
					} else if ($donnees['CONTENU'] == "NON") {
						echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
					} else {
						echo''.  $donnees['CONTENU'] . ''; 
					}
					echo'</td> ';
				echo'
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="facebook">
		<h3>Facebook</h3>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php 
				$reponse->closeCursor(); 
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 4 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>'; 
				echo'<td>';
					if ($donnees['CONTENU'] == "OUI") {
						echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
					} else if ($donnees['CONTENU'] == "NON") {
						echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
					} else {
						echo''.  $donnees['CONTENU'] . ''; 
					}
				echo'</td> ';
				echo' 
					<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
	<div role="tabpanel" class="tab-pane" id="admin">
		<h3>Connexions à l'admin</h3>
		<table class="table table-responsive table-striped table-condensed table-hover">
			<tbody>
				<?php 
				$reponse->closeCursor(); 
				$reponse = $bdd->query("SELECT * FROM ADMIN_PARAMETRES WHERE MENU = 5 ORDER BY POSITION ASC"); 
				while ($donnees = $reponse->fetch()) {
				echo '
				<tr>
					<td style="background-color: #f5f5f5;"><label><strong>'. $donnees['NOM'].'</strong></label><br /></td>';
				echo'<td>';
					if ($donnees['CONTENU'] == "OUI") {
						echo'<span class="success" style="color:#94D094;font-weight:bold;">OUI</span>';
					} else if ($donnees['CONTENU'] == "NON") {
						echo'<span class="danger" style="color:#C02600;font-weight:bold;">NON</span>'; 
					} else {
						echo''.  $donnees['CONTENU'] . ''; 
					}
				echo'</td> ';
				echo'<td style="text-align:center;">
							<a href="parametres.php?ID='.$donnees['ID'].'&action=edit" class="btn  btn-success" ><i class="fa fa-edit fa-1x"></i></a> ';
				echo '</td></tr>';
				}
				$reponse->closeCursor();
				?>
			</tbody>
		</table>
	</div>
</div>
<?php }
$check= !empty($_GET['ID']);
if($check==true) { 
	/**************************************************************
				MODIFICATION PARAMETRES ? 
	***************************************************************/
	$action = $_GET['action'];
	$ID = $_GET['ID'];
	if(isset($_POST['update'])){  
		$CONTENU = $_POST['CONTENU']; 
		$ID = $_POST['ID'];
		
		$query = 'UPDATE ADMIN_PARAMETRES SET  
			 CONTENU = :CONTENU  
			 WHERE ID = :ID';
		$statement= $bdd->prepare($query);
		if( $statement->execute(array(':CONTENU' => $CONTENU,':ID' => $ID))) {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&m=8');
			} else {
				header('Location: '.$_SERVER['PHP_SELF'].'?ID='.$ID.'&action=edit&e=8');
			}
	}
	/**************************************************************
				MODE MODIFICATION
	***************************************************************/ 
	if($action == "edit"){
		$query = 'SELECT * FROM ADMIN_PARAMETRES
		WHERE ID = :ID';				
		$statement = $bdd->prepare($query);
		$statement->execute(array(':ID' => $ID));				
		$donnees = $statement->fetch(); ?>
		<div>
			<p></p>
			
			<form action="" method="post" name="post"> 
				<input name="ID" type="hidden" size="0" value="<?php echo $donnees['ID']; ?>" />
				
				<p id="clear">&nbsp;</p>
						<p><?php echo '<label><strong>'. $donnees['NOM'].' :</strong></label><small><em>'. $donnees['AIDE'].'</em></small>'; ?><br /> 
						<?php  if ($donnees['TYPE'] == "text") { ?>
							<input name="CONTENU" type="text"  value="<?php echo $donnees['CONTENU']; ?>"required/>
						<?php } else if ($donnees['TYPE'] == "number") { ?>
							<input name="CONTENU" type="number"  value="<?php echo $donnees['CONTENU']; ?>"required/>
						<?php } else if ($donnees['TYPE'] == "textarea") { ?>
							<textarea name="CONTENU" ><?php echo $donnees['CONTENU']; ?></textarea>
						<?php } else if ($donnees['TYPE'] == "select") { ?>
							<select name="CONTENU">
								<option value="<?php echo $donnees['CONTENU']; ?>">Ne pas modifier (<?php echo $donnees['CONTENU']; ?>)</option>
								<option value="<?php echo $donnees['CONTENU']; ?>">*********</option>
								<option value="OUI">OUI</option>
								<option value="NON">NON</option>
							</select>
						<?php } else if ($donnees['TYPE'] == "selectmenu") { ?>
							<select name="CONTENU">
								<option value="<?php echo $donnees['CONTENU']; ?>">Ne pas modifier (<?php echo $donnees['CONTENU']; ?>)</option>
								<option value="<?php echo $donnees['CONTENU']; ?>">*********</option>
								<option value="TOP">TOP</option>
								<option value="SIDEBAR">SIDEBAR</option>
								<option value="NON">NON</option>
							</select>
						<?php } else if ($donnees['TYPE'] == "repeat") { ?>
							<select name="CONTENU">
								<option value="<?php echo $donnees['CONTENU']; ?>">Ne pas modifier (<?php echo $donnees['CONTENU']; ?>)</option>
								<option value="<?php echo $donnees['CONTENU']; ?>">*********</option>
								<option value="repeat">OUI</option>
								<option value="no-repeat">NON</option>
							</select>
						<?php }else if ($donnees['TYPE'] == "emplacement") { ?>
							<select name="CONTENU">
								<option value="<?php echo $donnees['CONTENU']; ?>">Ne pas modifier (<?php echo $donnees['CONTENU']; ?>)</option>
								<option value="<?php echo $donnees['CONTENU']; ?>">*********</option>
								<option value="HEADER">Header (sur toutes les pages)</option>
								<option value="HOME">Page d'accueil</option>
								<option value="FOOTER">Footer (sur toutes les pages)</option>
								<option value="NON">NON</option>
							</select>
						<?php } else if ($donnees['TYPE'] == "colorpicker") { ?>
							<script src="jscolor.js"></script>
							<script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/admin-jscolor.min.js"></script> 
							<input name="CONTENU" class="btn jscolor {hash:true}" value="<?php echo $donnees['CONTENU']; ?>"required/>
						<?php } else if ($donnees['TYPE'] == "email") { ?>
							<input name="CONTENU" type="email"  value="<?php echo $donnees['CONTENU']; ?>"required/>
						<?php } else if ($donnees['TYPE'] == "url") { ?>
							<input name="CONTENU" type="url"  value="<?php echo $donnees['CONTENU']; ?>"required/>
						<?php } else if ($donnees['TYPE'] == "imgpicker") { ?> 
									<input type="text" id="CONTENU" name="CONTENU" value="<?php echo $donnees['CONTENU']; ?>">
									<a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/admin/tinymce/plugins/filemanager/dialog.php?type=1&field_id=CONTENU&lang=fr_FR&relative_url=1" class="btn iframe-btn btn-info" type="button">Choisir</a> 
						<?php } else if ($donnees['TYPE'] == "iconpicker") { ?>
						<select name="CONTENU"  class="fa" style="font-family:'FontAwesome';">
									<option value="<?php echo $donnees['CONTENU']; ?>" style="font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif !important;">Ne pas modifier</option>
									<option value="NON" style="font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif !important;">NON</option>
									<option value="\f26e"> fa-500px</option>
									<option value="\f042"> fa-adjust</option>
									<option value="\f170"> fa-adn</option>
									<option value="\f037"> fa-align-center</option>
									<option value="\f039"> fa-align-justify</option>
									<option value="\f036"> fa-align-left</option>
									<option value="\f038"> fa-align-right</option>
									<option value="\f270"> fa-amazon</option>
									<option value="\f0f9"> fa-ambulance</option>
									<option value="\f13d"> fa-anchor</option>
									<option value="\f17b"> fa-android</option>
									<option value="\f209"> fa-angellist</option>
									<option value="\f103"> fa-angle-double-down</option>
									<option value="\f100"> fa-angle-double-left</option>
									<option value="\f101"> fa-angle-double-right</option>
									<option value="\f102"> fa-angle-double-up</option>
									<option value="\f107"> fa-angle-down</option>
									<option value="\f104"> fa-angle-left</option>
									<option value="\f105"> fa-angle-right</option>
									<option value="\f106"> fa-angle-up</option>
									<option value="\f179"> fa-apple</option>
									<option value="\f187"> fa-archive</option>
									<option value="\f1fe"> fa-area-chart</option>
									<option value="\f0ab"> fa-arrow-circle-down</option>
									<option value="\f0a8"> fa-arrow-circle-left</option>
									<option value="\f01a"> fa-arrow-circle-o-down</option>
									<option value="\f190"> fa-arrow-circle-o-left</option>
									<option value="\f18e"> fa-arrow-circle-o-right</option>
									<option value="\f01b"> fa-arrow-circle-o-up</option>
									<option value="\f0a9"> fa-arrow-circle-right</option>
									<option value="\f0aa"> fa-arrow-circle-up</option>
									<option value="\f063"> fa-arrow-down</option>
									<option value="\f060"> fa-arrow-left</option>
									<option value="\f061"> fa-arrow-right</option>
									<option value="\f062"> fa-arrow-up</option>
									<option value="\f047"> fa-arrows</option>
									<option value="\f0b2"> fa-arrows-alt</option>
									<option value="\f07e"> fa-arrows-h</option>
									<option value="\f07d"> fa-arrows-v</option>
									<option value="\f069"> fa-asterisk</option>
									<option value="\f1fa"> fa-at</option>
									<option value="\f1b9"> fa-automobile</option>
									<option value="\f04a"> fa-backward</option>
									<option value="\f24e"> fa-balance-scale</option>
									<option value="\f05e"> fa-ban</option>
									<option value="\f19c"> fa-bank</option>
									<option value="\f080"> fa-bar-chart</option>
									<option value="\f080"> fa-bar-chart-o</option>
									<option value="\f02a"> fa-barcode</option>
									<option value="\f0c9"> fa-bars</option>
									<option value="\f244"> fa-battery-0</option>
									<option value="\f243"> fa-battery-1</option>
									<option value="\f242"> fa-battery-2</option>
									<option value="\f241"> fa-battery-3</option>
									<option value="\f240"> fa-battery-4</option>
									<option value="\f244"> fa-battery-empty</option>
									<option value="\f240"> fa-battery-full</option>
									<option value="\f242"> fa-battery-half</option>
									<option value="\f243"> fa-battery-quarter</option>
									<option value="\f241"> fa-battery-three-quarters</option>
									<option value="\f236"> fa-bed</option>
									<option value="\f0fc"> fa-beer</option>
									<option value="\f1b4"> fa-behance</option>
									<option value="\f1b5"> fa-behance-square</option>
									<option value="\f0f3"> fa-bell</option>
									<option value="\f0a2"> fa-bell-o</option>
									<option value="\f1f6"> fa-bell-slash</option>
									<option value="\f1f7"> fa-bell-slash-o</option>
									<option value="\f206"> fa-bicycle</option>
									<option value="\f1e5"> fa-binoculars</option>
									<option value="\f1fd"> fa-birthday-cake</option>
									<option value="\f171"> fa-bitbucket</option>
									<option value="\f172"> fa-bitbucket-square</option>
									<option value="\f15a"> fa-bitcoin</option>
									<option value="\f27e"> fa-black-tie</option>
									<option value="\f293"> fa-bluetooth</option>
									<option value="\f294"> fa-bluetooth-b</option>
									<option value="\f032"> fa-bold</option>
									<option value="\f0e7"> fa-bolt</option>
									<option value="\f1e2"> fa-bomb</option>
									<option value="\f02d"> fa-book</option>
									<option value="\f02e"> fa-bookmark</option>
									<option value="\f097"> fa-bookmark-o</option>
									<option value="\f0b1"> fa-briefcase</option>
									<option value="\f15a"> fa-btc</option>
									<option value="\f188"> fa-bug</option>
									<option value="\f1ad"> fa-building</option>
									<option value="\f0f7"> fa-building-o</option>
									<option value="\f0a1"> fa-bullhorn</option>
									<option value="\f140"> fa-bullseye</option>
									<option value="\f207"> fa-bus</option>
									<option value="\f20d"> fa-buysellads</option>
									<option value="\f1ba"> fa-cab</option>
									<option value="\f1ec"> fa-calculator</option>
									<option value="\f073"> fa-calendar</option>
									<option value="\f274"> fa-calendar-check-o</option>
									<option value="\f272"> fa-calendar-minus-o</option>
									<option value="\f133"> fa-calendar-o</option>
									<option value="\f271"> fa-calendar-plus-o</option>
									<option value="\f273"> fa-calendar-times-o</option>
									<option value="\f030"> fa-camera</option>
									<option value="\f083"> fa-camera-retro</option>
									<option value="\f1b9"> fa-car</option>
									<option value="\f0d7"> fa-caret-down</option>
									<option value="\f0d9"> fa-caret-left</option>
									<option value="\f0da"> fa-caret-right</option>
									<option value="\f150"> fa-caret-square-o-down</option>
									<option value="\f191"> fa-caret-square-o-left</option>
									<option value="\f152"> fa-caret-square-o-right</option>
									<option value="\f151"> fa-caret-square-o-up</option>
									<option value="\f0d8"> fa-caret-up</option>
									<option value="\f218"> fa-cart-arrow-down</option>
									<option value="\f217"> fa-cart-plus</option>
									<option value="\f20a"> fa-cc</option>
									<option value="\f1f3"> fa-cc-amex</option>
									<option value="\f24c"> fa-cc-diners-club</option>
									<option value="\f1f2"> fa-cc-discover</option>
									<option value="\f24b"> fa-cc-jcb</option>
									<option value="\f1f1"> fa-cc-mastercard</option>
									<option value="\f1f4"> fa-cc-paypal</option>
									<option value="\f1f5"> fa-cc-stripe</option>
									<option value="\f1f0"> fa-cc-visa</option>
									<option value="\f0a3"> fa-certificate</option>
									<option value="\f0c1"> fa-chain</option>
									<option value="\f127"> fa-chain-broken</option>
									<option value="\f00c"> fa-check</option>
									<option value="\f058"> fa-check-circle</option>
									<option value="\f05d"> fa-check-circle-o</option>
									<option value="\f14a"> fa-check-square</option>
									<option value="\f046"> fa-check-square-o</option>
									<option value="\f13a"> fa-chevron-circle-down</option>
									<option value="\f137"> fa-chevron-circle-left</option>
									<option value="\f138"> fa-chevron-circle-right</option>
									<option value="\f139"> fa-chevron-circle-up</option>
									<option value="\f078"> fa-chevron-down</option>
									<option value="\f053"> fa-chevron-left</option>
									<option value="\f054"> fa-chevron-right</option>
									<option value="\f077"> fa-chevron-up</option>
									<option value="\f1ae"> fa-child</option>
									<option value="\f268"> fa-chrome</option>
									<option value="\f111"> fa-circle</option>
									<option value="\f10c"> fa-circle-o</option>
									<option value="\f1ce"> fa-circle-o-notch</option>
									<option value="\f1db"> fa-circle-thin</option>
									<option value="\f0ea"> fa-clipboard</option>
									<option value="\f017"> fa-clock-o</option>
									<option value="\f24d"> fa-clone</option>
									<option value="\f00d"> fa-close</option>
									<option value="\f0c2"> fa-cloud</option>
									<option value="\f0ed"> fa-cloud-download</option>
									<option value="\f0ee"> fa-cloud-upload</option>
									<option value="\f157"> fa-cny</option>
									<option value="\f121"> fa-code</option>
									<option value="\f126"> fa-code-fork</option>
									<option value="\f1cb"> fa-codepen</option>
									<option value="\f284"> fa-codiepie</option>
									<option value="\f0f4"> fa-coffee</option>
									<option value="\f013"> fa-cog</option>
									<option value="\f085"> fa-cogs</option>
									<option value="\f0db"> fa-columns</option>
									<option value="\f075"> fa-comment</option>
									<option value="\f0e5"> fa-comment-o</option>
									<option value="\f27a"> fa-commenting</option>
									<option value="\f27b"> fa-commenting-o</option>
									<option value="\f086"> fa-comments</option>
									<option value="\f0e6"> fa-comments-o</option>
									<option value="\f14e"> fa-compass</option>
									<option value="\f066"> fa-compress</option>
									<option value="\f20e"> fa-connectdevelop</option>
									<option value="\f26d"> fa-contao</option>
									<option value="\f0c5"> fa-copy</option>
									<option value="\f1f9"> fa-copyright</option>
									<option value="\f25e"> fa-creative-commons</option>
									<option value="\f09d"> fa-credit-card</option>
									<option value="\f283"> fa-credit-card-alt</option>
									<option value="\f125"> fa-crop</option>
									<option value="\f05b"> fa-crosshairs</option>
									<option value="\f13c"> fa-css3</option>
									<option value="\f1b2"> fa-cube</option>
									<option value="\f1b3"> fa-cubes</option>
									<option value="\f0c4"> fa-cut</option>
									<option value="\f0f5"> fa-cutlery</option>
									<option value="\f0e4"> fa-dashboard</option>
									<option value="\f210"> fa-dashcube</option>
									<option value="\f1c0"> fa-database</option>
									<option value="\f03b"> fa-dedent</option>
									<option value="\f1a5"> fa-delicious</option>
									<option value="\f108"> fa-desktop</option>
									<option value="\f1bd"> fa-deviantart</option>
									<option value="\f219"> fa-diamond</option>
									<option value="\f1a6"> fa-digg</option>
									<option value="\f155"> fa-dollar</option>
									<option value="\f192"> fa-dot-circle-o</option>
									<option value="\f019"> fa-download</option>
									<option value="\f17d"> fa-dribbble</option>
									<option value="\f16b"> fa-dropbox</option>
									<option value="\f1a9"> fa-drupal</option>
									<option value="\f282"> fa-edge</option>
									<option value="\f044"> fa-edit</option>
									<option value="\f052"> fa-eject</option>
									<option value="\f141"> fa-ellipsis-h</option>
									<option value="\f142"> fa-ellipsis-v</option>
									<option value="\f1d1"> fa-empire</option>
									<option value="\f0e0"> fa-envelope</option>
									<option value="\f003"> fa-envelope-o</option>
									<option value="\f199"> fa-envelope-square</option>
									<option value="\f12d"> fa-eraser</option>
									<option value="\f153"> fa-eur</option>
									<option value="\f153"> fa-euro</option>
									<option value="\f0ec"> fa-exchange</option>
									<option value="\f12a"> fa-exclamation</option>
									<option value="\f06a"> fa-exclamation-circle</option>
									<option value="\f071"> fa-exclamation-triangle</option>
									<option value="\f065"> fa-expand</option>
									<option value="\f23e"> fa-expeditedssl</option>
									<option value="\f08e"> fa-external-link</option>
									<option value="\f14c"> fa-external-link-square</option>
									<option value="\f06e"> fa-eye</option>
									<option value="\f070"> fa-eye-slash</option>
									<option value="\f1fb"> fa-eyedropper</option>
									<option value="\f09a"> fa-facebook</option>
									<option value="\f09a"> fa-facebook-f</option>
									<option value="\f230"> fa-facebook-official</option>
									<option value="\f082"> fa-facebook-square</option>
									<option value="\f049"> fa-fast-backward</option>
									<option value="\f050"> fa-fast-forward</option>
									<option value="\f1ac"> fa-fax</option>
									<option value="\f09e"> fa-feed</option>
									<option value="\f182"> fa-female</option>
									<option value="\f0fb"> fa-fighter-jet</option>
									<option value="\f15b"> fa-file</option>
									<option value="\f1c6"> fa-file-archive-o</option>
									<option value="\f1c7"> fa-file-audio-o</option>
									<option value="\f1c9"> fa-file-code-o</option>
									<option value="\f1c3"> fa-file-excel-o</option>
									<option value="\f1c5"> fa-file-image-o</option>
									<option value="\f1c8"> fa-file-movie-o</option>
									<option value="\f016"> fa-file-o</option>
									<option value="\f1c1"> fa-file-pdf-o</option>
									<option value="\f1c5"> fa-file-photo-o</option>
									<option value="\f1c5"> fa-file-picture-o</option>
									<option value="\f1c4"> fa-file-powerpoint-o</option>
									<option value="\f1c7"> fa-file-sound-o</option>
									<option value="\f15c"> fa-file-text</option>
									<option value="\f0f6"> fa-file-text-o</option>
									<option value="\f1c8"> fa-file-video-o</option>
									<option value="\f1c2"> fa-file-word-o</option>
									<option value="\f1c6"> fa-file-zip-o</option>
									<option value="\f0c5"> fa-files-o</option>
									<option value="\f008"> fa-film</option>
									<option value="\f0b0"> fa-filter</option>
									<option value="\f06d"> fa-fire</option>
									<option value="\f134"> fa-fire-extinguisher</option>
									<option value="\f269"> fa-firefox</option>
									<option value="\f024"> fa-flag</option>
									<option value="\f11e"> fa-flag-checkered</option>
									<option value="\f11d"> fa-flag-o</option>
									<option value="\f0e7"> fa-flash</option>
									<option value="\f0c3"> fa-flask</option>
									<option value="\f16e"> fa-flickr</option>
									<option value="\f0c7"> fa-floppy-o</option>
									<option value="\f07b"> fa-folder</option>
									<option value="\f114"> fa-folder-o</option>
									<option value="\f07c"> fa-folder-open</option>
									<option value="\f115"> fa-folder-open-o</option>
									<option value="\f031"> fa-font</option>
									<option value="\f280"> fa-fonticons</option>
									<option value="\f286"> fa-fort-awesome</option>
									<option value="\f211"> fa-forumbee</option>
									<option value="\f04e"> fa-forward</option>
									<option value="\f180"> fa-foursquare</option>
									<option value="\f119"> fa-frown-o</option>
									<option value="\f1e3"> fa-futbol-o</option>
									<option value="\f11b"> fa-gamepad</option>
									<option value="\f0e3"> fa-gavel</option>
									<option value="\f154"> fa-gbp</option>
									<option value="\f1d1"> fa-ge</option>
									<option value="\f013"> fa-gear</option>
									<option value="\f085"> fa-gears</option>
									<option value="\f22d"> fa-genderless</option>
									<option value="\f265"> fa-get-pocket</option>
									<option value="\f260"> fa-gg</option>
									<option value="\f261"> fa-gg-circle</option>
									<option value="\f06b"> fa-gift</option>
									<option value="\f1d3"> fa-git</option>
									<option value="\f1d2"> fa-git-square</option>
									<option value="\f09b"> fa-github</option>
									<option value="\f113"> fa-github-alt</option>
									<option value="\f092"> fa-github-square</option>
									<option value="\f184"> fa-gittip</option>
									<option value="\f000"> fa-glass</option>
									<option value="\f0ac"> fa-globe</option>
									<option value="\f1a0"> fa-google</option>
									<option value="\f0d5"> fa-google-plus</option>
									<option value="\f0d4"> fa-google-plus-square</option>
									<option value="\f1ee"> fa-google-wallet</option>
									<option value="\f19d"> fa-graduation-cap</option>
									<option value="\f184"> fa-gratipay</option>
									<option value="\f0c0"> fa-group</option>
									<option value="\f0fd"> fa-h-square</option>
									<option value="\f1d4"> fa-hacker-news</option>
									<option value="\f255"> fa-hand-grab-o</option>
									<option value="\f258"> fa-hand-lizard-o</option>
									<option value="\f0a7"> fa-hand-o-down</option>
									<option value="\f0a5"> fa-hand-o-left</option>
									<option value="\f0a4"> fa-hand-o-right</option>
									<option value="\f0a6"> fa-hand-o-up</option>
									<option value="\f256"> fa-hand-paper-o</option>
									<option value="\f25b"> fa-hand-peace-o</option>
									<option value="\f25a"> fa-hand-pointer-o</option>
									<option value="\f255"> fa-hand-rock-o</option>
									<option value="\f257"> fa-hand-scissors-o</option>
									<option value="\f259"> fa-hand-spock-o</option>
									<option value="\f256"> fa-hand-stop-o</option>
									<option value="\f292"> fa-hashtag</option>
									<option value="\f0a0"> fa-hdd-o</option>
									<option value="\f1dc"> fa-header</option>
									<option value="\f025"> fa-headphones</option>
									<option value="\f004"> fa-heart</option>
									<option value="\f08a"> fa-heart-o</option>
									<option value="\f21e"> fa-heartbeat</option>
									<option value="\f1da"> fa-history</option>
									<option value="\f015"> fa-home</option>
									<option value="\f0f8"> fa-hospital-o</option>
									<option value="\f236"> fa-hotel</option>
									<option value="\f254"> fa-hourglass</option>
									<option value="\f251"> fa-hourglass-1</option>
									<option value="\f252"> fa-hourglass-2</option>
									<option value="\f253"> fa-hourglass-3</option>
									<option value="\f253"> fa-hourglass-end</option>
									<option value="\f252"> fa-hourglass-half</option>
									<option value="\f250"> fa-hourglass-o</option>
									<option value="\f251"> fa-hourglass-start</option>
									<option value="\f27c"> fa-houzz</option>
									<option value="\f13b"> fa-html5</option>
									<option value="\f246"> fa-i-cursor</option>
									<option value="\f20b"> fa-ils</option>
									<option value="\f03e"> fa-image</option>
									<option value="\f01c"> fa-inbox</option>
									<option value="\f03c"> fa-indent</option>
									<option value="\f275"> fa-industry</option>
									<option value="\f129"> fa-info</option>
									<option value="\f05a"> fa-info-circle</option>
									<option value="\f156"> fa-inr</option>
									<option value="\f16d"> fa-instagram</option>
									<option value="\f19c"> fa-institution</option>
									<option value="\f26b"> fa-internet-explorer</option>
									<option value="\f224"> fa-intersex</option>
									<option value="\f208"> fa-ioxhost</option>
									<option value="\f033"> fa-italic</option>
									<option value="\f1aa"> fa-joomla</option>
									<option value="\f157"> fa-jpy</option>
									<option value="\f1cc"> fa-jsfiddle</option>
									<option value="\f084"> fa-key</option>
									<option value="\f11c"> fa-keyboard-o</option>
									<option value="\f159"> fa-krw</option>
									<option value="\f1ab"> fa-language</option>
									<option value="\f109"> fa-laptop</option>
									<option value="\f202"> fa-lastfm</option>
									<option value="\f203"> fa-lastfm-square</option>
									<option value="\f06c"> fa-leaf</option>
									<option value="\f212"> fa-leanpub</option>
									<option value="\f0e3"> fa-legal</option>
									<option value="\f094"> fa-lemon-o</option>
									<option value="\f149"> fa-level-down</option>
									<option value="\f148"> fa-level-up</option>
									<option value="\f1cd"> fa-life-bouy</option>
									<option value="\f1cd"> fa-life-buoy</option>
									<option value="\f1cd"> fa-life-ring</option>
									<option value="\f1cd"> fa-life-saver</option>
									<option value="\f0eb"> fa-lightbulb-o</option>
									<option value="\f201"> fa-line-chart</option>
									<option value="\f0c1"> fa-link</option>
									<option value="\f0e1"> fa-linkedin</option>
									<option value="\f08c"> fa-linkedin-square</option>
									<option value="\f17c"> fa-linux</option>
									<option value="\f03a"> fa-list</option>
									<option value="\f022"> fa-list-alt</option>
									<option value="\f0cb"> fa-list-ol</option>
									<option value="\f0ca"> fa-list-ul</option>
									<option value="\f124"> fa-location-arrow</option>
									<option value="\f023"> fa-lock</option>
									<option value="\f175"> fa-long-arrow-down</option>
									<option value="\f177"> fa-long-arrow-left</option>
									<option value="\f178"> fa-long-arrow-right</option>
									<option value="\f176"> fa-long-arrow-up</option>
									<option value="\f0d0"> fa-magic</option>
									<option value="\f076"> fa-magnet</option>
									<option value="\f064"> fa-mail-forward</option>
									<option value="\f112"> fa-mail-reply</option>
									<option value="\f122"> fa-mail-reply-all</option>
									<option value="\f183"> fa-male</option>
									<option value="\f279"> fa-map</option>
									<option value="\f041"> fa-map-marker</option>
									<option value="\f278"> fa-map-o</option>
									<option value="\f276"> fa-map-pin</option>
									<option value="\f277"> fa-map-signs</option>
									<option value="\f222"> fa-mars</option>
									<option value="\f227"> fa-mars-double</option>
									<option value="\f229"> fa-mars-stroke</option>
									<option value="\f22b"> fa-mars-stroke-h</option>
									<option value="\f22a"> fa-mars-stroke-v</option>
									<option value="\f136"> fa-maxcdn</option>
									<option value="\f20c"> fa-meanpath</option>
									<option value="\f23a"> fa-medium</option>
									<option value="\f0fa"> fa-medkit</option>
									<option value="\f11a"> fa-meh-o</option>
									<option value="\f223"> fa-mercury</option>
									<option value="\f130"> fa-microphone</option>
									<option value="\f131"> fa-microphone-slash</option>
									<option value="\f068"> fa-minus</option>
									<option value="\f056"> fa-minus-circle</option>
									<option value="\f146"> fa-minus-square</option>
									<option value="\f147"> fa-minus-square-o</option>
									<option value="\f289"> fa-mixcloud</option>
									<option value="\f10b"> fa-mobile</option>
									<option value="\f10b"> fa-mobile-phone</option>
									<option value="\f285"> fa-modx</option>
									<option value="\f0d6"> fa-money</option>
									<option value="\f186"> fa-moon-o</option>
									<option value="\f19d"> fa-mortar-board</option>
									<option value="\f21c"> fa-motorcycle</option>
									<option value="\f245"> fa-mouse-pointer</option>
									<option value="\f001"> fa-music</option>
									<option value="\f0c9"> fa-navicon</option>
									<option value="\f22c"> fa-neuter</option>
									<option value="\f1ea"> fa-newspaper-o</option>
									<option value="\f247"> fa-object-group</option>
									<option value="\f248"> fa-object-ungroup</option>
									<option value="\f263"> fa-odnoklassniki</option>
									<option value="\f264"> fa-odnoklassniki-square</option>
									<option value="\f23d"> fa-opencart</option>
									<option value="\f19b"> fa-openid</option>
									<option value="\f26a"> fa-opera</option>
									<option value="\f23c"> fa-optin-monster</option>
									<option value="\f03b"> fa-outdent</option>
									<option value="\f18c"> fa-pagelines</option>
									<option value="\f1fc"> fa-paint-brush</option>
									<option value="\f1d8"> fa-paper-plane</option>
									<option value="\f1d9"> fa-paper-plane-o</option>
									<option value="\f0c6"> fa-paperclip</option>
									<option value="\f1dd"> fa-paragraph</option>
									<option value="\f0ea"> fa-paste</option>
									<option value="\f04c"> fa-pause</option>
									<option value="\f28b"> fa-pause-circle</option>
									<option value="\f28c"> fa-pause-circle-o</option>
									<option value="\f1b0"> fa-paw</option>
									<option value="\f1ed"> fa-paypal</option>
									<option value="\f040"> fa-pencil</option>
									<option value="\f14b"> fa-pencil-square</option>
									<option value="\f044"> fa-pencil-square-o</option>
									<option value="\f295"> fa-percent</option>
									<option value="\f095"> fa-phone</option>
									<option value="\f098"> fa-phone-square</option>
									<option value="\f03e"> fa-photo</option>
									<option value="\f03e"> fa-picture-o</option>
									<option value="\f200"> fa-pie-chart</option>
									<option value="\f1a7"> fa-pied-piper</option>
									<option value="\f1a8"> fa-pied-piper-alt</option>
									<option value="\f0d2"> fa-pinterest</option>
									<option value="\f231"> fa-pinterest-p</option>
									<option value="\f0d3"> fa-pinterest-square</option>
									<option value="\f072"> fa-plane</option>
									<option value="\f04b"> fa-play</option>
									<option value="\f144"> fa-play-circle</option>
									<option value="\f01d"> fa-play-circle-o</option>
									<option value="\f1e6"> fa-plug</option>
									<option value="\f067"> fa-plus</option>
									<option value="\f055"> fa-plus-circle</option>
									<option value="\f0fe"> fa-plus-square</option>
									<option value="\f196"> fa-plus-square-o</option>
									<option value="\f011"> fa-power-off</option>
									<option value="\f02f"> fa-print</option>
									<option value="\f288"> fa-product-hunt</option>
									<option value="\f12e"> fa-puzzle-piece</option>
									<option value="\f1d6"> fa-qq</option>
									<option value="\f029"> fa-qrcode</option>
									<option value="\f128"> fa-question</option>
									<option value="\f059"> fa-question-circle</option>
									<option value="\f10d"> fa-quote-left</option>
									<option value="\f10e"> fa-quote-right</option>
									<option value="\f1d0"> fa-ra</option>
									<option value="\f074"> fa-random</option>
									<option value="\f1d0"> fa-rebel</option>
									<option value="\f1b8"> fa-recycle</option>
									<option value="\f1a1"> fa-reddit</option>
									<option value="\f281"> fa-reddit-alien</option>
									<option value="\f1a2"> fa-reddit-square</option>
									<option value="\f021"> fa-refresh</option>
									<option value="\f25d"> fa-registered</option>
									<option value="\f00d"> fa-remove</option>
									<option value="\f18b"> fa-renren</option>
									<option value="\f0c9"> fa-reorder</option>
									<option value="\f01e"> fa-repeat</option>
									<option value="\f112"> fa-reply</option>
									<option value="\f122"> fa-reply-all</option>
									<option value="\f079"> fa-retweet</option>
									<option value="\f157"> fa-rmb</option>
									<option value="\f018"> fa-road</option>
									<option value="\f135"> fa-rocket</option>
									<option value="\f0e2"> fa-rotate-left</option>
									<option value="\f01e"> fa-rotate-right</option>
									<option value="\f158"> fa-rouble</option>
									<option value="\f09e"> fa-rss</option>
									<option value="\f143"> fa-rss-square</option>
									<option value="\f158"> fa-rub</option>
									<option value="\f158"> fa-ruble</option>
									<option value="\f156"> fa-rupee</option>
									<option value="\f267"> fa-safari</option>
									<option value="\f0c7"> fa-save</option>
									<option value="\f0c4"> fa-scissors</option>
									<option value="\f28a"> fa-scribd</option>
									<option value="\f002"> fa-search</option>
									<option value="\f010"> fa-search-minus</option>
									<option value="\f00e"> fa-search-plus</option>
									<option value="\f213"> fa-sellsy</option>
									<option value="\f1d8"> fa-send</option>
									<option value="\f1d9"> fa-send-o</option>
									<option value="\f233"> fa-server</option>
									<option value="\f064"> fa-share</option>
									<option value="\f1e0"> fa-share-alt</option>
									<option value="\f1e1"> fa-share-alt-square</option>
									<option value="\f14d"> fa-share-square</option>
									<option value="\f045"> fa-share-square-o</option>
									<option value="\f20b"> fa-shekel</option>
									<option value="\f20b"> fa-sheqel</option>
									<option value="\f132"> fa-shield</option>
									<option value="\f21a"> fa-ship</option>
									<option value="\f214"> fa-shirtsinbulk</option>
									<option value="\f290"> fa-shopping-bag</option>
									<option value="\f291"> fa-shopping-basket</option>
									<option value="\f07a"> fa-shopping-cart</option>
									<option value="\f090"> fa-sign-in</option>
									<option value="\f08b"> fa-sign-out</option>
									<option value="\f012"> fa-signal</option>
									<option value="\f215"> fa-simplybuilt</option>
									<option value="\f0e8"> fa-sitemap</option>
									<option value="\f216"> fa-skyatlas</option>
									<option value="\f17e"> fa-skype</option>
									<option value="\f198"> fa-slack</option>
									<option value="\f1de"> fa-sliders</option>
									<option value="\f1e7"> fa-slideshare</option>
									<option value="\f118"> fa-smile-o</option>
									<option value="\f1e3"> fa-soccer-ball-o</option>
									<option value="\f0dc"> fa-sort</option>
									<option value="\f15d"> fa-sort-alpha-asc</option>
									<option value="\f15e"> fa-sort-alpha-desc</option>
									<option value="\f160"> fa-sort-amount-asc</option>
									<option value="\f161"> fa-sort-amount-desc</option>
									<option value="\f0de"> fa-sort-asc</option>
									<option value="\f0dd"> fa-sort-desc</option>
									<option value="\f0dd"> fa-sort-down</option>
									<option value="\f162"> fa-sort-numeric-asc</option>
									<option value="\f163"> fa-sort-numeric-desc</option>
									<option value="\f0de"> fa-sort-up</option>
									<option value="\f1be"> fa-soundcloud</option>
									<option value="\f197"> fa-space-shuttle</option>
									<option value="\f110"> fa-spinner</option>
									<option value="\f1b1"> fa-spoon</option>
									<option value="\f1bc"> fa-spotify</option>
									<option value="\f0c8"> fa-square</option>
									<option value="\f096"> fa-square-o</option>
									<option value="\f18d"> fa-stack-exchange</option>
									<option value="\f16c"> fa-stack-overflow</option>
									<option value="\f005"> fa-star</option>
									<option value="\f089"> fa-star-half</option>
									<option value="\f123"> fa-star-half-empty</option>
									<option value="\f123"> fa-star-half-full</option>
									<option value="\f123"> fa-star-half-o</option>
									<option value="\f006"> fa-star-o</option>
									<option value="\f1b6"> fa-steam</option>
									<option value="\f1b7"> fa-steam-square</option>
									<option value="\f048"> fa-step-backward</option>
									<option value="\f051"> fa-step-forward</option>
									<option value="\f0f1"> fa-stethoscope</option>
									<option value="\f249"> fa-sticky-note</option>
									<option value="\f24a"> fa-sticky-note-o</option>
									<option value="\f04d"> fa-stop</option>
									<option value="\f28d"> fa-stop-circle</option>
									<option value="\f28e"> fa-stop-circle-o</option>
									<option value="\f21d"> fa-street-view</option>
									<option value="\f0cc"> fa-strikethrough</option>
									<option value="\f1a4"> fa-stumbleupon</option>
									<option value="\f1a3"> fa-stumbleupon-circle</option>
									<option value="\f12c"> fa-subscript</option>
									<option value="\f239"> fa-subway</option>
									<option value="\f0f2"> fa-suitcase</option>
									<option value="\f185"> fa-sun-o</option>
									<option value="\f12b"> fa-superscript</option>
									<option value="\f1cd"> fa-support</option>
									<option value="\f0ce"> fa-table</option>
									<option value="\f10a"> fa-tablet</option>
									<option value="\f0e4"> fa-tachometer</option>
									<option value="\f02b"> fa-tag</option>
									<option value="\f02c"> fa-tags</option>
									<option value="\f0ae"> fa-tasks</option>
									<option value="\f1ba"> fa-taxi</option>
									<option value="\f26c"> fa-television</option>
									<option value="\f1d5"> fa-tencent-weibo</option>
									<option value="\f120"> fa-terminal</option>
									<option value="\f034"> fa-text-height</option>
									<option value="\f035"> fa-text-width</option>
									<option value="\f00a"> fa-th</option>
									<option value="\f009"> fa-th-large</option>
									<option value="\f00b"> fa-th-list</option>
									<option value="\f08d"> fa-thumb-tack</option>
									<option value="\f165"> fa-thumbs-down</option>
									<option value="\f088"> fa-thumbs-o-down</option>
									<option value="\f087"> fa-thumbs-o-up</option>
									<option value="\f164"> fa-thumbs-up</option>
									<option value="\f145"> fa-ticket</option>
									<option value="\f00d"> fa-times</option>
									<option value="\f057"> fa-times-circle</option>
									<option value="\f05c"> fa-times-circle-o</option>
									<option value="\f043"> fa-tint</option>
									<option value="\f150"> fa-toggle-down</option>
									<option value="\f191"> fa-toggle-left</option>
									<option value="\f204"> fa-toggle-off</option>
									<option value="\f205"> fa-toggle-on</option>
									<option value="\f152"> fa-toggle-right</option>
									<option value="\f151"> fa-toggle-up</option>
									<option value="\f25c"> fa-trademark</option>
									<option value="\f238"> fa-train</option>
									<option value="\f224"> fa-transgender</option>
									<option value="\f225"> fa-transgender-alt</option>
									<option value="\f1f8"> fa-trash</option>
									<option value="\f014"> fa-trash-o</option>
									<option value="\f1bb"> fa-tree</option>
									<option value="\f181"> fa-trello</option>
									<option value="\f262"> fa-tripadvisor</option>
									<option value="\f091"> fa-trophy</option>
									<option value="\f0d1"> fa-truck</option>
									<option value="\f195"> fa-try</option>
									<option value="\f1e4"> fa-tty</option>
									<option value="\f173"> fa-tumblr</option>
									<option value="\f174"> fa-tumblr-square</option>
									<option value="\f195"> fa-turkish-lira</option>
									<option value="\f26c"> fa-tv</option>
									<option value="\f1e8"> fa-twitch</option>
									<option value="\f099"> fa-twitter</option>
									<option value="\f081"> fa-twitter-square</option>
									<option value="\f0e9"> fa-umbrella</option>
									<option value="\f0cd"> fa-underline</option>
									<option value="\f0e2"> fa-undo</option>
									<option value="\f19c"> fa-university</option>
									<option value="\f127"> fa-unlink</option>
									<option value="\f09c"> fa-unlock</option>
									<option value="\f13e"> fa-unlock-alt</option>
									<option value="\f0dc"> fa-unsorted</option>
									<option value="\f093"> fa-upload</option>
									<option value="\f287"> fa-usb</option>
									<option value="\f155"> fa-usd</option>
									<option value="\f007"> fa-user</option>
									<option value="\f0f0"> fa-user-md</option>
									<option value="\f234"> fa-user-plus</option>
									<option value="\f21b"> fa-user-secret</option>
									<option value="\f235"> fa-user-times</option>
									<option value="\f0c0"> fa-users</option>
									<option value="\f221"> fa-venus</option>
									<option value="\f226"> fa-venus-double</option>
									<option value="\f228"> fa-venus-mars</option>
									<option value="\f237"> fa-viacoin</option>
									<option value="\f03d"> fa-video-camera</option>
									<option value="\f27d"> fa-vimeo</option>
									<option value="\f194"> fa-vimeo-square</option>
									<option value="\f1ca"> fa-vine</option>
									<option value="\f189"> fa-vk</option>
									<option value="\f027"> fa-volume-down</option>
									<option value="\f026"> fa-volume-off</option>
									<option value="\f028"> fa-volume-up</option>
									<option value="\f071"> fa-warning</option>
									<option value="\f1d7"> fa-wechat</option>
									<option value="\f18a"> fa-weibo</option>
									<option value="\f1d7"> fa-weixin</option>
									<option value="\f232"> fa-whatsapp</option>
									<option value="\f193"> fa-wheelchair</option>
									<option value="\f1eb"> fa-wifi</option>
									<option value="\f266"> fa-wikipedia-w</option>
									<option value="\f17a"> fa-windows</option>
									<option value="\f159"> fa-won</option>
									<option value="\f19a"> fa-wordpress</option>
									<option value="\f0ad"> fa-wrench</option>
									<option value="\f168"> fa-xing</option>
									<option value="\f169"> fa-xing-square</option>
									<option value="\f23b"> fa-y-combinator</option>
									<option value="\f1d4"> fa-y-combinator-square</option>
									<option value="\f19e"> fa-yahoo</option>
									<option value="\f23b"> fa-yc</option>
									<option value="\f1d4"> fa-yc-square</option>
									<option value="\f1e9"> fa-yelp</option>
									<option value="\f157"> fa-yen</option>
									<option value="\f167"> fa-youtube</option>
									<option value="\f16a"> fa-youtube-play</option>
									<option value="\f166"> fa-youtube-square</option>
								</select>
								<p><em><small>Icône actuelle : <h2 style="margin: -25px 0 0 100px;">&nbsp;</h2></em></small></p>
						<?php } ?>
						</p>
				
				<p id="clear">&nbsp;</p>
					<a href="parametres.php" class=" btn btn-default">Retour</a>
					<input name="update" type="submit" class=" btn btn-large btn-success" value="Mettre à jour"/>
			</form> 
			<p id="clear">&nbsp;</p> 
		</div> 
	<?php
	}
}	 
include'../admin/html/footer.php';
?>