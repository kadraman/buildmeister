window.addEvent('domready', function() {

	new FormValidator($('userEditForm'), "Successfully updated user information, redirecting to home page...",
		{
			redirect: true,
			redirectURL: CONFIG.rewrite_prefix + "/users/view/"
		}
	);
	
});	
