/*
 * actionprocessors.js
 * - functions for hiding/displaying dialogs and saving/loading content via AJAX
 *
 */

/* 
 * ****************
 *
 * search functions
 *
 * ****************
 */
function processSearch() {
	var keywordsWidget = dijit.byId('searchKeywords');
	var keywordsValue = keywordsWidget.getValue();
	
	var myContent = {};
	myContent['keywords'] = keywordsValue;
	
	var getObj = {
        content:  myContent,
        url: "include/load_search_results.php",
        handleAs: "text",
        load: function(response) {
                dojo.byId('loadedContent').innerHTML = response;
        },
        error: function(data){
                alert("Error submitting search: " + data);
        },
        timeout: 2000
    };

	if (keywordsValue == "") {		
		keywordsWidget.displayMessage("A keyword is required.");
	} else {
		dojo.xhrGet(getObj);
	}
}
 
/* 
 * ************************
 *
 * comment dialog functions
 *
 * ************************
 */
function processComment() {

	var nameWidget = dijit.byId('commentName');
	var nameValue = nameWidget.getValue();	
	var emailWidget = dijit.byId('commentEmail');
	var emailValue = emailWidget.getValue();	
	var commentWidget = dijit.byId('commentText');
	var commentValue = commentWidget.getValue();	
	var postidWidget = dijit.byId('postid');
	var postidValue = postidWidget.getValue();

	var myContent = {};
	myContent['postid'] = postidValue;
	myContent['name'] = nameValue;
	myContent['email'] = emailValue;
	myContent['comment'] = commentValue;
	
	var postObj = {
        content:  myContent,
        url: "include/submit_comment.php",
        handleAs: "json",
        load: function(response) {
                if (response.valid) {
                    hideCommentDialog();
                	dojo.byId('commentResponse').innerHTML = "<p>Thankyou for your comment <b>" +
                		nameValue + "</b>; to prevent unwanted spam all comments are " +
                		"moderated. <br/>Your comment will be reviewed and added shortly.</p>";
                	emailWidget.setValue("");
                	commentWidget.setValue("");
                	dijit.byId("commentSubmitButton").setDisabled(true);
                    document.location.href = '#commentEnd';
                    dojo.fx.chain([
                		dojo.fadeOut({
                			node: dojo.byId("commentResponse"),
                			duration: 500
                		}),
                		dojo.fadeIn({
                			node: dojo.byId("commentResponse"),
                			duration: 500
                		})
					]).play()
                } else {
                	alert("Error submitting comment!");
                }
        },
        error: function(data){
                alert("Error submitting comment: " + data);
        },
        timeout: 2000
    };

	if (nameValue == "") {		
		nameWidget.displayMessage("Your name is required");
	} else {
		dojo.xhrPost(postObj);
	}
}

function showCommentDialog() {
	dijit.byId('commentDialog').show();
	//dijit.focus(dojo.byId('name'));
}	

function hideCommentDialog() {
	dijit.byId('commentName').displayMessage("");
	dijit.byId('commentDialog').hide();
}

/* 
 * **********************
 *
 * login dialog functions
 *
 * **********************
 */
function processLogin() {
	var usernameWidget = dijit.byId('loginUsername');
	var usernameValue = usernameWidget.getValue();
	var passwordWidget = dijit.byId('loginPassword');
	var passwordValue = passwordWidget.getValue();
	var postidWidget = dijit.byId('postid');
	var postidValue = postidWidget.getValue();
	
	var myContent = {};
	myContent['username'] = usernameValue;
	myContent['password'] = passwordValue;
	myContent['remember'] = "";
		
	var postObj = {
        content:  myContent,
        url: "include/login.php",
        handleAs: "json",
        load: function(response) {
                if (response.valid) {
                    hideLoginDialog();    
                	dojo.byId("usermenu").innerHTML = 
            	        "<li><a href=\"javascript:showSettingsDialog();\">Settings</a></li>\n" +
            	        "<li><a href=\"javascript:showQuickPostDialog();\">Quick Post</a></li>\n" +            	        
						"<li><a href=\"javascript:showPostAdminDialog();\">Post Administration</a></li>\n" +
						"<li><a href=\"javascript:processLogout();\">Logout</a></li>\n";
					dojo.byId("loginResponse").innerHTML = "";
                	dojo.byId('loginResponse').style.display = "none";
                } else {
                	//hideLoginDialog();
                	dojo.byId("loginResponse").innerHTML = "Incorrect details";
                	dojo.byId('loginResponse').style.display = "block";
                }
        },
        error: function(data){
                alert("Error logging in: " + data);
        },
        timeout: 2000
    };

	if (usernameValue == "") {		
		usernameWidget.displayMessage("Your username is required");
	} else if (passwordValue == "") {		
		passwordWidget.displayMessage("Your password is required");
	} else {
		dojo.xhrPost(postObj);
		/* TODO: check what we were last viewing and stay there */
        var contentPane = dijit.byId("loadedContent");	
        contentPane.setHref("include/load_home.php");
	}
}

