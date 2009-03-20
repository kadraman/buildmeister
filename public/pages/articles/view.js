window.addEvent('domready', function() {

	// form validation
	var articleTitle = $('articleTitle').get('value');	
	new FormValidator($('commentForm'), "Successfully added comment, reloading page...",
		{
			redirect: true,
			redirectURL: CONFIG.rewrite_prefix + "/articles/" +	articleTitle 
		}
	);
	
	// reload the catchpa
	$('reload').addEvent('click', function(e) {
		new Event(e).stop();
		
		// reload the catchpa
		$("catchpa").set('src', CONFIG.site_prefix +
			'/include/securimage/securimage_show.php?' + Math.random());
	});
	
	// hack for fckeditor
	$('submit').addEvent('click', function() {
		$('commentText').value = FCKeditorAPI.GetInstance('commentText').GetXHTML();
	});
	
	// delete comments
	$$('a.deleteComment').each(function(link) {
		link.addEvent('click', function(e) {
			e.preventDefault();			
			//alert('clicked delete on ' + link.id);
			new StickyWinModal({
				content: StickyWin.ui('Delete Comment', 'Are you sure you want to delete this comment?', {
					width: '400px',
				    buttons: [
                    {
				        text: 'Yes', 
				        onClick: function(){alert('ok!')}
				    },
				    {
				        text: 'No', 
				        onClick: function(){alert('cancelled!')}
				    }
				    ]
				})
			});
		});
	});
	
	new SmoothScroll({ duration:700 }, window); 	
	
});

