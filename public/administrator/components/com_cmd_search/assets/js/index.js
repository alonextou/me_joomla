
// Only load on our component
jQuery(document).ready(function(){
	var cmd_search = new Cmd_search();
	cmd_search.init();
});

function Cmd_search() {

	var self = this;
	self.results;

	self.init = function() {
		
		jQuery( "#cmd-index-articles" ).click(function(event) {
			event.preventDefault();;
			self.postIndexAll('article');
		});

	}

	self.postIndexAll = function(typeThing) {

		self.phrase = jQuery('#cmd-search-input').val();

		// TODO: secure with token

		jQuery.ajax({
			url: '/administrator/index.php/?option=com_cmd_search&task=search.indexAll&format=raw',
			data: { type: typeThing }
		}).done(function(xhr) {
			self.results = xhr;
			alert('Finished indexing ' + self.results.articles.length + ' articles.');
		}).fail(function(xhr, status, error) {
			console.log(xhr.status + ": " + error);
		});
	}

}