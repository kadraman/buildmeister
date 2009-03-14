window.addEvent('domready', function() {

	$('loginForm').addEvent('submit', function(e) {
		// prevents the default submit event from loading a new page
		new Event(e).stop();
		
		// where we will place the response
		var responseDiv = $('loginForm').getElement('#response');
		
		// where we will redirect to on login
		var redirectURL = CONFIG.rewrite_prefix
		    + '/users/' + $('user').get('value'); 
		
		// remove error style from fields
		this.getElements('.error').each(function(input) {
			if (input.hasClass('error')) { 
				input.removeClass('error').morph({ 'border-color': '#ccc', 'background-color': '#fff' }); 
			}
		});
		
		// validate fields	
		if ($('user').get('value') == "") {
			responseDiv.set('html', 
				"<span class='error'>A <b>username</b> is required.</span>");
			responseDiv.setStyles({ 'opacity': '0', 'display': 'block' });
			responseDiv.morph({ 'opacity': '1' });
			$("user").addClass('error').morph({ 'border-color': '#f00', 'background-color': '#ffebe8' });
			$("user").focus();
		} else if ($('pass').get('value') == "") {
			responseDiv.set('html', 
				"<span class='error'>A <b>password</b> is required.</span>");
			responseDiv.setStyles({ 'opacity': '0', 'display': 'block' });
			responseDiv.morph({ 'opacity': '1' });
			$("pass").addClass('error').morph({ 'border-color': '#f00', 'background-color': '#ffebe8' });
			$("pass").focus();
		} else {
		
			// show the waiter when pressing the submit button...
			$('waiting').setStyle('visibility', 'visible');

			// disable the submit button while processing...
			$('submit').set('disabled', true);

			// set the options of the form's Request handler.
			this.set('send', { onComplete: function(response) {
				$('waiting').setStyle('visibility', 'hidden');

				// decode the JSON response
				var status = JSON.decode(response);
				
				// act on the response
				if (status.code) {
					// successful login
					
					// enable the submit button
					$('submit').set('disabled', false);
				
					$('status').set('html', "<span class='success'><b>You are now logged in!</b><br />" +
						"<img align='absmiddle' src='" + CONFIG.image_dir + "/loader-bar.gif'>" +
						"'<br>Please wait while we redirect you to your home page...</span></div>");

					// go to home page
					setTimeout(function() { 
						window.location = redirectURL;
					}, 3000);	
				} else {
					// failed login
					
					// enable the submit button
					$('submit').set('disabled', false);
					
					responseDiv.set('html',
						"<span class='error'>" + status.message + "</span>");
					responseDiv.setStyles({ 'opacity': '0', 'display': 'block' });
					responseDiv.morph({ 'opacity': '1' });
					if ($(status.field)) {
						$(status.field).addClass('error').morph({ 'border-color': '#f00', 'background-color': '#ffebe8' });
						$(status.field).focus();
					}
				}
			}});

			// send the form.
			this.send();
		}
	});
	
	// set focus to username
	$("user").focus();
});
