window.addEvent('domready', function() {

	var busy = false;
	//var effect = $('results').effect('background-color', {duration: 800});
	//var periodical;

	//var fx = function() {
	//	effect.start('#000000').chain(function() {
	//		effect.start('#bcd965');
	//	});
	//}
	
	// load the specified users and set HTML
	var req = new Request.HTML({
		url: 'users_retrieve.php', 
		method: 'get',
		onRequest: function()  { 
			busy = true;
			//fx();
			//periodical = fx.periodical(1700);
			var div = $('waitingText').setStyles({
				display:'block',
				opacity: 0
			});
			//new Fx.Style(div, 'opacity', {duration: 1000} ).start(1);

			$('waiting').setStyle('visibility', 'visible'); 
		},
		update: $('results'),
		onComplete: function() {
			mp = $('maxPage').get('value').toInt();
			cp = $('curPage').get('value').toInt();
			pp = cp - 1; 			// previous page
			np = cp + 1; 			// next page
			users = $('numUsers').get('value');
			// disable buttons, based on where we are
			if (mp == 1) { 			// we have just one page
				$('firstButton').set('disabled', true);
				$('lastButton').set('disabled', true);
				$('nextButton').set('disabled', true);
				$('prevButton').set('disabled', true);
			} else if (cp == 1) {	// we have more than one page, but are on first
				$('firstButton').set('disabled', true);
				$('lastButton').set('disabled', false);
				$('nextButton').set('disabled', false);
				$('prevButton').set('disabled', true);
			} else if (cp == mp) { 	// we have more than one page, but are on last
				$('firstButton').set('disabled', false);
				$('lastButton').set('disabled', true);
				$('nextButton').set('disabled', true);
				$('prevButton').set('disabled', false);
			} else {				// we can go in either direction
				$('firstButton').set('disabled', false);
				$('lastButton').set('disabled', false);
				$('nextButton').set('disabled', false);
				$('prevButton').set('disabled', false);
			}
			$('numUsersLabel').set('text', "Found " + users + " matching entries");
			busy = false; 
			$('waiting').setStyle('visibility', 'hidden'); 
			//$clear(periodical);
		}
	});
	
	// when user enters search criteria
	$('searchString').addEvents({
	    'keyup': function(e) {
    		if (e.key == 'enter') {
    			new Event(e).stop();
    			$('searchString').fireEvent('update');
    		}
    	},
    	'blur': function(e) {
    		// ignore for now
    	},
    	'update': function() {
    		if (!busy) {	
    			cp = $('curPage').get('value').toInt();
    			req.send('searchstring=' + $('searchString').get('value') +
    					"&page=" + cp.toString() +
    					"&rows="  + $('rowsString').get('value') +
    					"&time=" + ($random(0,100) - $time()).toString());
    		}
    	}
	});
	
	// when user selects previous
	$('prevButton').addEvent('click', function(e) {
		if (!busy) {
			new Event(e).stop();
			pp = $('curPage').get('value').toInt() - 1;
			req.send('searchstring=' + $('searchString').get('value') +
					"&page=" + pp.toString() +
					"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());
		}
	});
	
	// when user selects next
	$('nextButton').addEvent('click', function(e) {
		if (!busy) {
			new Event(e).stop();
			np = $('curPage').get('value').toInt() + 1;
			req.send('searchstring=' + $('searchString').get('value') +
					"&page=" + np.toString() +
					"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());		
		}
	});
	
	// when user selects first
	$('firstButton').addEvent('click', function(e) {
		if (!busy) {
			new Event(e).stop();
			mp = $('maxPage').get('value').toInt();
			req.send('searchstring=' + $('searchString').get('value') +
					"&page=1" +
					"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());
		}
	});	
	
	// when user selects last
	$('lastButton').addEvent('click', function(e) {
		if (!busy) {
			new Event(e).stop();
			mp = $('maxPage').get('value').toInt();
			req.send('searchstring=' + $('searchString').get('value') +
					"&page=" + mp.toString() +
					"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());		
		}
	});
	
	// when user selects rows to show
	$('rowsString').addEvents({
	    'keyup': function(e) {
	    	if (e.key == 'enter') {
	    		new Event(e).stop();
	    		$('rowsString').fireEvent('update');
	    	}
	    },
    	'blur': function(e) {
	    	// ignore for now
	    },
	    'update': function() {
    		if (!busy) {	
    			cp = $('curPage').get('value').toInt();
    			req.send('searchstring=' + $('searchString').get('value') +
    				"&page=" + cp.toString() +
    				"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());
	    	}
	    }
	});
	
	// when user selects last
	$('allRows').addEvent('click', function(e) {
		if (!busy) {
			new Event(e).stop();
			mp = $('maxPage').get('value').toInt();
			req.send('searchstring=' + $('searchString').get('value') +
					"&rows=0" +
					"&time=" + ($random(0,100) - $time()).toString());		
		}
	});
	
	// load defaults, first page
	req.send('time=' + ($random(0,100) - $time()).toString());

});