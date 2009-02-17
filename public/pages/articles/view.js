window.addEvent('domready', function() {

	// regular expression for verifying email
	var emailReg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;;
	
	$('commentForm').addEvent('submit', function(e) {
		// prevents the default submit event from loading a new page
		new Event(e).stop();
		
		// validate fields	
		if ($('name').get('value') == "") {
			$('response').set('html',  
				"<p class='invalid'>Your <b>name</b> is required.</p>");
			// set focus to name
			$("name").focus();
		} else if ($('email').get('value') == "") {
			$('response').set('html', 
				"<p class='invalid'>Your <b>email</b> is required.</p>");
			// set focus to email
			$("email").focus();
		} else if (emailReg.test($('email').get('value')) == false) {
			$('response').set('html', 
				"<p class='invalid'>Your <b>email</b> address is invalid.</p>");
				// set focus to email
				$("email").focus();		
		} else if ($('commentText').get('value') == "") {
			$('response').set('html',  
				"<p class='invalid'>A <b>comment</b> is required.</p>");
			// set focus to comment
			$("commentText").focus();
		} else if ($('catchpaText').get('value') == "") {			
			$('response').set('html',  
				"<p class='invalid'>You are required to enter the text shown in the <b>catchpa</b> image.</p>");
			// set focus to catchpa
			$("catchpaText").focus();				
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
						$('response').set('html', 
							'<p><b>Comment successfully submitted, reloading page...</b></p>' +
							'<br><img align="left" src="' + config['image.dir'] + '/loader-bar.gif">');
						// reload page
						setTimeout('reload()', 3000);
						break;	
					case "INVALID_ARGS":
						$('response').set('html',  
							"<p class='invalid'>Error submitting comment, invalid arguments.</p>");
						$("name").focus();
						break;
					case "INVALID_EMAIL":
						$('response').set('html',  
							"<p class='invalid'>Your <b>email</b> address is invalid.</p>");		
						$("email").focus();	
						break;
					case "INVALID_CATCHPA":
						$('response').set('html',  
							"<p class='invalid'>The <b>catchpa</b> you entered is incorrect, please try again.</p>");
						
						// reload the catchpa
						$("catchpa").set('src', config['site_prefix'] +
								'/include/securimage/securimage_show.php?' + Math.random());

						$("catchpaText").focus();	
						break;
					case "DATABASE_ERROR":
						$('response').set('html',  
							"<p class='invalid'>Error submitting comment to the database.</p>");		
						$("name").focus();	
						break;						
					default:
						$('response').set('html',  
							"<p class='invalid'>Error submitting comment.</p>");			
						$("name").focus();
				}
				
				// enable the submit button
				$('submit').set('disabled', false);
	
			}});

			// send the form.
			this.send();
		}
	});
	
});

// reload the page
function reload() {
	window.location = window.location.href; 
}
