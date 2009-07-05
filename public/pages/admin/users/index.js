window.addEvent('domready', function() {

	new FilterTable($('results'), '_comments.select.php', 'date_posted');
		
});