window.addEvent('domready', function() {

	var articleId = $('articleId').get('value');
	
	new FormValidator($('commentForm'), "Successfully added comment, reloading page...",
		{
			redirect: true,
			redirectURL: CONFIG.site_prefix + "/pages/articles/view.php?id=" +
				articleId 
		}
	);
	
	$('reload').addEvent('click', function(e) {
		new Event(e).stop();
		
		// reload the catchpa
		$("catchpa").set('src', CONFIG.site_prefix +
			'/include/securimage/securimage_show.php?' + Math.random());
	});
	
	
});

