window.addEvent('domready', function() {

	// label kludge for formatting
	var kludge = '<label for="kludge"><!-- empty --></label>';
	
	$('loginForm').addEvent('submit', function(e) {
		// prevents the default submit event from loading a new page
		new Event(e).stop();
		
		// validate fields	
		if ($('user').get('value') == "") {
			$('response').set('html', kludge 
					+ "<p class='error'>A username is required</p>");
			// set focus to username
			$("user").focus();
		} else if ($('pass').get('value') == "") {
			$('response').set('html', kludge 
					+ "<p class='error'>A password is required</p>");
			// set focus to password
			$("pass").focus();
		} else {
		
			// show the waiter when pressing the submit button...
			$('waiting').setStyle('visibility', 'visible');

			// disable the submit button while processing...
			$('submit').set('disabled', true);

			// set the options of the form's Request handler.
			this.set('send', { onComplete: function(response) {
				$('waiting').setStyle('visibility', 'hidden');

				// act on the response
				switch (response) {
					case "OK":
						// enable the submit button
						$('submit').set('disabled', false);
				
						$('status').set('html', '<div id="logged_in"><p>You are now logged in! <br />' +
							'<img align="absmiddle" src="' + config['image.dir'] + '/loader-bar.gif">' +
							'<br>Please wait while we redirect you to your home page...</p></div>');

						// go to home page
						setTimeout('go_to_home_page()', 3000);
						break;
					case "INVALID_USER":
						$('response').set('html', kludge 
								+ "<p class='error'>The user does not exist</p>");
			  
						// enable the submit button
						$('submit').set('disabled', false);
				
						$("user").focus();
						break;
					case "INACTIVE_USER":
						$('response').set('html', kludge 
								+ "<p class='error'>The user has not yet been activated</p>");
			  
						// enable the submit button
						$('submit').set('disabled', false);
				
						$("user").focus();
						break;							
					case "INVALID_PASSWORD":
						$('response').set('html', kludge 
								+ "<p class='error'>The password is incorrect</p>");
					  
						// enable the submit button
						$('submit').set('disabled', false);
			
						$("pass").focus();
						break;
					default:
						$('response').set('html', kludge 
								+ "<p class='error'>Error logging in</p>");
					  
						// enable the submit button
						$('submit').set('disabled', false);
			
						$("user").focus();
				}
			}});

			// send the form.
			this.send();
		}
	});
	
	// set focus to username
	$("user").focus();
});

// navigate to users home page
function go_to_home_page() {
	window.location = 'admin/users/index.php'; 
}
