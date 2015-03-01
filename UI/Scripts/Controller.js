var Controller = (new function (){
	var self = this;
	self.urls = {};
	self.pageModel = null;
	self.navigation = new NavigationModel();
		
	self.init = function(properties)
	{
		self.pageModel = new PageModel(properties.pageModel);
		self.navigation.init();
		self.urls = properties.urls;
		self.navigation.changeCurrentNavigation("Account");
		ko.applyBindings(self.navigation, document.getElementById("navigation"))
	}

}());