function processLogout() {	
	var postObj = {
        url: "include/logout.php",
        handleAs: "json",
        load: function(response) {
                if (response.valid) {   
                	dojo.byId("usermenu").innerHTML = "<ul>\n" +
						"<li><a href=\"javascript:showLoginDialog();\">Login</a></li>\n" +
						"</ul>";
                } else {
                	alert("Error logging out");
                }
        },
        error: function(data){
                alert("Error logging in: " + data);
        },
        timeout: 2000
    };

	dojo.xhrPost(postObj);
	/* load home page */
    var contentPane = dijit.byId("loadedContent");	
    contentPane.setHref("include/load_home.php");
}

function showLoginDialog() {
	dijit.byId('loginDialog').show();
	dijit.byId('loginUsername').focus();
}

function hideLoginDialog() {
	dijit.byId('loginUsername').displayMessage("");
	dijit.byId('loginPassword').displayMessage("");
	dijit.byId('loginDialog').hide();
}

/* 
 * ************************
 *
 * profile dialog functions
 *
 * ************************
 */
function showProfileDialog() {
	/* TODO: get profile from database from xhrGet */
	dijit.byId('profileDialog').show();
}

function hideProfileDialog() {
	dijit.byId('profileDialog').hide();
}

/* 
 * *************************
 *
 * settings dialog functions
 *
 * *************************
 */
function saveSettings() {
	/* TODO: save settings via xhrGet */
}

function showSettingsDialog() {
	/* TODO: get settings from database from xhrGet */
	dojo.byId('settingsContent').innerHTML = "<p>TBD</p>";
	dijit.byId('settingsDialog').show();
}

function hideSettingsDialog() {
	dijit.byId('settingsDialog').hide();
}

/* 
 * ***************************
 *
 * quick post dialog functions
 *
 * ***************************
 */
function saveQuickPost() {
    var titleWidget = dijit.byId('quickPostTitle');
	var titleValue = titleWidget.getValue();	
	var categoryWidget = dijit.byId('quickPostCategories');
	var categoryValue = categoryWidget.getValue();	
	var dateWidget = dijit.byId('quickPostDate');
	var tempDate = new Date(dateWidget.getValue());
	var dateValue = tempDate.getFullYear() + "-" + tempDate.getMonth() + "-" + tempDate.getDate();	
	var textWidget = dijit.byId('quickPostText');
	var textValue = textWidget.getValue();
	var postIdWidget = dijit.byId('quickPostCurrentId');
	var postIdValue = postIdWidget.getValue();

	var myContent = {};
    // are we editing a post
	if (postIdValue  != "") {
	   // yes, set type to update
    	myContent['id'] = postIdValue;
    } else {
  	    // no, set type to new
    	myContent['id'] = "";
    }
	myContent['title'] = titleValue;
	myContent['category'] = new Array(categoryValue);
	myContent['date'] = dateValue;
	myContent['text'] = textValue;
	
	var postObj = {
        content:  myContent,
        url: "include/submit_quick_post.php",
        handleAs: "json",
        load: function(response) {
                if (response.valid) {
                    if (postIdValue  == "") {
                	    dojo.byId('quickPostResponse').innerHTML = "A new post has been succesfully created";
                	    postIdWidget.setValue("");
           	            dijit.byId("quickPostSaveButton").setDisabled(true);
                	} else {
                    	dojo.byId('quickPostResponse').innerHTML = "The post has been succesfully updated";
                    }
                } else {
                	dojo.byId('quickPostResponse').innerHTML = "Error creating post";
                }
                dojo.fx.chain([
                	dojo.fadeOut({
                		node: dojo.byId("quickPostResponse"),
                		duration: 500
                	}),
                	dojo.fadeIn({
                		node: dojo.byId("quickPostResponse"),
                		duration: 500
                	})
				]).play()
        },
        error: function(data){
                alert("Error submitting post: " + data);
        },
        timeout: 2000
    };

	if (titleValue == "") {		
		titleWidget.displayMessage("A title is required.");
	} else {
		dojo.xhrGet(postObj);
	}

}

