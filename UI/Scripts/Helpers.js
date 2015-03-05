Helpers = (new function(){
	var self = this;
	
	self.LoadPartial = function(element, location){
	    $.get('../'+location, function(data) {
            $(element).html(data);
        });
	};
	
	self.UnloadPartial = function(element){
		$(element).remove();
	};
}()); 