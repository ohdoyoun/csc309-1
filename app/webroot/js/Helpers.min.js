Helpers = (new function(){
	var self = this;
	
	self.LoadPartial = function(element, location, callback){
	    $.get('../'+location, function(data) {
            $(element).html(data);
            callback();
        });
	};
	
	self.UnloadPartial = function(element){
		$(element).remove();
	};
}()); 