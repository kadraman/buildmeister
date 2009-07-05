window.addEvent('domready', function() {

	new FilterTable($('results'), '_articles.select.php', 'state');
		
});