window.addEvent('domready', function() {

	new FormValidator($('registrationForm'), "Thank you, your registration details have been received. "
			+ "<br>You will shortly receive an email with instructions on how to complete the registration process. "
			+ "<br>If you do not receive an email please check your email spam folder."
	);
	
	if ($('reload')) {
		$('reload').addEvent('click', function(e) {
			new Event(e).stop();
		
			// reload the catchpa
			$("catchpa").set('src', '/include/securimage/securimage_show.php?' + Math.random());
		});
	}
	
});	
