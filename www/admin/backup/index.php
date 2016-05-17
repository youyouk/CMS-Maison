<?php
if(strpos($_SERVER["REQUEST_URI"],"index")!==false) {
	header("Location: http://".$_SERVER['HTTP_HOST']."/");
	exit;
}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="backup/gui/libs/amplify.min.js"></script>
<script src="backup/gui/apiroutes.js"></script> 
<!--<script src="backup/gui/libs/knockout-2.1.0.js"></script>-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/knockout/2.2.1/knockout-min.js"></script>
<script src="backup/gui/libs/knockout-components.js"></script>
<script src="backup/gui/libs/knockout-validation.js"></script>
<script src="backup/gui/viewmodels/PasswordPanel.js"></script>
<script src="backup/gui/components/CheckBox/CheckBox.js"></script>
<script src="backup/gui/components/TreeView/TreeView.js"></script>
<script src="backup/gui/viewmodels/DatabaseSettings.js"></script>
<script src="backup/gui/viewmodels/NewBackupPanel.js"></script>
<script src="backup/gui/viewmodels/BrowseBackupsPanel.js"></script>
<script src="backup/gui/viewmodels/QuickBackupPanel.js"></script>
<script src="backup/gui/viewmodels/PrivateKeyPanel.js"></script>
<script src="backup/gui/viewmodels/main.js"></script>
<style>
#contenu ul { margin-left: 0px!important; }  
.checkbox { margin: 5px;padding: 2px;}
.alert {padding: 5px 10px;margin: 10px 0;}
</style>

<!-- ko with: passwordPanel -->
<div class="modalBackground">
	<div class="modalPanel">
		<form class="nomargin">
			<input type="password" id="password" data-bind="value: password">
			<button type="submit" data-bind="click: submit" class="btn " >OK</button>
		</form>
	</div>
</div>
<!-- /ko -->
<!-- ko with: globalError -->
<div class="modalBackground">
	<div class="alert modal Panel alert-danger">
		<h4 data-bind="text: title">Erreur !</h4>
		<span data-bind="text: text"></span>
	</div>
</div>
<!-- /ko -->

