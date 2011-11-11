window.addEvent('domready', function() {

	// form validation
	var articleTitle = $('articleTitle').get('value');	
	new FormValidator($('commentForm'), "Successfully added comment, reloading page...",
		{
			redirect: true,
			redirectURL: "/articles/" +	articleTitle
		}
	);
	
	// reload the catchpa
	$('reload').addEvent('click', function(e) {
		new Event(e).stop();
		
		// reload the catchpa
		$("catchpa").set('src', CONFIG.site_prefix +
			'/include/securimage/securimage_show.php?' + Math.random());
	});
	
	// hack for fckeditor
	$('submit').addEvent('click', function() {
		$('commentText').value = FCKeditorAPI.GetInstance('commentText').GetXHTML();
	});
	
	// delete comments
	$$('a.deleteComment').each(function(link) {
		link.addEvent('click', function(e) {
			e.preventDefault();			
			new StickyWinModal({
				content: StickyWin.ui('Delete Comment', 'Are you sure you want to delete this comment?', {
					width: '400px',
				    buttons: [
                    {
				        text: 'Yes', 
				        onClick: function() {
                    	
                    		// delete the comment via ajax
                    		var req = new Request({
                    			method: 'post',
                    			url: CONFIG.site_prefix + 
                    				'/pages/articles/_comment.delete.php',
                    		    data: { 'cid' : link.id },
                    		    onComplete: function(response) { 
                    		    	// decode the JSON response
                					var status = JSON.decode(response);

                					// act on the response
                					if (status.code) {
                						// successful, reload the page
                						window.location = "/articles/" + articleTitle
                					} else {
                						alert("Error: " + status.message);
                					}
                    		    }	
                    		}).send();
                    	}
				    },
				    {
				        text: 'No', 
				        onClick: function(){ 
				    		// ignore 
				    	}
				    }
				    ]
				})
			});
		});
	});
	
	// delete the article
	if ($('articleDelete')) {
		$('articleDelete').addEvent('click', function(e) {
			e.preventDefault();	
		
			// the id of the article
			var aid = $('articleId').get('value');
		
			new StickyWinModal({
				content: StickyWin.ui('Delete Article', 'Are you sure you want to delete this article?', {
					width: '400px',
					buttons: [
					{
			            text: 'Yes', 
			            onClick: function() {
                	
                			// delete the comment via ajax
                			var req = new Request({
                				method: 'post',
                				url: CONFIG.site_prefix + 
                					'/pages/articles/_article.delete.php',
                				data: { 'id' : aid },
                		        onComplete: function(response) { 
                					// decode the JSON response
                					var status = JSON.decode(response);

                					// act on the response
                					if (status.code) {
                						// successful, reload the page
                						window.location = CONFIG.site_prefix + 
            							    '/pages/articles/';
                					} else {
                						alert("Error: " + status.message);
                					}
                				}	
                			}).send();
                		}
					},
					{
						text: 'No', 
						onClick: function(){ 
			    			// ignore 
			    		}
					}
					]
				})
			});
		});
	}
	
	// smooth scrolling between page links
	new SmoothScroll({ duration:700 }, window); 	
	
});

