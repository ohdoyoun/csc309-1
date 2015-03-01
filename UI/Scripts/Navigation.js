NavigationModel = function(){
	var self = this;
	self.urls = {};
	
	self.setupProfilePage = function(){	};
	
	self.setupWalletPage = function(){	};
	
	self.setupAccountSettingsPage = function(){	};
	
	self.setupNotifications = function(){	};
	
	self.setupMyProjectsPage = function(){	};
	
	self.setupBackedProjectsPage = function(){	};
	
	self.setupDiscoverProjectsPage = function(){	};
	
	self.setupCreateProjectsPage = function(){	};
	
	self.setupGlobalStatsPage = function(){	};
	
	self.setupActiveCommunitiesPage = function(){	};
	
	self.setupCommunityListPage = function(){	};
	
	self.setupDashboardPage = function(){	};
	
	self.setupStatsPage = function(){	};
	
	self.setupBackerInfoPage = function(){	};
	
	self.setupSurveysPage = function(){	};
	
	self.setupPrivateMessagesPage = function(){	};
	
	self.navigation = {
		Account: {
			"Profile":{content:"Account/Profile", setupCallback:self.setupProfilePage},
			"Wallet":{content:"Account/Wallet", setupCallback:self.setupWalletPage},
			"Account Settings":{content:"Account/AccountSettings", setupCallback:self.setupAccountSettingsPage},
			"Notifications":{content:"Account/Notifications", setupCallback:self.setupNotifications}
		},
		Projects: {
			"My Projects":{content:"Projects/ProjectLists/MyProjects", setupCallback:self.setupMyProjectsPage},
			"Backed Projects":{content:"Projects/ProjectLists/BackedProjects", setupCallback:self.setupBackedProjectsPage},
			"Discover Projects":{content:"Projects/ProjectLists/DiscoverProjects", setupCallback:self.setupDiscoverProjectsPage},
			"Create Project":{content:"Projects/CreateProject", setupCallback:self.setupCreateProjectsPage},
			"Statistics":{content:"Projects/GlobalStatistics", setupCallback:self.setupGlobalStatsPage}
		},
		Communities: {
			"Active Communities":{content:"Communities/ActiveCommunities", setupCallback:self.setupActiveCommunitiesPage},
			"Community List":{content:"Communities/CommunityList", setupCallback:self.setupCommunityListPage}
		},
		ProjectDetails:{
			"Dashboard":{content:"Projects/Dashboard", setupCallback:self.setupDashboardPage},
			"Statistics":{content:"Projects/Statistics", setupCallback:self.setupStatsPage},
			"Backer Information":{content:"Projects/BackerInformation", setupCallback:self.setupBackerInfoPage},
			"Surveys":{content:"Projects/Surveys/Surveys", setupCallback:self.setupSurveysPage},
			"Private Messages":{content:"Projects/PrivateMessages", setupCallback:self.setupPrivateMessagesPage}
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