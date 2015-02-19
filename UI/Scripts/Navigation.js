NavigationModel = function(){
	var self = this;
	self.urls = {};
	
	self.navigation = {
		Account: {
			"Profile":"",
			"Wallet":"",
			"Account Settings":"",
			"Notifications":""
		},
		Projects: {
			"My Projects":"",
			"Backed Projects":"",
			"Discover Projects":"",
			"Create Project":"",
			"Statistics":""
		},
		Communities: {
			"Active Communities":"",
			"Community List":""
		},
		ProjectDetails:{
			"Dashboard":"",
			"Statistics":"",
			"Backer Information":"",
			"Surveys":"",
			"Private Mesages":""
		}
	};
	
	self.navigationItems = ko.observableArray();
	self.currentNavigation = ko.observable();
	
	self.changeCurrentNavigation = function(value){
		if(self.navigation[value]){
			var newNavigations = [];
			$.each(self.navigation[value], function(name, url){
				newNavigations.push({ text: name, url: url});
			});
			self.navigationItems.removeAll();
			self.navigationItems.push.apply(self.navigationItems, newNavigations);
			self.currentNavigation(value);
		}
	};
}