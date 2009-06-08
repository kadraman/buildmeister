window.addEvent('domready', function() {

	new FilterTable($('results'), '_users.select.php', $('filterString'));
		
});