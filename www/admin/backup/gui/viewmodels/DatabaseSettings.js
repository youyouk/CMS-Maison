function DatabaseSettings(data) {
	var self = this;

	var isEdit = true;
	if (typeof data === "undefined") {
		data = {
			host: 'xxxxxxxxxxxxxxx',
			port: 3306,
			user: 'xxxxxxxxxxxxxxx',
			password: 'xxxxxxxxxxxxxxx',
			databases: ['xxxxxxxxxxxxxxx'],
			tables: []
		};
		isEdit = false;
	}

	/* Properties */
	this.host = ko.observable(data.host).extend({
        validation: {
            required: true,
            message: "Hôte requis"
        }
    });

	this.user = ko.observable(data.user).extend({
        validation: {
            required: true,
            message: "Identifiant requis"
        }
    });

	this.port = ko.observable(data.port).extend({
        validation: {
            required: true,
            message: "Port 3306 par défaut",
			func: function (value) {
				return !isNaN(value) && parseInt(value) > 0;
			}
        }
    });
	
	this.password = ko.observable(data.password);
	
	this.databases = ko.observableArray(data.databases);
	
	this.tables = ko.observableArray(data.tables);


	this.isLoading = ko.observable(false);
	this.connectionError = ko.observable('');

	/* Computed */
	this.isValid = ko.computed(function () {
    	return self.host.isValid() && self.user.isValid() && self.port.isValid();
    });

    /* Components */
    this.tree = ko.observable(null);

    /* Helpers */
    function loadTree(databases) {
    	if (self.tree() === null) {
    		return;
    	}

    	function getNode(name, parent) {
    		var treeData = parent;

    		for (var i = treeData.length - 1; i >= 0; i--) {
    			if (name === treeData[i].name()) {
    				return treeData[i];
    			}
    		}

    		return null;
    	}

    	for (var i = databases.length - 1; i >= 0; i--) {
    		var dbNode = getNode(databases[i].name, self.tree().data());

    		if (dbNode !== null) {
    			dbNode.selected(databases[i].selected);

    			var tables;
    			var shouldInclude = !databases[i].selected;
    			if (databases[i].selected) {
    				tables = databases[i].excluded;
    			}
    			else {
    				tables = databases[i].included;
    			}

    			if (typeof tables !== 'undefined') {
	    			for (var j = tables.length - 1; j >= 0; j--) {
	    				var tblNode = getNode(tables[j], dbNode.children());

	    				if (tblNode !== null) {
	    					tblNode.selected(shouldInclude);
	    				}
	    			};
    			}
    		}
    	}
    }

    /* Methods */
    this.getSelected = function() {
		var databases = [];

		if (self.tree() === null)
			return databases;

		function getSelectedTables(database) {
			var db = {};
			db.name		= database.name();
			db.selected = !!database.selected();
			db.included = [];
			db.excluded = [];

			var tables = database.children();
			var hasSelectedTable = false;
			for (var i = tables.length - 1; i >= 0; i--) {
				
				if (!db.selected && tables[i].selected()) {
					db.included.push(tables[i].name());
				}
				else if (db.selected && !tables[i].selected()) {
					db.excluded.push(tables[i].name());
				}

				if (tables[i].selected()) {
					hasSelectedTable = true;
				}
			}

			if (db.selected || hasSelectedTable) {
				databases.push(db);
			}
		}

		var tree = self.tree().data();
		for (var i = tree.length - 1; i >= 0; i--) {
			getSelectedTables(tree[i]);
		};

		return databases;
	};

    this.getTree = function () {
    	self.tree(new TreeView({
    		url: 'backup/api/index.php?path=/getDatabaseTree&host=' + encodeURIComponent(self.host()) + '&port=' + self.port() + '&user=' + encodeURIComponent(self.user()) + '&password=' + encodeURIComponent(self.password()) + '&key=' + Application.password(),
    		selectable: true,
			dirSelectMode: true,
    		dataLoading: function () {
				self.isLoading(true);
				self.connectionError('');
			},
			dataLoaded: function () {
				self.isLoading(false);
				self.connectionError('');
    			loadTree(data.databases);
			},
			dataError: function (target, isRoot) {
				self.isLoading(false);
				
				if (isRoot)
					self.connectionError("Erreur de connexion SQL - root");
				else
					self.connectionError("Erreur de connexion SQL");
			}
    	}));
    };

    if (isEdit) {
    	this.getTree();
    }
}