<div id="container" class="container-fluid" style="display: none;">

	<div class="row-fluid"> 
		<div id="content" class="span12">
			<div id="alertsContainer" data-bind="foreach: alerts">
				<div class="row">
					<div class="alert span12" data-bind="css: { 'alert-warning': type == 'warning', 'alert-danger': type == 'error', 'alert-success': type == 'success' }">
						<button class="btn pull-right" data-dismiss="alert">×</button>
						<h4 data-bind="text: title">Attention !</h4>
						<span data-bind="text: message"></span>
					</div>
				</div>
			</div>

			<!-- ko with: popup -->
			<div id="popup" class="modal fade" role="dialog">
				<div class="modal-dialog"> 
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="btn pull-right" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" data-bind="text: title"></h4>
						</div>
						<div class="modal-body">
							<p data-bind="text: message"></p>
						</div>
						<div class="modal-footer">
							<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Fermer</a>
							<!-- ko foreach: buttons -->
							<a href="#" class="btn" data-bind="text: text, click: click, css: styles"></a>
							<!-- /ko -->
						</div>
					</div>
				</div> 
			</div>
			<!-- /ko --> 

			<!-- ko if: restoringBackup -->
			<div class="row">
				<i class="fa fa-spinner fa-4x rotation"></i>
				<h2 style="width: 100%;text-align: center;margin-top: 30px">Restauration de la sauvegarde...</h3>
				<h4 style="width: 100%;text-align: center;">Durée variable en fonction du nombre de fichiers à sauvegarder... <span style="color: red">ne pas fermer cette page !</span></h4>
			</div>
			<!-- /ko -->

			<!-- ko if: creatingBackup -->
			<div class="row">
				<i class="fa fa-spinner fa-4x rotation"></i> 
				<h2 style="width: 100%;text-align: center;margin-top: 30px">Sauvegarde en cours...</h3>
				<h4 style="width: 100%;text-align: center;">Durée variable en fonction de la taille de la base de données... <span style="color: red">ne pas fermer cette page !</span></h4>
			</div>
			<!-- /ko -->

			<!-- ko with: newBackupPanel -->
			<div class="row">
				<button class="btn btn-primary pull-left" data-bind="click: $root.back"><i class="fa fa-arrow-left fa-1x"></i> Retour au menu</button>
				
				<p id="clear">&nbsp;</p> 

				<form class="form-horizontal metro-form">
					
					<h3>Infos</h3>
					<div class="control-group">
						<label>Nom de la sauvegarde</label>
						<div class="controls">
							<input type="text" id="title" data-bind="value: title, enable: !isEdit()"> 
						</div>
					</div>
					
					<p id="clear">&nbsp;</p>
				
					<h3>Dossiers et fichiers

					<button class="btn btn-mini btn-info" type="button" title="Sauvegarder des dossiers" data-bind="click: showDirTree, visible: !sourceTreeVisible()">
						<i class="fa fa-plus fa-1x"></i>
					</button>
					<button class="btn btn-mini btn-info" type="button" title="Ne pas sauvegarder de dossier" data-bind="click: hideDirTree, visible: sourceTreeVisible">
						<i class="fa fa-times fa-1x"></i>
					</button></h3>
					
					<div class="control-group" data-bind="visible: !sourceTreeVisible()">
						<div class="controls">
							<p>Pour ajouter des dossiers et fichiers à votre sauvegarde cliquez le bouton au dessus</p>
						</div>
					</div>

					<div data-bind="visible: sourceTreeVisible">
						<div class="control-group">
							<label>Dossiers</label>
							<div class="controls">
								<div id="source" data-bind="component: dirTree" class="alert alert-warning"></div> 
							</div>
						</div>
						
						<p id="clear">&nbsp;</p> 
						
						<div class="control-group">
							<label>Extensions à exclure</label>
							<div class="controls">
								<input type="text" id="ignores" data-bind="value: ignores">
								<p class="alert alert-info">Séparer par des ; et utiliser * pour tous les noms de fichiers</p>
							</div>
						</div>
					</div> 

					<p id="clear">&nbsp;</p>
				
					<h3>Base de données

					<button class="btn btn-mini btn-info" type="button" title="Sauvegarder la BDD" data-bind="click: addDatabase, visible: !hasDatabase()">
						<i class="fa fa-plus fa-1x"></i>
					</button>
					<button class="btn btn-mini btn-info" type="button" title="Ne pas sauvegarder la BDD" data-bind="click: removeDatabase, visible: hasDatabase">
						<i class="fa fa-times fa-1x"></i>
					</button></h3>

					<div class="control-group" data-bind="visible: !hasDatabase()">
						<div class="controls">
							<p>Pour enregistrer la base de données cliquez le bouton au dessus</p>
						</div>
					</div>

					<div data-bind="with: database">
						<div class="control-group" data-bind="css: {error: host.hasModError}">
							<label>Hôte</label>
							<div class="controls">
								<input id="dbhost" type="text" data-bind="value: host" />

								<p class="alert alert-info" data-bind="visible: host.hasModError, text: host.errorMessage"></p>
							</div>
						</div>
						<div class="control-group" data-bind="css: {error: port.hasModError}">
							<label>Port</label>
							<div class="controls">
								<input id="dbport" type="text" class="input-small" data-bind="value: port" />

								<p class="alert alert-info" data-bind="visible: port.hasModError, text: port.errorMessage"></p>
							</div>
						</div>
						<div class="control-group" data-bind="css: {error: user.hasModError}">
							<label>Utilisateur</label>
							<div class="controls">
								<input id="dbuser" type="text" data-bind="value: user" />

								<p class="alert alert-info" data-bind="visible: user.hasModError, text: user.errorMessage"></p>
							</div>
						</div>
						<div class="control-group">
							<label>Mot de passe</label>
							<div class="controls">
								<input id="dbpassword" type="password" data-bind="value: password" />
							</div>
						</div>

						<p id="clear">&nbsp;</p> 
					
						<div class="control-group">
							<div class="controls">
								<button class="btn" type="button" data-bind="click: getTree, enabled: !isLoading()">
									<i class="fa fa-spinner fa-1x rotation" data-bind="visible: isLoading"></i> 
									<span data-bind="text: isLoading() ? 'Connexion...' : 'Connecter'">Connect</span>
								</button>
								<span style="color: red;" data-bind="text: connectionError"></span>
							</div>
						</div>

						<p id="clear">&nbsp;</p> 
						
						<div class="control-group" data-bind="visible: tree() != null">
							<label>Base de données</label>
							<div class="controls">
								<div id="dest2" class="alert alert-warning" data-bind="component: tree"></div> 
							</div>
						</div>
					</div> 
				
					<p id="clear">&nbsp;</p> 
				
					<h3>Destination</h3>

					<div class="control-group">
						<label>Type</label>
						<div class="controls">
							<select id="destType" data-bind="value: destType">
								<option value="local">Local</option>
								<option value="ftp">Remote FTP</option> 
							</select>
						</div>
					</div>
					<div class="control-group" data-bind="visible: destType() == 'ftp' || destType() == 'sftp'">
						<label>Hôte</label>
						<div class="controls">
							<input type="text" id="ftpHost" data-bind="value: ftpHost">
						</div>
					</div>
					<div class="control-group" data-bind="visible: destType() == 'ftp' || destType() == 'sftp'">
						<label>Identifiant</label>
						<div class="controls">
							<input type="text" id="ftpUser" data-bind="value: ftpUser">
						</div>
					</div>
					
					<div class="control-group" data-bind="visible: destType() == 'ftp' || destType() == 'sftp'">
						<div class="controls">
							<button class="btn" type="button" data-bind="click: getFTPTree, enabled: !ftpLoading()">
										<i class="fa fa-spinner fa-1x rotation" data-bind="visible: ftpLoading"></i> 
								<span data-bind="text: ftpLoading() ? 'Connexion...' : 'Connexion'">Connexion</span>
							</button>
							<span style="color: red;" data-bind="text: ftpError"></span>
						</div>
					</div>

					<p id="clear">&nbsp;</p> 
						
					<div class="control-group" data-bind="visible: destType() != 'dropbox'">
						<label>Dossier de destination des sauvegardes</label>
						<div class="controls">
							<div id="dest" data-bind="visible: destType() == 'local', component: dirTreeDestination" class="alert alert-warning"></div>
							<div id="dest2" data-bind="visible: destType() == 'ftp' || destType() == 'sftp', component: ftpDirTreeDestination" class="alert alert-warning"></div> 
						</div>
					</div>
					
					<p id="clear">&nbsp;</p>
				
					<h3>Fréquence</h3>
					<div class="control-group">
						<label>Type</label>
						<div class="controls">
							<select id="type" data-bind="value: type">
								<option value="xhours">Chaque X heure</option>
								<option value="daily">1 x par jour</option>
								<option value="xdays">Chaque X jours à X heure</option>
								<option value="weekly">1 x par semaine</option>
								<option value="monthly">1 x par mois</option>
							</select>
						</div>
					</div>
					<div class="control-group" data-bind="visible: type() == 'monthly'">
						<label>Chaque X du mois</label>
						<div class="controls">
							<select class="input-small" id="day" data-bind="value: day">
								<option value="1">1</option><option value="2">2</option>
								<option value="3">3</option><option value="4">4</option>
								<option value="5">5</option><option value="6">6</option>
								<option value="7">7</option><option value="8">8</option>
								<option value="9">9</option><option value="10">10</option>
								<option value="11">11</option><option value="12">12</option>
								<option value="13">13</option><option value="14">14</option>
								<option value="15">15</option><option value="16">16</option>
								<option value="17">17</option><option value="18">18</option>
								<option value="19">19</option><option value="20">20</option>
								<option value="21">21</option><option value="22">22</option>
								<option value="23">23</option><option value="24">24</option>
								<option value="25">25</option><option value="26">26</option>
								<option value="27">27</option><option value="28">28</option>
								<option value="29">29</option><option value="30">30</option>
							</select>
						</div>
					</div>
					<div class="control-group" data-bind="visible: type() == 'weekly'">
						<label>Chaque X de la semaine</label>
						<div class="controls">
							<select class="input-medium" id="weekDay" data-bind="value: weekDay">
								<option value="0">Lundi</option>
								<option value="1">Mardi</option>
								<option value="2">Mercredi</option>
								<option value="3">Jeudi</option>
								<option value="4">Vendredi</option>
								<option value="5">Samedi</option>
								<option value="6">Dimanche</option>
							</select>
						</div>
					</div>
					<div class="control-group" data-bind="css: {error: xdays.hasModError}, visible: type() == 'xdays'">
						<label>Tous les X jours</label>
						<div class="controls">
							<input type="text" class="input-small" id="xdays" data-bind="value: xdays">

							<p class="alert alert-info" data-bind="visible: xdays.hasModError, text: xdays.errorMessage"></p>
						</div>
					</div>
					<div class="control-group" data-bind="css: {error: xhours.hasModError}, visible: type() == 'xhours'">
						<label>Toutes les X heures</label>
						<div class="controls">
							<input type="text" class="input-small" id="xhours" data-bind="value: xhours">

							<p class="alert alert-info" data-bind="visible: xhours.hasModError, text: xhours.errorMessage"></p>
						</div>
					</div>
					<div class="control-group" data-bind="css: {error: time.hasModError}, visible: type() != 'xhours'">
						<label>A X heure</label>
						<div class="controls">
							<input type="text" class="input-small" id="time" data-bind="value: time">

							<p class="alert alert-info" data-bind="visible: time.hasModError, text: time.errorMessage"></p>
						</div>
					</div>
					
					<p id="clear">&nbsp;</p> 
				
					<h3>Autres options</h3>

					<div class="control-group"> 
						<div class="controls">
							<label><input type="checkbox" data-bind="checked: keeplastxenabled" /> Garder uniquement les X sauvegardes</label>
						</div>
					</div>

					<div class="control-group" data-bind="css: {error: keeplastx.hasModError}, visible: keeplastxenabled">
						<label>Nombre</label>
						<div class="controls">
							<input type="text" class="input-small" id="keeplastx" data-bind="value: keeplastx" />

							<p class="alert alert-info" data-bind="visible: keeplastx.hasModError, text: keeplastx.errorMessage"></p>
						</div>
					</div>

					<p id="clear">&nbsp;</p>
					
					<div class="control-group"> 
						<div class="controls">
							<label><input type="checkbox" data-bind="checked: emailMe" /> M'informer après chaque sauvegarde</label>
						</div>
					</div>

					<div class="control-group" data-bind="css: {error: email.hasModError}, visible: emailMe">
						<label>Email</label>
						<div class="controls">
							<input type="text" id="email" data-bind="value: email" />

							<p class="alert alert-info" data-bind="visible: email.hasModError, text: email.errorMessage"></p>
						</div>
					</div>
						
					<p id="clear">&nbsp;</p>

					<div class="form-actions">
						<button type="submit" class="btn btn-large btn-success pull-right" data-bind="enable: isValid, click: submit, text: isEdit() ? 'Enregistrer' : 'Enregistrer'"></button>
					</div>
				</form>
			</div>
			<!-- /ko -->
			<!-- ko with: browseBackupsPanel -->
			
			<div class="row">
				<!-- ko if: data().length > 0 -->
				<div data-bind="foreach: data">
				
					<button class="btn btn-success" type="button" title="Sauvegarder maintenant !"
						data-bind="click: backup"><i class="fa fa-play fa-1x"></i>
					</button>
					
					<button class="btn pull-right btn-primary" type="button" title="Paramètres"
						data-bind="click: function() {$root.editBackup(title);}"><i class="fa fa-cog fa-1x"></i>
					</button>

					<p id="clear">&nbsp;</p> 

					<!-- ko if: archives().length > 0 -->
					<table class="table table-hover table-striped table-responsive tablesorter" id="listebackups">
						<thead> 
							<th>Date</th>
							<th>Taille</th>
							<th>Actions</th>
						</thead>
						<tbody data-bind="foreach: archives"> 
							<td data-bind="text: date"></td>
							<td data-bind="text: prettySize"></td>
							<td style="text-align:right;">
								<button class="btn " type="button" title="Restaurer" data-bind="click: restore">
									<i class="fa fa-fast-backward fa-1x"></i>
								</button>&nbsp;
								<button class="btn btn-success" type="button" title="Télécharger" data-bind="click: download, visible: !nodownload">
									<i class="fa fa-download fa-1x"></i>
								</button>&nbsp;
								<button class="btn btn-danger" type="button" title="Supprimer" data-bind="click: remove">
									<i class="fa fa-trash-o fa-1x"></i>
								</button>
							</td>
						</tbody>
					</table>
					
					<!-- /ko -->

					<!-- ko if: archives().length == 0 -->
					<h3 style="clear: both;">Rien à afficher</h3>
					<!-- /ko -->
				</div>
				<!-- /ko -->
				<!-- ko if: data().length == 0 -->
				<h3>Rien à afficher</h3>
				<!-- /ko -->
			</div>
			<!-- /ko -->
			<!-- ko if: isIndex --> 
			<!-- /ko -->
		</div>
	</div>
</div>
