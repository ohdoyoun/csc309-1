var Controller = (new function (){
	var self = this;
	self.urls = {};
	self.pageModel = null;
	self.navigation = new NavigationModel();
		
	self.init = function(properties)
	{
		self.pageModel = new PageModel(properties.pageModel);
		self.urls = properties.urls;
		self.navigation.changeCurrentNavigation("Account");
		
		ko.applyBindings(this);
	}

}());

$(".header-link").click(function(){
		var navLink = $(this).attr('data-nav');
		Controller.navigation.changeCurrentNavigation(navLink);
	});