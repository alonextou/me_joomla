
/*
$(document).ready(function(){
	alert('going');
	var modal = $.UIkit.modal(".cmd_search_modal");
	modal.show();
})
*/

// Only load on our component
/*
$(document).ready(function(){
	if ($('#cmd-search-form').length > 0 ) {
		var cmd_search = new Cmd_search;
		cmd_search.init();
	}
});
*/

// you should have a live state variable, to know if
// the search is in AJAX, and can re-begin searching
// each time another checkbox is checked, to feel fast.
/*
$(document).ready(function(){
	$('#cmd-search-submit').attr('disabled', false);
	$("#cmd-search-form").submit(function(event) {
		event.preventDefault();
		var facets = $(this).serialize();
		$.cmd_search.getResults(facets);
	});
});
*/

// Plugin
/*
(function($){
	
    $.cmd_search = $.cmd_search || {};

    $.cmd_search.defaultOptions = {
    	search_url: "http://j3es.dev/index.php?option=com_cmd_search&task=search.postForm&format=raw"
	};

    $.cmd_search.getResults = function(facets) {
		alert(facets);
	};

	function debug() {
        console.log('debugging');
    };

    /*
	$.fn.cmd_search = function(action) {
 
        if (action === "search") {
			alert('open');
        }
 
        $.newFunction = function(str) {
		    return str.replace( /^\s+/, "" );
		};
 
    };
 
}(jQuery));
*/

/*
Cmd_search.init = (function() {
    var internalState = "Message";

    var privateMethod = function() {
        // Do private stuff, or build internal.
        return internalState;
    };
    var publicMethod = function() {
        return privateMethod() + " stuff";
    };

    return {
        someProperty: 'prop value',
        publicMethod: publicMethod
    };
})();

Cmd_search.search = function(){

	var self = this;

	self.init = function() {

		//self.postForm();

		$('#cmd-search-submit').attr('disabled', false);

		$( "#cmd-search-form" ).submit(function(event) {
			event.preventDefault();
			self.formParams = $(this).serialize();
			console.log(self.formParams);
			self.postForm();
		});

	}

	self.postForm = function() {
		self.phrase = $('#cmd-search-input').val();
		self.results;

		$.ajax({
			url: 'index.php/?option=com_cmd_search&task=search.getResults&format=raw',
			data: self.formParams
		}).done(function(xhr) {
			self.results = xhr;
			console.log(self.results);
			$('#results').html(self.results)
		}).fail(function(xhr, status, error) {
			console.log(xhr.status + ": " + error);
		});
	}

}
*/