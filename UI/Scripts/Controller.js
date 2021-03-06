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
		var isAuthed = $("#is-authed").attr("data-value") === '1';
		self.navigation.changeCurrentNavigationType(isAuthed ? 0 : 1 );
		ko.applyBindings(self.navigation, document.getElementById("navigation"))
		ko.applyBindings(self.navigation, document.getElementById("header"))
	}

}());