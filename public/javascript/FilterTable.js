var FilterTable = new Class({
	initialize: function(container, loadScript) {
		this.container = $(container);
		this.script = loadScript;		
		this.attach();
	},
	attach:function() {
		var busy = false;
		var req = new Request.HTML({
			url: this.script, 
			method: 'get',
			onRequest: function()  { 
				this.busy = true;
				$('waiting').setStyle('visibility', 'visible'); 
			},
			update: $(this.container),
			onComplete: function() {
				mp = $('maxPage').get('value').toInt();
				cp = $('curPage').get('value').toInt();
				pp = cp - 1; 			// previous page
				np = cp + 1; 			// next page
				entries = $('numEntries').get('value');
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
				$('numEntriesLabel').set('text', "Found " + entries + " matching entries");
				this.busy = false; 
				$('waiting').setStyle('visibility', 'hidden'); 
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
    				req.send('searchstring=' + $('searchString').get('value') +
    					"&searchcolumn=" + $('searchColumn').get('value') +
    					"&page=1" +
    					"&rows="  + $('rowsString').get('value') +
    					"&time=" + ($random(0,100) - $time()).toString());
    			}
    		}
		});
		
		// when user selects filter
		$('filterButton').addEvent('click', function(e) {
   			$('searchString').fireEvent('update');
		});
		
		// when user selects reset
		$('resetButton').addEvent('click', function(e) {
			$('searchString').set('value', "");
   			$('searchString').fireEvent('update');
		});
	
		// when user selects previous
		$('prevButton').addEvent('click', function(e) {
			if (!busy) {
				new Event(e).stop();
				pp = $('curPage').get('value').toInt() - 1;
				req.send('searchstring=' + $('searchString').get('value') +
					"&searchcolumn=" + $('searchColumn').get('value') +
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
					"&searchcolumn=" + $('searchColumn').get('value') +
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
					"&searchcolumn=" + $('searchColumn').get('value') +						
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
					"&searchcolumn=" + $('searchColumn').get('value') +						
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
	    					"&searchcolumn=" + $('searchColumn').get('value') +	    					
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
					"&searchcolumn=" + $('searchColumn').get('value') +						
					"&rows=0" +
					"&time=" + ($random(0,100) - $time()).toString());		
			}
		});
	
		// load defaults, first page
		req.send('time=' + ($random(0,100) - $time()).toString());
	}
});