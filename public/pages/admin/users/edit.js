window.addEvent('domready', function() {

	// listen for click events on the submit button.
	$('userEditForm').addEvent('submit', function(e){
		// stops the submission of the form.
		new Event(e).stop();
		
		// show the waiter when pressing the submit button...
		$('waiting').setStyle('visibility', 'visible');

		// disable the submit button while processing...
		$('submit').set('disabled', true);

		// set the options of the form's Request handler.
		this.set('send', { onComplete: function(response) {
			$('waiting').setStyle('visibility', 'hidden');

			if (response == 'OK') {
              $('response').set('html', 'User updated succesfully.');
			  // enable the submit button
              $('submit').set('disabled', false);            
			} else {
			  $('response').set('html', 'Error updating user.');
			  // enable the submit button
			  $('submit').set('disabled', false); 
			}
		}});

		// send the form.
		this.send();
		
	});
	
	// focus on first field

	
});
