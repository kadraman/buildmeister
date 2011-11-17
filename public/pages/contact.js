window.addEvent('domready', function() {
	
	new FormValidator($('contactForm'), "Your message has been sent, thank you for your feedback..."
	);
	
	$('reload').addEvent('click', function(e) {
		new Event(e).stop();
		
		// reload the catchpa
		$("catchpa").set('src', '/include/securimage/securimage_show.php?' + Math.random());
	});
	
	// hack for fckeditor
	$('submit').addEvent('click', function() {		
		$('messageText').value = FCKeditorAPI.GetInstance('messageText').GetXHTML();
	});
	
	
});

