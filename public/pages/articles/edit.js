window.addEvent('domready', function() {
	
	// does the edit form exist?
	if ($('editForm')) {
		$('editForm').addEvent('submit', function(e) {
			// prevents the default submit event from loading a new page
			new Event(e).stop();
		
			// validate fields	
			if ($('title').get('value') == "") {
				$('response').set('html',  
					"<p class='invalid'>An article <b>title</b> is required.</p>");
				// set focus to title
				$("title").focus();
			} else if ($('summary').get('value') == "") {
				$('response').set('html', 
					"<p class='invalid'>An article <b>summary</b> is required.</p>");
				// set focus to summary
				$("summary").focus();
			} else if ($('dateposted').get('value') == "") {
				$('response').set('html', 
					"<p class='error'>The <b>date posted</b> of the article is required.</p>");
				// set focus to dateposted
				$("dateposted").focus();				
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
								'<p><b>Article successfully saved, reloading article view...</b></p>' +
								'<br><img align="left" src="' + config['image.dir'] + '/loader-bar.gif">');
							// go to article
							setTimeout('go_to_article()', 3000);
							break;	
						case "INVALID_ARGS":
							$('response').set('html',  
								"<p class='invalid'>Error saving article, invalid arguments.</p>");
							$("title").focus();
							break;					
						case "DB_ERROR":
							$('response').set('html',  
								"<p class='invalid'>Error saving article to the database.</p>");		
							$("title").focus();	
							break;						
						default:
							$('response').set('html',  
								"<p class='invalid'>Error saving article.</p>");			
							$("title").focus();
					}
				}});

				// send the form.
				this.send();
			}
		});	
	}
	
});

// navigate back to article view
function go_to_article() {
	window.location = 'view.php?id=' + $('articleId').get('value'); 
}
