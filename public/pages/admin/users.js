window.addEvent('domready', function() {

	new FilterTable($('results'), 'users_retrieve.php', $('filterString'));
	
});