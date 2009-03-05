window.addEvent('domready', function() {

	Element.implement({
		flash: function(to,from,reps,prop,dur) {
			
			//defaults
			if (!reps) { reps = 1; }
			if (!prop) { prop = 'color'; }
			if (!dur)  { dur = 250; }
			
			//create effect
			var effect = new Fx.Tween(this, {
					duration: dur,
					link: 'chain'
				})
			
			//do it!
			for (x = 1; x <= reps; x++) {
				effect.start(prop,from,to).start(prop,to,from);
			}
		}
	});
	
	//$('searchKeywords').addEvents({
	//	'focus': function(){ if (this.value == 'Enter keyword(s)' ) this.value = ''; }, 
	//	'blur': function(){  if (!this.value) this.value = 'Enter keyword(s)';  },
	//});
	
	new LabelledInput({
        inputs: $$('input.labelled')
	});

	$('searchForm').addEvent('submit', function(e) {
		// prevents the default submit event from loading a new page
		new Event(e).stop();
		
		// validate fields	
		if ($('keywords').get('value') == "" || $('keywords').get('value') == "keywords") {
			$('keywords').set('value', 'keywords');
			// set focus to search keywords
			$("keywords").focus();
		} else {					
			var currentKeywords;
			//var currentTextColor = $('searchKeywords').getStyle('color');

			// disable the submit button while processing...
			$('searchSubmit').set('value','Searching...').disabled = true;

			// set the options of the form's Request handler.
			this.set('send', {
				onRequest: function()  { 
					currentKeywords = $('keywords').get('value');
					$('keywords').set('value', "Searching...");					
					//$('searchKeywords').flash(currentTextColor, '#FFF', 5, 'color', 500); 
				},
				onComplete: function(response) {											
					// act on the response
					$('content').set('html', response);

					// reset search keywords
					//$('searchKeywords').fx.cancel();
					//$('searchKeywords').set('color', '#000');
					$('keywords').set('value', currentKeywords);

					// enable the submit button
					$('searchSubmit').set('value','Submit').disabled = false;
				}
			});

			// send the form.
			this.send();
		}
	});
	
})
