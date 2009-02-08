window.addEvent('domready', function() {

	var SITE_BASEDIR = "/buildmeister.com/public/";
	
	Element.implement({
		flash: function(to,from,reps,prop,dur) {
			
			//defaults
			if(!reps) { reps = 1; }
			if(!prop) { prop = 'color'; }
			if(!dur) { dur = 250; }
			
			//create effect
			var effect = new Fx.Tween(this, {
					duration: dur,
					link: 'chain'
				})
			
			//do it!
			for(x = 1; x <= reps; x++)
			{
				effect.start(prop,from,to).start(prop,to,from);
			}
		}
	});
	
	var searchReq = new Request.HTML({
		url: SITE_BASEDIR + 'search.php', 
		method: 'get',
		onRequest: function() {
			$('searchMessage').set('html', "<br/><strong>Loading results...</strong>");
			$('searchMessage').flash('#000', '#AAA', 5, 'color', 500);
			$('searchMessage').setStyle('visibility', 'visible');
		},
		update: $('content'),
		onComplete: function() {
			$('searchMessage').setStyle('visibility', 'hidden');
			$('searchMessage').set('html', "");			 
		}
	});
	
	$('searchKeywords').addEvents({
		'focus': function(){ if (this.value == 'Enter keyword(s)' ) this.value = ''; }, 
		'blur': function(){  if (!this.value) this.value = 'Enter keyword(s)';  },
		'keydown': function(event){ 
			if (event.key == 'enter') {
				searchReq.send('searchKeywords=' + $('searchKeywords').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());
			}
		}
	});
	
	// when user selects search
	$('searchButton').addEvent('click', function(e) {
		searchReq.send('searchKeywords=' + $('searchKeywords').get('value') +
				"&time=" + ($random(0,100) - $time()).toString());
	});
	
})
