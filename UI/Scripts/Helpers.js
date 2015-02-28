Helpers = (new function(){
	var self = this;
	
	self.LoadPartial = function(element, location){
		$(element).load("../" + location + ".html"); 
	};
	
	self.UnloadPartial = function(element){
		$(element).remove();
	};
}());