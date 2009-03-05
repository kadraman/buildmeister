var FormValidator = new Class({
	Implements: [Options, Events],
	options: {			
	redirect: false,
	redirectURL: "",
	enableSubmitOnComplete: false
},		
initialize: function(form, successText, options) {
	this.setOptions(options);
	this.form = $(form);
	this.successText = successText;
	this.attach();
},
attach: function() {

	// does the form exist?
	if (this.form) {
			  		
		this.form.addEvent('submit', function(e) {
			// prevents the default submit event from loading a new page
			new Event(e).stop();

			// TODO: client side validation
			var errors = 0;

			// remove error style from fields
			this.form.getElements('.error').each(function(input) {
				if (input.hasClass('error')) { 
					input.removeClass('error').morph({ 'border-color': '#ccc', 'background-color': '#fff' }); 
				}
			});
			
			// did we get any errors?
			if (errors)	{
				// TODO: handle client side validationn failures
			} else {

				// show the waiter when pressing the submit button...
				$('waiting').setStyle('visibility', 'visible');

				// disable the submit button while processing...
				$('submit').disabled = true;				

				// set the options of the form's Request handler.
				this.form.set('send', { onComplete: function(response) {

					// where we will place the response
					var responseDiv = this.form.getElement('#response');							

					$('waiting').setStyle('visibility', 'hidden');

					// decode the JSON response
					var status = JSON.decode(response);

					// act on the response
					if (status.code) {
						if (this.options.redirect) {
							if (responseDiv) {
								responseDiv.set('html',
										"<span class='success'><b>" + this.successText + "</b></span>" +
										"<br><img align='left' src='" + CONFIG.image_dir + "/loader-bar.gif'>");
								responseDiv.setStyles({ 'opacity': '0', 'display': 'block' });
								responseDiv.morph({ 'opacity': '1' });
							} else {
								alert(this.successText)
							}
							// redirect to new page
							setTimeout(function() { 
								window.location = this.options.redirectURL;
							}.bind(this), 3000);	
						} else {
							if (responseDiv) {
								responseDiv.set('html',
										"<span class='success'><b>" + this.successText + "</b></span>");
								responseDiv.setStyles({ 'opacity': '0', 'display': 'block' });
								responseDiv.morph({ 'opacity': '1' });
							} else {
								alert(this.successText)
							}
							// re-enable the submit button
							if (this.enableSubmitOnComplete) {
								$('submit').disabled = false;
							}
						}
					} else {
						if (responseDiv) {
							responseDiv.set('html',
									"<span class='error'>" + status.message + "</span>");
							responseDiv.setStyles({ 'opacity': '0', 'display': 'block' });
							responseDiv.morph({ 'opacity': '1' });
						} else {
							alert(status.message)
						}
						if ($(status.field)) {
							$(status.field).addClass('error').morph({ 'border-color': '#f00', 'background-color': '#ffebe8' });
							$(status.field).focus();
						}	
						// re-enable submit button
						$('submit').disabled = false;
					} // response

				}.bind(this)});

				// send the form.
				this.form.send();
			}
		}.bind(this));
	}

}
});