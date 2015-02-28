NavigationModel = function(){
	var self = this;
	self.urls = {};
	
	self.fakeSetupCallback = function(){};
	
	self.setupProfilePage = function(){
		
	};
	
	self.navigation = {
		Account: {
			"Profile":{content:"Account/Profile", setupCallback:self.setupProfilePage},
			"Wallet":{content:"Account/Wallet", setupCallback:self.fakeSetupCallback},
			"Account Settings":{content:"Account/AccountSettings", setupCallback:self.fakeSetupCallback},
			"Notifications":{content:"Account/Notifications", setupCallback:self.fakeSetupCallback}
		},
		Projects: {
			"My Projects":{content:"Projects/ProjectLists/MyProjects", setupCallback:self.fakeSetupCallback},
			"Backed Projects":{content:"Projects/ProjectLists/BackedProjects", setupCallback:self.fakeSetupCallback},
			"Discover Projects":{content:"Projects/ProjectLists/DiscoverProjects", setupCallback:self.fakeSetupCallback},
			"Create Project":{content:"Projects/CreateProject", setupCallback:self.fakeSetupCallback},
			"Statistics":{content:"Projects/GlobalStatistics", setupCallback:self.fakeSetupCallback}
		},
		Communities: {
			"Active Communities":{content:"Communities/ActiveCommunities", setupCallback:self.fakeSetupCallback},
			"Community List":{content:"Communities/CommunityList", setupCallbackcallback:self.fakeSetupCallback}
		},
		ProjectDetails:{
			"Dashboard":{content:"Projects/Dashboard", setupCallback:self.fakeSetupCallback},
			"Statistics":{content:"Projects/Statistics", setupCallback:self.fakeSetupCallback},
			"Backer Information":{content:"Projects/BackerInformation", setupCallback:self.fakeSetupCallback},
			"Surveys":{content:"Projects/Surveys/Surveys", setupCallback:self.fakeSetupCallback},
			"Private Messages":{content:"Projects/PrivateMessages", setupCallback:self.fakeSetupCallback}
		}
	};
	
	self.navigationItems = ko.observableArray();
	self.currentNavigation = ko.observable();
	
	self.init = function(){
		$(".header-link").click(function(event){
			self.changeCurrentNavigation(event.target.attributes["data-nav"].value);
		});
		$("#navigation-links").click(function(event){
			var info = self.navigation[self.currentNavigation()][event.target.text];
			$("#main-body").remove.apply($("#main-body").children());
			Helpers.LoadPartial($("#main-body"),info.content);
			info.setupCallback();
		});
	};
	
	self.changeCurrentNavigation = function(value){
		if(self.navigation[value]){
			var newNavigations = [];
			$.each(self.navigation[value], function(name){
				newNavigations.push({text: name});
			});
			self.navigationItems.removeAll();
			self.navigationItems.push.apply(self.navigationItems, newNavigations);
			self.currentNavigation(value);
		}
	};

}