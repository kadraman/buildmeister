window.addEvent('domready', function() {

	new FilterTable($('results'), 'select.php', $('filterString'));
	
});