function PrivateKeyPanel() {
	var self = this;

	this.name = ko.observable('').extend({
        validation: {
            required: true,
            message: "Requis"
        }
    });
	this.data = ko.observable('').extend({
        validation: {
            required: true,
            message: "Requis"
        }
    });

	this.isValid = ko.computed(function () {
    	return self.name.isValid() && self.data.isValid();
    });

	this.submit = function () {
		$.post('backup/api/index.php?path=/privatekeys/addKey&key=' + Application.password(),
		{
			name: self.name(),
			data: self.data()
		},
		function () {
			$('#private-key-panel').modal('hide');
			Application.privateKeyPanel(null);

			if (Application.newBackupPanel() != null) {
				Application.newBackupPanel().refreshSFTPKeys();
			}
		}).error(function (xhr) {
			Application.alert("Erreur !", "Ca a merdé !", 'error');
		});
	};
}