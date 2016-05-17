function PasswordPanel() {
	var self = this;
	
	this.title = ko.observable(" ");
	this.password = ko.observable("");
	
	this.submit = function() {
		amplify.request({
			resourceId: "checkPassword",
			data: {
				password: self.password()	
			},
			success: function (data) {
				if (data.result) {
					Application.password(self.password());
					Application.onLogin();
					Application.hidePasswordPanel();
					$('#container').show();
				} else {
					 self.title('Erreur'); 
				}
			},
			error: function (data) {
				Application.passwordPanel(null);
				Application.globalError({ title: "Erreur de connexion", text: "Essayez de rafraîchir la page" });
			}
		});
	};
	
	/* Constructor */
	amplify.request({
		resourceId: "hasPassword",
		data: {},
		success: function (data) {
			if (!data.result) {
				Application.passwordPanel(null);
				Application.globalError({ title: "Erreur de configuration", text: "Changez le mot de passe" });
			}
		},
		error: function (data) {
			Application.passwordPanel(null);
			Application.globalError({ title: "Erreur de connexion", text: "Essayez de rafraîchir la page" });
		}
	});
}