function BrowseBackupsPanel() {
	var self = this;

	/* Properties */
	this.data = ko.observableArray([]);

	/* Methods */
	this.load = function () {
		$.getJSON('backup/api/index.php?path=/backups/get&key=' + Application.password(), function(data) {
			for (var i = data.length - 1; i >= 0; i--) {
				var obj = data[i];

				obj.archives = ko.observableArray([]);
				obj.removeConfirm = (function(obj){
					return function () {
						self.removeConfirm(obj.title);
					};
				})(obj);
				obj.backup = (function(obj){
					return function () {
						self.backup(obj.title);
					}
				})(obj);
			};

			self.data(data);
			self.loadArchives();
		});
	};

	this.loadArchives = function(){
		for (var i = self.data().length - 1; i >= 0; i--) {
			var obj = self.data()[i];

			(function(obj){
				$.getJSON('backup/api/index.php?path=/backups/getArchives&title=' + obj.title + '&key=' + Application.password(),
					function(data) {
						for (var i = data.length - 1; i >= 0; i--) {
							(function(archive) {
								archive.prettySize = ko.computed(function(){
									var i = 0;
									var byteUnits = [' bytes' , ' ko', ' Mo', ' Go', ' To', ' Po', ' Eo', ' Zo', ' Yo'];

									while (archive.size > 1024) {
										archive.size = archive.size / 1024;
										i++;
									}

									if (i > 0)
										return archive.size.toFixed(1) + byteUnits[i];
									else
										return archive.size + byteUnits[i];
								});

								archive.remove = function() {
									Application.showDialog('Confirmation', 'Confirmez-vous cette suppression ?', [{
									text: 'Supprimer',
									styles: {'btn-danger': true},
									click: function() {
										$.getJSON('backup/api/index.php?path=/archives/remove&title=' + encodeURIComponent(obj.title) + '&fileName=' + encodeURIComponent(archive.name) + '&key=' + Application.password(), function(info) {
											Application.alert('Réussite', "Sauvegarde supprimée",'success' );
											self.load();
										}).error(function (xhr) {
											//if (xhr.status == 400)
											//Application.alert('Echec', "Merci de recommencer", 'error');
											Application.alert('Réussite', "Sauvegarde supprimée",'success' );
											self.load();
										});
									}
									}]);
								};

								archive.download = function() {
									window.location = 'backup/api/index.php?path=/archives/download&title=' + encodeURIComponent(obj.title) + '&fileName=' + encodeURIComponent(archive.name) + '&key=' + Application.password();
								};

								archive.restore = function() {
									var archiveRestore = function(withDb, withFiles) {
										Application.showRestoringBackupPanel();

										$.getJSON('backup/api/index.php?path=/archives/restore&title=' + encodeURIComponent(obj.title) + '&fileName=' + encodeURIComponent(archive.name) + '&database=' + (withDb ? 'true' : 'false') + '&files' + (withFiles ? 'true' : 'false') + '&key=' + Application.password(), function(info) {
											Application.alert('success', "Sauvegarde restaurée",'success' );


											Application.hideRestoringBackupPanel();
										}).error(function (xhr) {
											//if (xhr.status == 400)
											Application.alert('Echec', "Merci de recommencer",'error' );

											Application.hideRestoringBackupPanel();
										});
									};


									Application.showDialog('Confirmation', 'Confirmez-vous la restauration de la sauvegarde ? Les fichiers non inclus dans la sauvegarde seront gardés. Vous allez pouvoir choisir de restaurer uniquement les fichiers, les données ou l\'ensemble de la sauvegarde.',
									[{
										text: 'Fichiers',
										styles: {'btn-danger': true},
										click: function() {
											archiveRestore(false, true);
										}
									},
									{
										text: 'Base de données',

										styles: {'btn-danger': true},
										click: function() {
											archiveRestore(true, false);
										}
									},
									{
										text: 'Fichiers ET données',
										styles: {'btn-danger': true},
										click: function() {
											archiveRestore(true, true);
										}
									}]);
								};
							})(data[i]);
						};

						/*data.sort(function(a, b) {
							return Date.parse(a.date) - Date.parse(b.date);
						});*/

						obj.archives(data);
					}
				);
			})(obj);
		};
	};

	this.removeConfirm = function (title) {
		Application.showDialog("Confirmation ?", "Souhaitez vous vraiment supprimer les paramètres de sauvegarde ? " +
			"Les archives de sauvegardes ne seront pas supprimées.",
			[{
				text: 'Enlever',
				styles: {'btn-danger': true},
				click: function () {
					self.remove(title);
				}
			}]);
	};

	this.remove = function (title) {
		$.get('backup/api/index.php?path=/backups/remove&title=' + title + '&key=' + Application.password(),
			function () {
				Application.alert('Réussite', "Paramètres supprimés", 'success');

				self.load();
			}).error(function (xhr) {
				//if (xhr.status == 400)
				Application.alert('Echec', "Merci de recommencer", 'error');
			});
	};

	this.backup = function (title) {
		Application.showCreatingBackupPanel();

		$.getJSON('backup/api/index.php?path=/backups/backup&title=' + title + '&key=' + Application.password(),
			function (data) {
				Application.alert('Réussite', "Sauvegarde enregistrée",'success' );

				for (var i = data.warnings.length - 1; i >= 0; i--) {
					Application.alert('warning', data.warnings[i], "Attention");
				}

				Application.hideCreatingBackupPanel();
			}).error(function (xhr) {
				Application.alert('Echec', "Merci de recommencer", 'error');

				Application.hideCreatingBackupPanel();
			});
	};

	/* Constructor */
	this.load();
}