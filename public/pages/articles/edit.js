window.addEvent('domready', function() {

	// form validation
	var articleTitle = $('articleTitle').get('value');
	new FormValidator($('editForm'), "Successfully updated article, reloading page...",
		{
			redirect: true,
			redirectURL: CONFIG.rewrite_prefix + "/articles/" +	articleTitle 
		}
	);
	
	// hack for fckeditor
	$('submit').addEvent('click', function() {
		$('contentText').value = FCKeditorAPI.GetInstance('contentText').GetXHTML();
	});
	
	new SmoothScroll({ duration:700 }, window); 	
	
});

