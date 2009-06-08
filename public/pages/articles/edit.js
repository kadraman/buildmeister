window.addEvent('domready', function() {

	var saved = false;
	
	// form validation
	new FormValidator($('editForm'), "Your changes have been saved to the database.",
		{
			enableSubmitOnComplete: true,
			alertOnComplete: true
		}
	);
	
	// hack for fckeditor
	$('submit').addEvent('click', function() {
		$('contentText').value = FCKeditorAPI.GetInstance('contentText').GetXHTML();
		saved = true;
	});
	
	// go back to the article
	$('back').addEvent('click', function(e) {
		e.preventDefault();
		if (!saved) {
			new StickyWinModal({
				content: StickyWin.ui('Save changes', 
						"Are you sure you want to back to the article, any changes you have not saved will be lost?", {
					width: '400px',
					buttons: [
					{
					    text: 'Yes', 
			            onClick: function() { 
						    var articleTitle = $('articleTitle').get('value');						    
						    window.location = CONFIG.rewrite_prefix + "/articles/" 
							    + articleTitle.toLowerCase();
						}
			    	},
			    	{
			    	    text: 'No',
			    	    onClick: function() {
			    		    // ignore
			    	    }
			        }
			        ]
			    })
		    });
		} else {
			var articleTitle = $('articleTitle').get('value');						    
		    window.location = CONFIG.rewrite_prefix + "/articles/" 
			    + articleTitle.toLowerCase();
		}
	});
	
	// move to draft
	if ($('draft')) {
		$('draft').addEvent('click', function() {
			$('state').value = 2;
			saved = true;
			var articleTitle = $('articleTitle').get('value');						    
		    window.location = CONFIG.rewrite_prefix + "/articles/" 
			    + articleTitle.toLowerCase();
		});
	}
	
	// move to approve
	if ($('approve')) {
		$('approve').addEvent('click', function() {
			$('state').value = 3;
			saved = true;
			var articleTitle = $('articleTitle').get('value');						    
		    window.location = CONFIG.rewrite_prefix + "/articles/" 
			    + articleTitle.toLowerCase();
		});
	}
	
	// move to draft
	if ($('redraft')) {
		$('redraft').addEvent('click', function() {
			$('state').value = 2;
			saved = true;
			var articleTitle = $('articleTitle').get('value');						    
		    window.location = CONFIG.rewrite_prefix + "/articles/" 
			    + articleTitle.toLowerCase();
		});
	}
	
	// move to published
	if ($('publish')) {
		$('publish').addEvent('click', function() {
			$('state').value = 4;
			saved = true;
			var articleTitle = $('articleTitle').get('value');						    
		    window.location = CONFIG.rewrite_prefix + "/articles/" 
			    + articleTitle.toLowerCase();
		});
	}
	
	// move to withdrawn
	if ($('withdraw')) {
		$('withdraw').addEvent('click', function() {
			$('state').value = 5;
			saved = true;
			var articleTitle = $('articleTitle').get('value');						    
		    window.location = CONFIG.rewrite_prefix + "/articles/" 
			    + articleTitle.toLowerCase();
		});
	}
	
	new SmoothScroll({ duration:700 }, window); 	
	
});

