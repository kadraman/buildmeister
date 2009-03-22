window.addEvent('domready', function() {

	// form validation
	new FormValidator($('editForm'), "Your changes have been saved...",
		{
			enableSubmitOnComplete: true,
			alertOnComplete: true
		}
	);
	
	// hack for fckeditor
	$('submit').addEvent('click', function() {
		$('contentText').value = FCKeditorAPI.GetInstance('contentText').GetXHTML();
	});
	
	// go back to the article
	$('cancel').addEvent('click', function() {
		var articleTitle = $('title').get('value');
		articleTitle = articleTitle.replace(/ /g, "_")
		window.location = CONFIG.rewrite_prefix + "/articles/" 
			+ articleTitle.toLowerCase(); ;
	});
	
	new SmoothScroll({ duration:700 }, window); 	
	
});

