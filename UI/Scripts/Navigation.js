NavigationModel = function(){
	var self = this; 
	self.urls = {};
	
	self.navigationItems = ko.observableArray();
	self.currentNavigation = ko.observable();
	self.headerItems = ko.observableArray();
	self.currentNavType = ko.observable();
	self.currentPid = ko.observable();
	
	self.emptySetup = function(){	};
	
	self.setupMyProjectsPage = function(){
	    $("#my-projects .project-link").on("click", function(event){
	        self.currentPid(13);
			self.changeCurrentNavigation("ProjectDetails");
		});
	};
	
	self.setupPrivateMessagesPage = function(){	};
	self.landingPages = {
		Account: "Profile",
		Projects: "My Projects",
		Communities: "Active Communities",
		ProjectDetails:"Dashboard",
		Login:"Login",
		Logout:"Logout",
		Register:"Register"
	};
	
	self.navigation = {
		Account: {
			navNum:0,
			"Profile":{content:"profiles/edit", setupCallback:self.emptySetup},
			"Wallet":{content:"Account/Wallet", setupCallback:self.emptySetup},
			"Account Settings":{content:"profiles/settings", setupCallback:self.emptySetup},
			"Notifications":{content:"profiles/notifications", setupCallback:self.emptySetup}
		},
		Projects: {
			navNum:0,
			"My Projects":{content:"projects/mine", setupCallback:self.setupMyProjectsPage},
			"Backed Projects":{content:"projects/backed", setupCallback:self.emptySetup},
			"Discover Projects":{content:"projects", setupCallback:self.emptySetup},
			"Create Project":{content:"projects/create", setupCallback:self.emptySetup},
			"Statistics":{content:"Projects/GlobalStatistics", setupCallback:self.emptySetup}
		},
		Communities: {
			navNum:0,
			"Active Communities":{content:"Communities/ActiveCommunities", setupCallback:self.emptySetup},
			"Community List":{content:"Communities/CommunityList", setupCallback:self.emptySetup}
		},
		ProjectDetails:{
			navNum:2,
			"Dashboard":{content:"projects/view/{pId}", setupCallback:self.emptySetup},
			"Statistics":{content:"Projects/Statistics", setupCallback:self.emptySetup},
			"Backer Information":{content:"Projects/BackerInformation", setupCallback:self.emptySetup},
			"Surveys":{content:"Projects/Surveys/Surveys", setupCallback:self.emptySetup},
			"Private Messages":{content:"Projects/PrivateMessages", setupCallback:self.emptySetup}
		},
		Logout:{
			navNum:0,
			"Logout":{content:"users/logout", setupCallback:self.emptySetup, hidden:true}			
		},
		Login:{
			navNum:1,
			"Login":{content:"users/login", setupCallback:self.emptySetup, hidden:true}
		},
		Register:{
			navNum:1,
			"Register":{content:"users/register", setupCallback:self.emptySetup, hidden:true}
		}
	};
	
	ko.computed(function(){
		var items = [];
		var navNum = self.currentNavType();
		$.each(self.navigation, function(name, value){
			if(value.navNum === navNum){
				items.push({name:name, nav:name});
			}
		});
		self.headerItems(items);
	});	
	
	self.changePage = function(page){
		var info = self.navigation[self.currentNavigation()][page];
		$("#main-body").remove.apply($("#main-body").children());
		var pageUrl = info.content.replace("{pId}", self.currentPid());
		Helpers.LoadPartial($("#main-body"), pageUrl, info.setupCallback);
		
		$("#flashMessage").hide();
	};
	
	self.changeCurrentNavigationType = function(int){
	    self.currentNavType(int);
	    self.changeCurrentNavigation(self.headerItems()[0].nav);
	}
	
	self.changeCurrentNavigation = function(value){
		if(self.navigation[value]){
			var newNavigations = [];
			$.each(self.navigation[value], function(name, content){
				if(!content.hidden && content.content){
					newNavigations.push({text: name});
				}
			});
			self.navigationItems.removeAll();
			self.navigationItems.push.apply(self.navigationItems, newNavigations);
			self.currentNavigation(value);
			self.changePage(self.landingPages[value])
		}
	};
	
	self.init = function(){
		$(".header-bar").on("click", "a.header-link", function(event){
		    if(event.target.hasAttribute("data-nav")){
			    self.changeCurrentNavigation(event.target.attributes["data-nav"].value);
		    }
		});
		$("#navigation-links").on("click", "a.nav-link" ,function(event){
		    if(event.target.hasAttribute("data-nav")){
			    self.changePage(event.target.attributes["data-nav"].value);
		    }
		});
	};
}