function editPost() {
    var postid = editPost.arguments[0];
    var titleWidget = dijit.byId('quickPostTitle');
	var categoryWidget = dijit.byId('quickPostCategories');
	var dateWidget = dijit.byId('quickPostDate');
	var textWidget = dijit.byId('quickPostText');
	var postIdWidget = dijit.byId('quickPostCurrentId');
   
    var myContent = {};
	myContent['id'] = postid;

    var getObj = {
        url: "include/get_blog_entry.php",
        content: myContent,
        handleAs: "json",
        load: function(response) {
            if (response.valid) {
               	titleWidget.setValue(response.title);
                dojo.byId('quickPostCategories').innerHTML = response.categories;
                dateWidget.setValue(new Date(response.date));
                textWidget.setValue(response.text);
                postIdWidget.setValue(postid);   
            } else {
              	alert("Failed to load post");
            }
        },
        error: function(data){
                alert("Error loading post: " + data);
        },
        timeout: 2000
    };

	if (postid == "") {		
		alert("A postid has not been specified");		
	} else {
	  	dojo.xhrGet(getObj);    	  	 	
	}

	dijit.byId('quickPostDialog').show();
}

function deletePost() {
    var postid = deletePost.arguments[0];
    var myContent = {};
	myContent['id'] = postid;

    var postObj = {
        url: "include/submit_delete_post.php",
        content: myContent,
        handleAs: "json",
        load: function(response) {
            if (response.valid) {
               	alert("Succesfully delete post");
            } else {
              	alert("Failed to delete post");
            }
        },
        error: function(data){
                alert("Error deleting post: " + data);
        },
        timeout: 2000
    };

	if (postid == "") {		
		alert("A postid has not been specified");
	} else {
	    if (confirm("Are you sure you want to delete this post?")) {
    		dojo.xhrPost(postObj);
    		// TODO: update recent entries
    		
    		// redirect to home page
    		var contentPane = dijit.byId("loadedContent");	
        	contentPane.setHref("include/load_home.php");
        }
	}
}
   
function showQuickPostDialog() {
    // load categories
	var getObj = {
        url: "include/load_categories.php",
        handleAs: "text",
        load: function(response) {
                dojo.byId('quickPostCategories').innerHTML = response;
        },
        error: function(data){
                alert("Error submitting search: " + data);
        },
        timeout: 2000
    };
    
	dojo.xhrGet(getObj);

	dijit.byId('quickPostDialog').show();
}

function hideQuickPostDialog() {
	dijit.byId('quickPostDialog').hide();
	dojo.byId('quickPostResponse').innerHTML = "&nbsp;";
}

/* 
 * ************************
 *
 * contact dialog functions
 *
 * ************************
 */
function processContact() {

	var nameWidget = dijit.byId('contactName');
	var nameValue = nameWidget.getValue();	
	var emailWidget = dijit.byId('contactEmail');
	var emailValue = emailWidget.getValue();	
	var messageWidget = dijit.byId('contactMessage');
	var messageValue = messageWidget.getValue();	

	var myContent = {};
	myContent['name'] = nameValue;
	myContent['email'] = emailValue;
	myContent['message'] = messageValue;
	
	var postObj = {
        content:  myContent,
        url: "include/submit_contact.php",
        handleAs: "json",
        load: function(response) {
                if (response.valid) {
                    hideContactDialog();
                	messageWidget.setValue("");                   	              
                } else {
                	alert("Error submitting contact information!");
                }
        },
        error: function(data){
                alert("Error submitting contact information: " + data);
        },
        timeout: 2000
    };

	if (nameValue == "") {		
		nameWidget.displayMessage("Your name is required");
	} else if (emailValue == "") {
	    emailWidget.displayMessage("Your email is required.");
	} else {
		dojo.xhrPost(postObj);
		alert("Thankyou " + nameValue + ", your message has been sent.");
	}
}

function showContactDialog() {
	dijit.byId('contactDialog').show();
}	

function hideContactDialog() {
	dijit.byId('contactDialog').hide();
}


