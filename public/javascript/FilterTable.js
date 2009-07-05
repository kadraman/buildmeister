var FilterTable = new Class({
	initialize: function(container, loadScript, column) {
		this.container = $(container);
		this.script = loadScript;	
		this.defSortColumn = column;
		// TODO: validate parameters
		this.attach();
	},
	attach: function() {
		var curPage = 1;						// the current page
		var maxPages = 1;						// the maximum number of pages
		var prevPage = 1;						// the previous page
		var nextPage = 1;						// the next page
		var numEntries = 0;						// the number of entries found
		var sortColumn = this.defSortColumn;	// the table column to sort on
		var sortDirection = "";					// the sort direction, default is ASC
		
		var busy = false;
		var req = new Request.HTML({
			url: this.script, 
			method: 'get',
			evalScripts: true,
			onRequest: function()  { 
				busy = true;
				$('waiting').setStyle('visibility', 'visible'); 
			},
			update: $(this.container),
			onComplete: function() {
				// TODO: check if fields exist and validate input
				maxPages = $('maxPage').get('value').toInt();
				curPage  = $('curPage').get('value').toInt();
				prevPage = curPage - 1; 			// previous page
				nextPage = curPage + 1; 			// next page
				numEntries = $('numEntries').get('value');
				// disable buttons, based on where we are
				if (maxPages == 1) { 			// we have just one page
					$('firstButton').set('disabled', true);
					$('lastButton').set('disabled', true);
					$('nextButton').set('disabled', true);
					$('prevButton').set('disabled', true);
				} else if (curPage == 1) {	// we have more than one page, but are on first
					$('firstButton').set('disabled', true);
					$('lastButton').set('disabled', false);
					$('nextButton').set('disabled', false);
					$('prevButton').set('disabled', true);
				} else if (curPage == maxPages) { 	// we have more than one page, but are on last
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
				// TODO: check if label exists
				$('numEntriesLabel').set('text', "Found " + numEntries + " matching entries");
				busy = false; 
				$('waiting').setStyle('visibility', 'hidden'); 
				
				// when user selects a column to sort
				$$('a.sortable').each(function(link) {
					link.addEvent('click', function(e) {
						e.preventDefault();	
						// does the sort column already have a value?
						if (sortColumn == link.id) {
							// if so, change sort direction
							if (sortDirection == 'DESC') {
								sortDirection = "";
							} else {
								sortDirection = 'DESC';
							}
						} else {
							sortColumn = link.id;
							sortDirection = '';
						}
						// fire an update
						$('filterString').fireEvent('update');
					});
				});
			}
		});
		
		// when user enters search criteria
		$('filterString').addEvents({
			'keyup': function(e) {
    			if (e.key == 'enter') {
    				new Event(e).stop();
    				$('filterString').fireEvent('update');
    			}
    		},
    		'blur': function(e) {
    			// ignore for now
    		},
    		'update': function() {
    			if (!busy) {	
    				req.send('searchstring=' + $('filterString').get('value') +
    					"&searchcolumn=" + $('filterColumn').get('value') +
    					"&sortcolumn=" + sortColumn +
    					"&sortdirection=" + sortDirection +
    					"&page=1" +
    					"&rows="  + $('rowsString').get('value') +
    					"&time=" + ($random(0,100) - $time()).toString());
    			}
    		}
		});
		
		// when user selects filter
		$('filterButton').addEvent('click', function(e) {
   			$('filterString').fireEvent('update');
		});
		
		// when user selects reset
		$('resetButton').addEvent('click', function(e) {
			$('filterString').set('value', "");
   			$('filterString').fireEvent('update');
		});
	
		// when user selects previous
		$('prevButton').addEvent('click', function(e) {
			if (!busy) {
				new Event(e).stop();
				req.send('searchstring=' + $('filterString').get('value') +
					"&searchcolumn=" + $('filterColumn').get('value') +
					"&sortcolumn=" + sortColumn +
					"&sortdirection=" + sortDirection +
					"&page=" + prevPage.toString() +
					"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());
			}
		});
	
		// when user selects next
		$('nextButton').addEvent('click', function(e) {
			if (!busy) {
				new Event(e).stop();
				req.send('searchstring=' + $('filterString').get('value') +
					"&searchcolumn=" + $('filterColumn').get('value') +
					"&sortcolumn=" + sortColumn +
					"&sortdirection=" + sortDirection +
					"&page=" + nextPage.toString() +
					"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());		
			}
		});
	
		// when user selects first
		$('firstButton').addEvent('click', function(e) {
			if (!busy) {
				new Event(e).stop();
				req.send('searchstring=' + $('filterString').get('value') +
					"&searchcolumn=" + $('filterColumn').get('value') +	
					"&sortcolumn=" + sortColumn +
					"&sortdirection=" + sortDirection +
					"&page=1" +
					"&rows="  + $('rowsString').get('value') +
					"&time=" + ($random(0,100) - $time()).toString());
			}
		});	
	
		// when user selects last
		$('lastButton').addEvent('click', function(e) {
			if (!busy) {
				new Event(e).stop();
				req.send('searchstring=' + $('filterString').get('value') +
					"&searchcolumn=" + $('filterColumn').get('value') +	
					"&sortcolumn=" + sortColumn +
					"&sortdirection=" + sortDirection +
					"&page=" + maxPages.toString() +
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
	    			req.send('searchstring=' + $('filterString').get('value') +
	    					"&searchcolumn=" + $('filterColumn').get('value') +	
	    					"&sortcolumn=" + sortColumn +
	    					"&sortdirection=" + sortDirection +
	    					"&page=" + curPage.toString() +
	    					"&rows="  + $('rowsString').get('value') +
	    					"&time=" + ($random(0,100) - $time()).toString());
	    		}
	    	}
		});
	
		// when user selects last
		$('allRows').addEvent('click', function(e) {
			if (!busy) {
				new Event(e).stop();
				req.send('searchstring=' + $('filterString').get('value') +
					"&searchcolumn=" + $('filterColumn').get('value') +	
					"&sortcolumn=" + sortColumn +
					"&sortdirection=" + sortDirection +
					"&rows=0" +
					"&time=" + ($random(0,100) - $time()).toString());		
			}
		});						
		
		// load defaults, first page
		req.send('time=' + ($random(0,100) - $time()).toString());
	}
});